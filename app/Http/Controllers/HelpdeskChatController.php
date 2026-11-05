<?php

namespace App\Http\Controllers;

use App\Models\AdminChatMessage;
use App\Models\AdminChatThread;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HelpdeskChatController extends Controller
{
    /**
     * Display the Helpdesk Chat view.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->isAdmin()) {
            return $this->adminIndex($request, $user);
        }

        return $this->userIndex($request, $user);
    }

    /**
     * User view: single direct thread with Administrator.
     */
    protected function userIndex(Request $request, User $user)
    {
        $thread = AdminChatThread::firstOrCreate(
            ['user_id' => $user->id],
            [
                'subjek' => 'Bantuan & Konsultasi SIM Kurikulum',
                'status' => 'open',
                'last_message_at' => now(),
                'last_message_preview' => 'Sesi bantuan baru dimulai.',
            ]
        );

        // Mark incoming messages as read for this user
        $thread->markAsReadForUser();

        $messages = $thread->messages()->with('sender.peran')->oldest('created_at')->get();

        // System Administrator profiles for display
        $adminUsers = User::whereHas('peran', fn($q) => $q->where('nama_peran', 'like', '%admin%'))
            ->get();

        return view('helpdesk.index', [
            'currentUser' => $user,
            'isAdmin' => false,
            'activeThread' => $thread,
            'messages' => $messages,
            'adminUsers' => $adminUsers,
            'threads' => collect([$thread]),
            'filterStatus' => 'all',
            'searchQuery' => '',
        ]);
    }

    /**
     * Administrator view: inbox list of all user threads and selected conversation.
     */
    protected function adminIndex(Request $request, User $user)
    {
        $query = AdminChatThread::with(['user.peran', 'user.unit', 'latestMessage.sender']);

        // Search filter
        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                       ->orWhere('username', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('subjek', 'like', "%{$search}%")
                ->orWhere('last_message_preview', 'like', "%{$search}%");
            });
        }

        // Status filter
        $filterStatus = $request->get('status', 'all');
        if ($filterStatus === 'unread') {
            $query->where('unread_for_admin', '>', 0);
        } elseif (in_array($filterStatus, ['open', 'resolved'])) {
            $query->where('status', $filterStatus);
        }

        // Order by latest message
        $threads = $query->orderByDesc('last_message_at')->get();

        // Determine active thread
        $activeThread = null;
        if ($request->has('thread_id')) {
            $activeThread = AdminChatThread::with(['user.peran', 'user.unit'])->find($request->get('thread_id'));
        }

        if (!$activeThread && $threads->isNotEmpty()) {
            $activeThread = $threads->first();
        }

        $messages = collect();
        if ($activeThread) {
            $activeThread->markAsReadForAdmin();
            $messages = $activeThread->messages()->with('sender.peran')->oldest('created_at')->get();
        }

        return view('helpdesk.index', [
            'currentUser' => $user,
            'isAdmin' => true,
            'activeThread' => $activeThread,
            'messages' => $messages,
            'threads' => $threads,
            'adminUsers' => collect([$user]),
            'filterStatus' => $filterStatus,
            'searchQuery' => $request->get('q', ''),
        ]);
    }

    /**
     * Send a new message to the thread (with optional attachment).
     */
    public function sendMessage(Request $request, $threadId)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }

        $thread = AdminChatThread::with('user')->findOrFail($threadId);

        // Security check
        if (!$user->isAdmin() && $thread->user_id !== $user->id) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
            }
            return back()->with('error', 'Anda tidak memiliki hak akses pada percakapan ini.');
        }

        $request->validate([
            'pesan' => 'nullable|string|max:5000',
            'lampiran' => 'nullable|file|mimes:pdf,docx,doc,xlsx,xls,csv,txt,zip,rar,7z,jpg,jpeg,png,gif,webp,svg,ppt,pptx|max:25600',
        ], [
            'lampiran.mimes' => 'Format berkas tidak didukung. Lampirkan dokumen (PDF, Word, Excel, ZIP) atau gambar (PNG, JPG, WebP).',
            'lampiran.max' => 'Ukuran berkas tidak boleh melebihi 25 MB.',
        ]);

        if (empty(trim($request->pesan ?? '')) && !$request->hasFile('lampiran')) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Pesan atau lampiran berkas wajib diisi.'], 422);
            }
            return back()->with('error', 'Silakan ketik pesan atau pilih berkas lampiran.');
        }

        $filePath = null;
        $fileName = null;
        $fileType = null;
        $fileExtension = null;
        $fileSize = null;

        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $originalName = $file->getClientOriginalName();
            $fileExtension = strtolower($file->getClientOriginalExtension());
            $bytes = $file->getSize();

            $fileSize = $bytes >= 1048576
                ? round($bytes / 1048576, 2) . ' MB'
                : round($bytes / 1024, 1) . ' KB';

            if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])) {
                $fileType = 'image';
            } elseif ($fileExtension === 'pdf') {
                $fileType = 'pdf';
            } elseif (in_array($fileExtension, ['doc', 'docx'])) {
                $fileType = 'word';
            } elseif (in_array($fileExtension, ['xls', 'xlsx', 'csv'])) {
                $fileType = 'excel';
            } elseif (in_array($fileExtension, ['zip', 'rar', '7z'])) {
                $fileType = 'archive';
            } else {
                $fileType = 'document';
            }

            $storageDir = "chat_attachments/{$thread->id}";
            $storedName = time() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $fileExtension;
            $filePath = $file->storeAs($storageDir, $storedName, 'public');
            $fileName = $originalName;
        }

        $message = AdminChatMessage::create([
            'thread_id' => $thread->id,
            'sender_id' => $user->id,
            'pesan' => $request->pesan ? trim($request->pesan) : null,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_type' => $fileType,
            'file_extension' => $fileExtension,
            'file_size' => $fileSize,
            'is_read' => false,
        ]);

        // Preview snippet
        $preview = $request->pesan ? Str::limit($request->pesan, 75) : ('📎 Lampiran: ' . ($fileName ?? 'Berkas'));

        // Update thread status & unread counters
        $threadUpdates = [
            'last_message_at' => now(),
            'last_message_preview' => $preview,
        ];

        if ($user->isAdmin()) {
            $threadUpdates['unread_for_user'] = $thread->unread_for_user + 1;
            $thread->update($threadUpdates);

            // Notify user
            NotificationService::send(
                $thread->user_id,
                'Balasan Administrator',
                "Administrator membalas: \"{$preview}\"",
                'chat_admin',
                route('helpdesk.index')
            );
        } else {
            $threadUpdates['unread_for_admin'] = $thread->unread_for_admin + 1;
            // If ticket was resolved, automatically reopen when user messages
            if ($thread->status === 'resolved') {
                $threadUpdates['status'] = 'open';
            }
            $thread->update($threadUpdates);

            // Notify all admins
            NotificationService::notifyAdmins(
                "Pesan Bantuan: {$user->name}",
                "{$user->name}: \"{$preview}\"",
                'chat_admin',
                route('helpdesk.index', ['thread_id' => $thread->id])
            );
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pesan berhasil dikirim.',
                'data' => [
                    'id' => $message->id,
                    'pesan' => $message->pesan,
                    'sender_name' => $user->name,
                    'is_admin' => $user->isAdmin(),
                    'created_at' => $message->created_at->format('H:i'),
                    'file_name' => $message->file_name,
                    'file_url' => $message->file_url,
                    'file_type' => $message->file_type,
                    'file_size' => $message->file_size,
                    'is_image' => $message->isImage(),
                ]
            ]);
        }

        return redirect()->route('helpdesk.index', $user->isAdmin() ? ['thread_id' => $thread->id] : [])
            ->with('success', 'Pesan Anda berhasil dikirim ke Administrator.');
    }

    /**
     * Polling endpoint to fetch latest messages without page reload.
     */
    public function pollMessages(Request $request, $threadId)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false], 401);
        }

        $thread = AdminChatThread::findOrFail($threadId);

        if (!$user->isAdmin() && $thread->user_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Forbidden'], 403);
        }

        // Mark as read
        if ($user->isAdmin()) {
            $thread->markAsReadForAdmin();
        } else {
            $thread->markAsReadForUser();
        }

        $afterId = (int) $request->get('after_id', 0);
        $newMessages = $thread->messages()
            ->with('sender.peran')
            ->where('id', '>', $afterId)
            ->get();

        $formatted = $newMessages->map(function ($msg) use ($user) {
            return [
                'id' => $msg->id,
                'sender_id' => $msg->sender_id,
                'sender_name' => $msg->sender->name ?? 'User',
                'is_sender_admin' => $msg->isSenderAdmin(),
                'is_me' => $msg->sender_id === $user->id,
                'pesan' => $msg->pesan,
                'created_at' => $msg->created_at->format('H:i'),
                'has_file' => $msg->hasAttachment(),
                'file_name' => $msg->file_name,
                'file_url' => $msg->file_url,
                'file_type' => $msg->file_type,
                'file_size' => $msg->file_size,
                'is_image' => $msg->isImage(),
                'file_badge' => $msg->file_badge,
                'download_url' => route('helpdesk.download', $msg->id),
            ];
        });

        return response()->json([
            'success' => true,
            'messages' => $formatted,
            'thread_status' => $thread->status,
        ]);
    }

    /**
     * Download message attachment.
     */
    public function downloadAttachment($messageId)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $message = AdminChatMessage::with('thread')->findOrFail($messageId);

        if (!$user->isAdmin() && $message->thread->user_id !== $user->id) {
            abort(403, 'Akses lampiran ditolak.');
        }

        if (!$message->file_path || !Storage::disk('public')->exists($message->file_path)) {
            return back()->with('error', 'Berkas lampiran tidak ditemukan atau telah dihapus.');
        }

        return Storage::disk('public')->download($message->file_path, $message->file_name);
    }

    /**
     * Toggle ticket status (Open <-> Resolved).
     */
    public function toggleStatus(Request $request, $threadId)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $thread = AdminChatThread::findOrFail($threadId);

        if (!$user->isAdmin() && $thread->user_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        $newStatus = $thread->status === 'resolved' ? 'open' : 'resolved';
        $thread->update(['status' => $newStatus]);

        $statusText = $newStatus === 'resolved' ? 'Tandai Selesai' : 'Dibuka Kembali';

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'status' => $newStatus, 'message' => "Status tiket diperbarui menjadi: {$statusText}."]);
        }

        return back()->with('success', "Status sesi percakapan diperbarui menjadi {$statusText}.");
    }
}

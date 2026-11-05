<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\UsulanPerubahan;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RealtimeController extends Controller
{
    /**
     * Poll / sync endpoint returning live notifications and dashboard metrics.
     */
    public function sync(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => 'unauthenticated'], 401);
        }

        // Otomatis cek tenggat waktu (deadline) agenda pengguna dan buat notifikasi jika telah jatuh tempo
        NotificationService::checkAndNotifyUserDeadlines($user->id);

        $lastId = (int) $request->input('last_notification_id', 0);

        $unreadCount = Notifikasi::where('user_id', $user->id)
            ->where('dibaca', false)
            ->count();

        $newNotifications = Notifikasi::where('user_id', $user->id)
            ->when($lastId > 0, function ($q) use ($lastId) {
                $q->where('id', '>', $lastId);
            })
            ->latest()
            ->take(5)
            ->get();

        $recentNotifications = Notifikasi::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($n) {
                return [
                    'id' => $n->id,
                    'judul' => $n->judul,
                    'pesan' => $n->pesan,
                    'tipe' => $n->tipe,
                    'tautan' => $n->tautan,
                    'dibaca' => $n->dibaca,
                    'waktu' => $n->created_at->diffForHumans(),
                ];
            });

        // Live stats for dashboard
        $stats = [
            'unread_count' => $unreadCount,
            'pending_proposals' => UsulanPerubahan::when(!$user->isYayasan(), function ($q) use ($user) {
                $q->where('unit_id', $user->unit_id);
            })->where('status', 'Menunggu Persetujuan')->count(),
            'approved_proposals' => UsulanPerubahan::when(!$user->isYayasan(), function ($q) use ($user) {
                $q->where('unit_id', $user->unit_id);
            })->where('status', 'Disetujui')->count(),
        ];

        return response()->json([
            'unread_count' => $unreadCount,
            'new_notifications' => $newNotifications,
            'recent_notifications' => $recentNotifications,
            'stats' => $stats,
            'timestamp' => now()->timestamp,
        ]);
    }

    /**
     * Mark a single notification as read.
     */
    public function markAsRead(Request $request, Notifikasi $notifikasi)
    {
        if ($notifikasi->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notifikasi->update([
            'dibaca' => true,
            'waktu_baca' => now(),
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read for current user.
     */
    public function markAllAsRead(Request $request)
    {
        Notifikasi::where('user_id', Auth::id())
            ->where('dibaca', false)
            ->update([
                'dibaca' => true,
                'waktu_baca' => now(),
            ]);

        return response()->json(['success' => true]);
    }

    /**
     * Server-Sent Events (SSE) Stream for real-time notification push.
     */
    public function stream(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response('Unauthorized', 401);
        }

        // Release PHP session lock immediately so concurrent web requests are not blocked
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }

        $userId = $user->id;
        $response = new StreamedResponse(function () use ($userId) {
            $unreadCount = Notifikasi::where('user_id', $userId)->where('dibaca', false)->count();
            $newNotifications = Notifikasi::where('user_id', $userId)
                ->where('dibaca', false)
                ->latest()
                ->take(5)
                ->get();

            $payload = json_encode([
                'type' => 'sync',
                'unread_count' => $unreadCount,
                'notifications' => $newNotifications,
            ]);
            echo "data: {$payload}\n\n";
            ob_flush();
            flush();
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'close');
        $response->headers->set('X-Accel-Buffering', 'no');

        return $response;
    }
}


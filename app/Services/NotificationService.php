<?php

namespace App\Services;

use App\Models\JurnalKerja;
use App\Models\Notifikasi;
use App\Models\User;

class NotificationService
{
    /**
     * Send notification to one or multiple users.
     */
    public static function send($userIds, string $judul, string $pesan, string $tipe = 'info', ?string $tautan = null, ?array $data = null): void
    {
        $userIds = is_array($userIds) ? $userIds : [$userIds];
        $userIds = array_unique(array_filter($userIds));

        foreach ($userIds as $uid) {
            Notifikasi::create([
                'user_id' => $uid,
                'judul' => $judul,
                'pesan' => $pesan,
                'tipe' => $tipe,
                'tautan' => $tautan,
                'data_tambahan' => $data,
                'dibaca' => false,
            ]);
        }
    }

    /**
     * Send notification to Kepala Sekolah & Waka Kurikulum of a unit, and Pengurus Yayasan.
     */
    public static function notifyKepsekAndYayasan($unitId, string $judul, string $pesan, string $tipe = 'info', ?string $tautan = null, ?array $data = null): void
    {
        $leadershipIds = User::where('unit_id', $unitId)
            ->whereHas('peran', function ($q) {
                $q->where('nama_peran', 'like', '%kepala%')
                  ->orWhere('nama_peran', 'like', '%waka%');
            })
            ->pluck('id')
            ->toArray();

        $yayasanIds = User::whereHas('peran', function ($q) {
            $q->where('nama_peran', 'like', '%yayasan%');
        })
        ->pluck('id')
        ->toArray();

        self::send(array_merge($leadershipIds, $yayasanIds), $judul, $pesan, $tipe, $tautan, $data);
    }

    /**
     * Send notification to all system administrators.
     */
    public static function notifyAdmins(string $judul, string $pesan, string $tipe = 'chat_admin', ?string $tautan = null, ?array $data = null): void
    {
        $adminIds = User::whereHas('peran', function ($q) {
            $q->where('nama_peran', 'like', '%admin%');
        })
        ->pluck('id')
        ->toArray();

        if (!empty($adminIds)) {
            self::send($adminIds, $judul, $pesan, $tipe, $tautan, $data);
        }
    }

    /**
     * Check user's tasks and send notification when deadline is reached or overdue.
     */
    public static function checkAndNotifyUserDeadlines($userId): int
    {
        $today = now()->toDateString();
        $endOfDay = $today . ' 23:59:59';

        $dueTasks = JurnalKerja::where('user_id', $userId)
            ->where('status', '!=', 'selesai')
            ->where(function ($q) {
                $q->where('notif_deadline_sent', false)
                  ->orWhereNull('notif_deadline_sent')
                  ->orWhere('notif_deadline_sent', 0);
            })
            ->where(function ($q) use ($today, $endOfDay) {
                $q->where(function ($q2) use ($today, $endOfDay) {
                    $q2->whereNotNull('tanggal_selesai')
                       ->where(function ($q3) use ($today, $endOfDay) {
                           $q3->where('tanggal_selesai', '<=', $endOfDay)
                              ->orWhereDate('tanggal_selesai', '<=', $today);
                       });
                })->orWhere(function ($q2) use ($today, $endOfDay) {
                    $q2->whereNull('tanggal_selesai')
                       ->whereNotNull('tanggal_target')
                       ->where(function ($q3) use ($today, $endOfDay) {
                           $q3->where('tanggal_target', '<=', $endOfDay)
                              ->orWhereDate('tanggal_target', '<=', $today);
                       });
                });
            })
            ->get();

        $count = 0;
        foreach ($dueTasks as $task) {
            $deadline = $task->deadline_date?->format('d M Y') ?? 'Hari ini';
            $isOverdue = $task->isOverdue();
            $title = $isOverdue ? "⏰ Tenggat Waktu Terlewat: {$task->judul}" : "⏰ Batas Waktu Hari Ini: {$task->judul}";
            $msg = $isOverdue
                ? "Agenda '{$task->judul}' telah melewati tenggat waktu ({$deadline}). Silakan periksa catatan dan segera selesaikan tugas Anda."
                : "Agenda '{$task->judul}' telah mencapai batas waktu hari ini ({$deadline}). Pastikan persiapan dan pelaksanaan berjalan lancar.";

            self::send($userId, $title, $msg, 'deadline_reminder', route('jurnal.index'));
            $task->update(['notif_deadline_sent' => true]);
            $count++;
        }

        return $count;
    }
}


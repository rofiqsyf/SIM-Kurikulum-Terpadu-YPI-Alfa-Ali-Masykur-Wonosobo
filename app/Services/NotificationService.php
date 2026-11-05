<?php

namespace App\Services;

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
}


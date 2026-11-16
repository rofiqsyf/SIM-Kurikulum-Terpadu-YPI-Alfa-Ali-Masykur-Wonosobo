<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $now = now();

        // 1. Add Pembina Ekstrakurikuler for MI, SMP, SMA
        $pembinaRoles = [
            [
                'nama_peran' => 'Pembina Ekstrakurikuler MI',
                'deskripsi' => 'Pembina kegiatan ekstrakurikuler dan pengembangan bakat santri unit MI Tahfidz Alfa Ali Masykur.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_peran' => 'Pembina Ekstrakurikuler SMP',
                'deskripsi' => 'Pembina kegiatan ekstrakurikuler dan pengembangan bakat santri unit SMP Alfa Ali Masykur.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_peran' => 'Pembina Ekstrakurikuler SMA',
                'deskripsi' => 'Pembina kegiatan ekstrakurikuler dan pengembangan bakat santri unit SMA Alfa Ali Masykur.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($pembinaRoles as $role) {
            DB::table('peran')->updateOrInsert(
                ['nama_peran' => $role['nama_peran']],
                [
                    'deskripsi' => $role['deskripsi'],
                    'updated_at' => $now,
                ]
            );
        }

        // Fetch target role IDs
        $rolesByNama = DB::table('peran')->pluck('id', 'nama_peran');

        // Fetch units
        $units = DB::table('unit_pendidikan')->get()->keyBy('id');

        // 2. Reassign users having legacy generic roles to their corresponding segmented roles
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            $currentRole = DB::table('peran')->where('id', $user->peran_id)->first();
            if (!$currentRole) continue;

            $roleName = $currentRole->nama_peran;
            $unit = $units->get($user->unit_id);
            $kodeUnit = $unit ? strtoupper($unit->kode_unit ?? '') : '';

            $targetRoleName = null;

            if ($roleName === 'Guru Mata Pelajaran') {
                if (str_contains($kodeUnit, 'MI')) {
                    $targetRoleName = 'Guru MI';
                } elseif (str_contains($kodeUnit, 'SMA')) {
                    $targetRoleName = 'Guru SMA';
                } else {
                    $targetRoleName = 'Guru SMP';
                }
            } elseif ($roleName === 'Kepala Sekolah/Madrasah') {
                if (str_contains($kodeUnit, 'MI')) {
                    $targetRoleName = 'Kepala Sekolah (Kepsek) MI';
                } elseif (str_contains($kodeUnit, 'SMA')) {
                    $targetRoleName = 'Kepala Sekolah (Kepsek) SMA';
                } else {
                    $targetRoleName = 'Kepala Sekolah (Kepsek) SMP';
                }
            } elseif ($roleName === 'Waka Kurikulum') {
                if (str_contains($kodeUnit, 'MI')) {
                    $targetRoleName = 'Waka Kurikulum MI';
                } elseif (str_contains($kodeUnit, 'SMA')) {
                    $targetRoleName = 'Waka Kurikulum SMA';
                } else {
                    $targetRoleName = 'Waka Kurikulum SMP';
                }
            } elseif ($roleName === 'Pembina Ekstrakurikuler') {
                if (str_contains($kodeUnit, 'MI')) {
                    $targetRoleName = 'Pembina Ekstrakurikuler MI';
                } elseif (str_contains($kodeUnit, 'SMA')) {
                    $targetRoleName = 'Pembina Ekstrakurikuler SMA';
                } else {
                    $targetRoleName = 'Pembina Ekstrakurikuler SMP';
                }
            }

            if ($targetRoleName && isset($rolesByNama[$targetRoleName])) {
                DB::table('users')->where('id', $user->id)->update([
                    'peran_id' => $rolesByNama[$targetRoleName],
                    'updated_at' => $now,
                ]);
            }
        }

        // 3. Delete the legacy generic roles
        $legacyRoleNames = [
            'Kepala Sekolah/Madrasah',
            'Guru Mata Pelajaran',
            'Waka Kurikulum',
            'Pembina Ekstrakurikuler',
        ];

        DB::table('peran')->whereIn('nama_peran', $legacyRoleNames)->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $now = now();
        $legacyRoles = [
            ['nama_peran' => 'Kepala Sekolah/Madrasah', 'deskripsi' => 'Pihak yang memimpin unit, mengesahkan kurikulum.'],
            ['nama_peran' => 'Guru Mata Pelajaran', 'deskripsi' => 'Pihak yang mengelola pembelajaran mata pelajaran penugasan.'],
            ['nama_peran' => 'Waka Kurikulum', 'deskripsi' => 'Pihak yang mengkoordinasikan implementasi kurikulum.'],
            ['nama_peran' => 'Pembina Ekstrakurikuler', 'deskripsi' => 'Pihak yang bertanggung jawab atas kegiatan kokurikuler dan ekstrakurikuler unit.'],
        ];

        foreach ($legacyRoles as $r) {
            DB::table('peran')->insertOrIgnore(array_merge($r, ['created_at' => $now, 'updated_at' => $now]));
        }

        DB::table('peran')->whereIn('nama_peran', [
            'Pembina Ekstrakurikuler MI',
            'Pembina Ekstrakurikuler SMP',
            'Pembina Ekstrakurikuler SMA',
        ])->delete();
    }
};

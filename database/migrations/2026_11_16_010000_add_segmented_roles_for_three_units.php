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

        $roles = [
            // Segment 1: MI (Madrasah Ibtidaiyah)
            [
                'nama_peran' => 'Guru MI',
                'deskripsi' => 'Pendidik pengampu mata pelajaran pada unit MI Tahfidz Alfa Ali Masykur.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_peran' => 'Waka Kurikulum MI',
                'deskripsi' => 'Wakil Kepala Bidang Kurikulum pada unit MI Tahfidz Alfa Ali Masykur.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_peran' => 'Kepala Sekolah (Kepsek) MI',
                'deskripsi' => 'Pimpinan madrasah dan penanggung jawab pengesahan kurikulum MI Tahfidz Alfa Ali Masykur.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_peran' => 'Admin 1 MI',
                'deskripsi' => 'Administrator teknis dan pengelola data operasional segment unit MI Tahfidz Alfa Ali Masykur.',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Segment 2: SMP (Sekolah Menengah Pertama)
            [
                'nama_peran' => 'Guru SMP',
                'deskripsi' => 'Pendidik pengampu mata pelajaran pada unit SMP Alfa Ali Masykur.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_peran' => 'Waka Kurikulum SMP',
                'deskripsi' => 'Wakil Kepala Bidang Kurikulum pada unit SMP Alfa Ali Masykur.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_peran' => 'Kepala Sekolah (Kepsek) SMP',
                'deskripsi' => 'Pimpinan sekolah dan penanggung jawab pengesahan kurikulum SMP Alfa Ali Masykur.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_peran' => 'Admin 2 SMP',
                'deskripsi' => 'Administrator teknis dan pengelola data operasional segment unit SMP Alfa Ali Masykur.',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Segment 3: SMA (Sekolah Menengah Atas)
            [
                'nama_peran' => 'Guru SMA',
                'deskripsi' => 'Pendidik pengampu mata pelajaran pada unit SMA Alfa Ali Masykur.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_peran' => 'Waka Kurikulum SMA',
                'deskripsi' => 'Wakil Kepala Bidang Kurikulum pada unit SMA Alfa Ali Masykur.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_peran' => 'Kepala Sekolah (Kepsek) SMA',
                'deskripsi' => 'Pimpinan sekolah dan penanggung jawab pengesahan kurikulum SMA Alfa Ali Masykur.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_peran' => 'Admin 3 SMA',
                'deskripsi' => 'Administrator teknis dan pengelola data operasional segment unit SMA Alfa Ali Masykur.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($roles as $role) {
            DB::table('peran')->updateOrInsert(
                ['nama_peran' => $role['nama_peran']],
                [
                    'deskripsi' => $role['deskripsi'],
                    'updated_at' => $now,
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $roleNames = [
            'Guru MI', 'Waka Kurikulum MI', 'Kepala Sekolah (Kepsek) MI', 'Admin 1 MI',
            'Guru SMP', 'Waka Kurikulum SMP', 'Kepala Sekolah (Kepsek) SMP', 'Admin 2 SMP',
            'Guru SMA', 'Waka Kurikulum SMA', 'Kepala Sekolah (Kepsek) SMA', 'Admin 3 SMA',
        ];

        DB::table('peran')->whereIn('nama_peran', $roleNames)->delete();
    }
};

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
        $adminSistemRole = DB::table('peran')->where('nama_peran', 'Admin Sistem')->first();
        $adminSMPRole = DB::table('peran')->where('nama_peran', 'Admin 2 SMP')->first();
        $unitSMP = DB::table('unit_pendidikan')->where('kode_unit', 'like', '%SMP%')->first();

        if ($adminSistemRole && $adminSMPRole) {
            // Reassign any users with Admin Sistem to Admin 2 SMP
            DB::table('users')->where('peran_id', $adminSistemRole->id)->update([
                'peran_id' => $adminSMPRole->id,
                'unit_id' => $unitSMP ? $unitSMP->id : 2,
                'updated_at' => now(),
            ]);

            // Delete Admin Sistem role
            DB::table('peran')->where('id', $adminSistemRole->id)->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('peran')->insertOrIgnore([
            'nama_peran' => 'Admin Sistem',
            'deskripsi' => 'Pihak yang mengelola akun pengguna, peran, hak akses, dan administrasi sistem global.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
};

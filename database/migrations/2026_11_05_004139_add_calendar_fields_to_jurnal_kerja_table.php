<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jurnal_kerja', function (Blueprint $table) {
            $table->date('tanggal_mulai')->nullable()->after('tanggal_target');
            $table->date('tanggal_selesai')->nullable()->after('tanggal_mulai');
            $table->string('warna', 30)->default('#2563eb')->after('prioritas');
            $table->text('catatan')->nullable()->after('catatan_refleksi');
            $table->boolean('notif_deadline_sent')->default(false)->after('waktu_pengingat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jurnal_kerja', function (Blueprint $table) {
            $table->dropColumn(['tanggal_mulai', 'tanggal_selesai', 'warna', 'catatan', 'notif_deadline_sent']);
        });
    }
};

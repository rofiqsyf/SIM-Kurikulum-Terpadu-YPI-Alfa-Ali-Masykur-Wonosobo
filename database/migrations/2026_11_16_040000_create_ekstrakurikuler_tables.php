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
        // 1. Tabel Anggota Siswa / Santri Peserta Ekstrakurikuler
        Schema::create('ekstrakurikuler_anggota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ekstrakurikuler_id')->constrained('kegiatan_ekstrakurikuler')->onDelete('cascade');
            $table->string('nama_siswa', 150);
            $table->string('nis', 50)->nullable();
            $table->string('kelas', 50); // misal: 7A, 8B, 10 MIPA 1, Kelas 4 MI
            $table->string('jenis_kelamin', 10)->default('L'); // L / P
            $table->string('status_keaktifan', 30)->default('Aktif'); // Aktif, Kurang Aktif, Izin/Cuti
            $table->string('nilai_kualitatif', 10)->nullable()->default('B'); // A (Sangat Baik), B (Baik), C (Cukup)
            $table->text('catatan_bakat')->nullable(); // misal: "Pukulan kendang mantap, daya tahan fisik kuat"
            $table->timestamps();
        });

        // 2. Tabel Jadwal & Sesi Pertemuan Latihan Ekstrakurikuler
        Schema::create('ekstrakurikuler_jadwal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ekstrakurikuler_id')->constrained('kegiatan_ekstrakurikuler')->onDelete('cascade');
            $table->integer('pertemuan_ke')->default(1);
            $table->date('tanggal');
            $table->string('jam_mulai', 20)->default('15:30');
            $table->string('jam_selesai', 20)->default('17:00');
            $table->string('tempat', 150)->nullable()->default('Lapangan / Aula Utama');
            $table->string('materi_pembinaan', 255);
            $table->text('catatan_evaluasi')->nullable();
            $table->string('status', 30)->default('Terlaksana'); // Terlaksana, Dijadwalkan, Ditunda, Diliburkan
            $table->timestamps();
        });

        // 3. Tabel Presensi Kehadiran Santri per Pertemuan
        Schema::create('ekstrakurikuler_presensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_id')->constrained('ekstrakurikuler_jadwal')->onDelete('cascade');
            $table->foreignId('anggota_id')->constrained('ekstrakurikuler_anggota')->onDelete('cascade');
            $table->string('status_kehadiran', 20)->default('Hadir'); // Hadir, Sakit, Izin, Alpa
            $table->string('catatan', 255)->nullable();
            $table->timestamps();

            $table->unique(['jadwal_id', 'anggota_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ekstrakurikuler_presensi');
        Schema::dropIfExists('ekstrakurikuler_jadwal');
        Schema::dropIfExists('ekstrakurikuler_anggota');
    }
};

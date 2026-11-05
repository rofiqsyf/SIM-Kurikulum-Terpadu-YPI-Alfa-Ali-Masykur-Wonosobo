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
        Schema::create('arsip_dokumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->nullable()->constrained('unit_pendidikan')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('kode_dokumen', 50)->unique();
            $table->string('judul_dokumen', 200);
            $table->string('kategori', 50); // kosp, atp, modul_ajar, p5_ra, sk_pengesahan, instrumen_asesmen
            $table->string('tahun_ajaran', 20)->default('2024/2025');
            $table->string('semester', 20)->default('Ganjil'); // Ganjil, Genap, Tahunan
            $table->string('tingkat_fase', 50)->nullable(); // Fase A, Fase D, Kelas 7, dll.
            $table->string('status_verifikasi', 30)->default('Terverifikasi'); // Terverifikasi, Perlu Dilengkapi, Draft
            $table->string('nama_pengawas', 150)->nullable();
            $table->text('catatan_supervisi')->nullable();
            $table->string('file_path', 255)->nullable();
            $table->string('file_size', 50)->nullable()->default('2.4 MB PDF');
            $table->date('tanggal_arsip');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip_dokumen');
    }
};

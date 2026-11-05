<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jurnal_kerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('judul', 255);
            $table->string('kategori', 50)->default('kbm'); // kbm, administrasi, penilaian, bimbingan, rapat, umum
            $table->date('tanggal_target')->nullable();
            $table->string('prioritas', 20)->default('sedang'); // tinggi, sedang, rendah
            $table->string('status', 20)->default('belum'); // belum, proses, selesai
            $table->text('catatan_refleksi')->nullable();
            $table->string('waktu_pengingat', 50)->nullable(); // Pagi (07.00), Siang (13.00), Sore (16.00)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurnal_kerja');
    }
};


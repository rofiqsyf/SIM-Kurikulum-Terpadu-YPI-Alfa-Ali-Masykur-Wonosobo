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
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('judul');
            $table->text('pesan');
            $table->string('tipe', 50)->default('info'); // proposal_created, proposal_approved, proposal_rejected, jurnal_created, tahfidz_created, system
            $table->string('tautan')->nullable();
            $table->boolean('dibaca')->default(false);
            $table->timestamp('waktu_baca')->nullable();
            $table->json('data_tambahan')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'dibaca']);
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};

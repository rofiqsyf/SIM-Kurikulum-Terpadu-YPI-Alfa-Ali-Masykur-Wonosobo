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
        Schema::create('admin_chat_threads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('subjek')->default('Konsultasi & Bantuan Kurikulum');
            $table->string('kategori')->default('umum'); // umum, teknis, silabus, akun
            $table->string('status')->default('open'); // open, resolved
            $table->unsignedInteger('unread_for_user')->default(0);
            $table->unsignedInteger('unread_for_admin')->default(0);
            $table->timestamp('last_message_at')->nullable();
            $table->text('last_message_preview')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index('last_message_at');
        });

        Schema::create('admin_chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thread_id')->constrained('admin_chat_threads')->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->text('pesan')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_type', 30)->nullable(); // image, pdf, word, excel, archive, document
            $table->string('file_extension', 10)->nullable(); // png, jpg, pdf, docx, xlsx, etc.
            $table->string('file_size', 50)->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->index(['thread_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_chat_messages');
        Schema::dropIfExists('admin_chat_threads');
    }
};


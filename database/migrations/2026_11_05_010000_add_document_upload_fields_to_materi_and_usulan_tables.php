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
        Schema::table('materi', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('media_ajar');
            $table->string('file_name')->nullable()->after('file_path');
            $table->string('file_type', 20)->nullable()->after('file_name');
            $table->string('file_size', 50)->nullable()->after('file_type');
        });

        Schema::table('usulan_perubahan', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('deskripsi_usulan');
            $table->string('file_name')->nullable()->after('file_path');
            $table->string('file_type', 20)->nullable()->after('file_name');
            $table->string('file_size', 50)->nullable()->after('file_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materi', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'file_name', 'file_type', 'file_size']);
        });

        Schema::table('usulan_perubahan', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'file_name', 'file_type', 'file_size']);
        });
    }
};

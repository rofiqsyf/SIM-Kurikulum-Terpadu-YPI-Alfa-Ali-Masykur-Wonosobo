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
        // 1. Tabel Peran
        Schema::create('peran', function (Blueprint $table) {
            $table->id();
            $table->string('nama_peran', 50)->unique();
            $table->string('deskripsi', 255)->nullable();
            $table->timestamps();
        });

        // 2. Tabel Jenjang
        Schema::create('jenjang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jenjang', 10)->unique(); // MI, SMP, SMA
            $table->timestamps();
        });

        // 3. Tabel Unit Pendidikan
        Schema::create('unit_pendidikan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenjang_id')->constrained('jenjang')->onDelete('cascade');
            $table->string('nama_unit', 100);
            $table->string('kode_unit', 20)->nullable();
            $table->string('kepala_sekolah', 100)->nullable();
            $table->timestamps();
        });

        // 4. Tabel Fase
        Schema::create('fase', function (Blueprint $table) {
            $table->id();
            $table->string('nama_fase', 20)->unique(); // Fase A, Fase B, Fase C, Fase D, Fase E, Fase F
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();
        });

        // 5. Tabel Kelas
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenjang_id')->constrained('jenjang')->onDelete('cascade');
            $table->foreignId('fase_id')->nullable()->constrained('fase')->nullOnDelete();
            $table->unsignedTinyInteger('tingkat'); // 1-6 MI, 7-9 SMP, 10-12 SMA
            $table->string('nama_kelas', 50)->nullable();
            $table->timestamps();
        });

        // Tambahkan kolom pelengkap pada tabel users (Pengguna)
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('peran_id')->nullable()->after('id')->constrained('peran')->nullOnDelete();
            $table->foreignId('unit_id')->nullable()->after('peran_id')->constrained('unit_pendidikan')->nullOnDelete();
            $table->string('username', 100)->nullable()->unique()->after('name');
            $table->string('nip', 50)->nullable()->after('username');
            $table->string('jabatan', 100)->nullable()->after('email');
            $table->string('avatar_url', 255)->nullable()->after('jabatan');
            $table->boolean('status_aktif')->default(true)->after('avatar_url');
        });

        // 6. Tabel Kurikulum
        Schema::create('kurikulum', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained('unit_pendidikan')->onDelete('cascade');
            $table->string('nama_kurikulum', 150);
            $table->text('deskripsi')->nullable();
            $table->string('tahun_ajaran', 20)->default('2024/2025');
            $table->string('semester', 20)->default('Ganjil');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 7. Tabel Mata Pelajaran
        Schema::create('mata_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kurikulum_id')->constrained('kurikulum')->onDelete('cascade');
            $table->string('kode_mapel', 20);
            $table->string('nama_mapel', 150);
            $table->string('kategori', 50)->default('Intrakurikuler'); // Intrakurikuler, Muatan Pesantren, Peminatan
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // 8. Tabel Mapel_Kelas (Relasi N:M Mata Pelajaran ke Kelas)
        Schema::create('mapel_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mapel_id')->constrained('mata_pelajaran')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->timestamps();
        });

        // 9. Tabel Penugasan Guru
        Schema::create('penugasan_guru', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('mapel_id')->constrained('mata_pelajaran')->onDelete('cascade');
            $table->unsignedSmallInteger('beban_jp')->default(24);
            $table->unsignedSmallInteger('jumlah_rombel')->default(8);
            $table->timestamps();
        });

        // 10. Tabel Capaian Pembelajaran (CP)
        Schema::create('capaian_pembelajaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mapel_id')->constrained('mata_pelajaran')->onDelete('cascade');
            $table->foreignId('fase_id')->nullable()->constrained('fase')->nullOnDelete();
            $table->string('kode_cp', 30);
            $table->string('elemen', 100)->nullable(); // Bilangan, Aljabar, Geometri, Data
            $table->text('deskripsi_cp');
            $table->unsignedSmallInteger('total_beban_jp')->default(32);
            $table->timestamps();
        });

        // 11. Tabel Tujuan Pembelajaran (TP)
        Schema::create('tujuan_pembelajaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cp_id')->constrained('capaian_pembelajaran')->onDelete('cascade');
            $table->string('kode_tp', 30);
            $table->text('deskripsi_tp');
            $table->unsignedSmallInteger('beban_jp')->default(8);
            $table->string('periode', 100)->nullable(); // Bulan Juli - Agustus
            $table->string('status_pengesahan', 30)->default('Disetujui'); // Disetujui, Draft, Perlu Revisi
            $table->timestamps();
        });

        // 12. Tabel Materi
        Schema::create('materi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tp_id')->constrained('tujuan_pembelajaran')->onDelete('cascade');
            $table->string('kode_materi', 30)->nullable(); // Materi 7.1.1
            $table->string('judul_materi', 200);
            $table->text('isi_materi')->nullable();
            $table->unsignedSmallInteger('beban_jp')->default(4);
            $table->string('media_ajar', 255)->nullable();
            $table->timestamps();
        });

        // 13. Tabel Kegiatan Kokurikuler
        Schema::create('kegiatan_kokurikuler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained('unit_pendidikan')->onDelete('cascade');
            $table->string('nama_kegiatan', 150);
            $table->string('tema', 150)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('alokasi_waktu', 100)->nullable();
            $table->foreignId('pengelola_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // 14. Tabel Kegiatan Ekstrakurikuler
        Schema::create('kegiatan_ekstrakurikuler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained('unit_pendidikan')->onDelete('cascade');
            $table->foreignId('pembina_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama_kegiatan', 150);
            $table->string('kategori', 50)->default('Olahraga');
            $table->string('jadwal', 150)->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // 15. Tabel Usulan Perubahan
        Schema::create('usulan_perubahan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_usulan', 50)->unique(); // PROP-MAT-001
            $table->foreignId('pengusul_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('unit_id')->constrained('unit_pendidikan')->onDelete('cascade');
            $table->foreignId('mapel_id')->constrained('mata_pelajaran')->onDelete('cascade');
            $table->string('jenis_usulan', 20); // Tambah, Ubah, Hapus
            $table->string('objek_data', 50); // CP, TP, Materi
            $table->unsignedBigInteger('data_id')->nullable(); // ID data acuan jika ubah / hapus
            $table->string('judul_usulan', 200);
            $table->longText('data_usulan'); // JSON isi perubahan / data baru
            $table->text('alasan_pengajuan'); // Rationale
            $table->string('status', 30)->default('Menunggu Persetujuan'); // Menunggu Persetujuan, Disetujui, Ditolak
            $table->foreignId('peninjau_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('alasan_penolakan')->nullable();
            $table->dateTime('tanggal_pengajuan');
            $table->dateTime('tanggal_keputusan')->nullable();
            $table->timestamps();
        });

        // 16. Tabel Jurnal Mengajar (Rekomendasi Utama Hasil Observasi Wawancara di Lapangan)
        Schema::create('jurnal_mengajar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('mapel_id')->constrained('mata_pelajaran')->onDelete('cascade');
            $table->foreignId('kelas_id')->nullable()->constrained('kelas')->nullOnDelete();
            $table->date('tanggal');
            $table->string('jam_ke', 20)->default('1 - 2');
            $table->string('materi_diajarkan', 255);
            $table->text('catatan_kegiatan')->nullable();
            $table->unsignedSmallInteger('jumlah_hadir')->default(30);
            $table->unsignedSmallInteger('jumlah_tidak_hadir')->default(0);
            $table->timestamps();
        });

        // 17. Tabel Monitoring Tahfidz (Rekomendasi Utama Hasil Observasi MI & SMA)
        Schema::create('monitoring_tahfidz', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained('unit_pendidikan')->onDelete('cascade');
            $table->string('nama_santri', 150);
            $table->string('kelas', 50);
            $table->string('juz', 20);
            $table->string('surat', 100);
            $table->string('ayat', 50);
            $table->string('predikat', 20)->default('Jayyid Jiddan'); // Mumtaz, Jayyid Jiddan, Jayyid, Maqbul
            $table->text('catatan_mutqin')->nullable();
            $table->foreignId('penguji_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('tanggal_setoran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_tahfidz');
        Schema::dropIfExists('jurnal_mengajar');
        Schema::dropIfExists('usulan_perubahan');
        Schema::dropIfExists('kegiatan_ekstrakurikuler');
        Schema::dropIfExists('kegiatan_kokurikuler');
        Schema::dropIfExists('materi');
        Schema::dropIfExists('tujuan_pembelajaran');
        Schema::dropIfExists('capaian_pembelajaran');
        Schema::dropIfExists('penugasan_guru');
        Schema::dropIfExists('mapel_kelas');
        Schema::dropIfExists('mata_pelajaran');
        Schema::dropIfExists('kurikulum');

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['peran_id']);
            $table->dropForeign(['unit_id']);
            $table->dropColumn(['peran_id', 'unit_id', 'username', 'nip', 'jabatan', 'avatar_url', 'status_aktif']);
        });

        Schema::dropIfExists('kelas');
        Schema::dropIfExists('fase');
        Schema::dropIfExists('unit_pendidikan');
        Schema::dropIfExists('jenjang');
        Schema::dropIfExists('peran');
    }
};

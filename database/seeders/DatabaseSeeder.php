<?php

namespace Database\Seeders;

use App\Models\CapaianPembelajaran;
use App\Models\Fase;
use App\Models\Jenjang;
use App\Models\JurnalMengajar;
use App\Models\KegiatanEkstrakurikuler;
use App\Models\KegiatanKokurikuler;
use App\Models\Kelas;
use App\Models\Kurikulum;
use App\Models\MataPelajaran;
use App\Models\Materi;
use App\Models\MonitoringTahfidz;
use App\Models\PenugasanGuru;
use App\Models\Peran;
use App\Models\TujuanPembelajaran;
use App\Models\UnitPendidikan;
use App\Models\User;
use App\Models\UsulanPerubahan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Peran Pengguna (Sesuai Bab Identifikasi Pengguna di Dokumen Analisis)
        $peranYayasan = Peran::create([
            'nama_peran' => 'Pengurus Yayasan',
            'deskripsi' => 'Pihak yang memantau informasi kurikulum dari seluruh unit pendidikan di bawah Yayasan Ali Masykur.',
        ]);

        $peranAdmin = Peran::create([
            'nama_peran' => 'Admin Sistem',
            'deskripsi' => 'Pihak yang mengelola akun pengguna, peran, hak akses, dan administrasi sistem.',
        ]);

        $peranKepsek = Peran::create([
            'nama_peran' => 'Kepala Sekolah/Madrasah',
            'deskripsi' => 'Pihak yang memimpin unit, mengesahkan kurikulum, serta meninjau usulan perubahan kurikulum.',
        ]);

        $peranGuru = Peran::create([
            'nama_peran' => 'Guru Mata Pelajaran',
            'deskripsi' => 'Pihak yang mengelola pembelajaran mata pelajaran penugasan serta mengajukan usulan kurikulum.',
        ]);

        $peranWaka = Peran::create([
            'nama_peran' => 'Waka Kurikulum',
            'deskripsi' => 'Pihak yang mengkoordinasikan implementasi kurikulum, distribusi beban jam mengajar, supervisi pembelajaran, serta review teknis usulan silabus pada tingkat unit.',
        ]);

        $peranPembina = Peran::create([
            'nama_peran' => 'Pembina Ekstrakurikuler',
            'deskripsi' => 'Pihak yang bertanggung jawab atas kegiatan kokurikuler dan ekstrakurikuler unit.',
        ]);

        // 2. Jenjang Pendidikan (MI, SMP, SMA)
        $jenjangMI = Jenjang::create(['nama_jenjang' => 'MI']);
        $jenjangSMP = Jenjang::create(['nama_jenjang' => 'SMP']);
        $jenjangSMA = Jenjang::create(['nama_jenjang' => 'SMA']);

        // 3. Unit Pendidikan di bawah naungan Yayasan Ali Masykur
        $unitMI = UnitPendidikan::create([
            'jenjang_id' => $jenjangMI->id,
            'nama_unit' => 'MI Tahfidz Alfa Ali Masykur',
            'kode_unit' => 'MI-ALFA',
            'kepala_sekolah' => 'Ibu Anisa, S.Pd.I',
        ]);

        $unitSMP = UnitPendidikan::create([
            'jenjang_id' => $jenjangSMP->id,
            'nama_unit' => 'SMP Alfa Ali Masykur',
            'kode_unit' => 'SMP-ALFA',
            'kepala_sekolah' => 'Drs. H. Makmun Ridwan, M.Pd.',
        ]);

        $unitSMA = UnitPendidikan::create([
            'jenjang_id' => $jenjangSMA->id,
            'nama_unit' => 'SMA Alfa Ali Masykur',
            'kode_unit' => 'SMA-ALFA',
            'kepala_sekolah' => 'Ibu Ulfah, M.Pd.',
        ]);

        // 4. Fase Kurikulum Merdeka
        $faseA = Fase::create(['nama_fase' => 'Fase A', 'keterangan' => 'Kelas 1 dan 2 Tingkat Madrasah Ibtidaiyah']);
        $faseB = Fase::create(['nama_fase' => 'Fase B', 'keterangan' => 'Kelas 3 dan 4 Tingkat Madrasah Ibtidaiyah']);
        $faseC = Fase::create(['nama_fase' => 'Fase C', 'keterangan' => 'Kelas 5 dan 6 Tingkat Madrasah Ibtidaiyah']);
        $faseD = Fase::create(['nama_fase' => 'Fase D', 'keterangan' => 'Kelas 7, 8, dan 9 Tingkat SMP']);
        $faseE = Fase::create(['nama_fase' => 'Fase E', 'keterangan' => 'Kelas 10 Tingkat SMA']);
        $faseF = Fase::create(['nama_fase' => 'Fase F', 'keterangan' => 'Kelas 11 dan 12 Tingkat SMA (Paket IPA & IPS)']);

        // 5. Tingkat Kelas
        // MI
        for ($i = 1; $i <= 6; $i++) {
            $fase = $i <= 2 ? $faseA : ($i <= 4 ? $faseB : $faseC);
            Kelas::create([
                'jenjang_id' => $jenjangMI->id,
                'fase_id' => $fase->id,
                'tingkat' => $i,
                'nama_kelas' => 'Kelas ' . $i . ' MI',
            ]);
        }

        // SMP (Kelas 7, 8, 9)
        $kelas7 = Kelas::create(['jenjang_id' => $jenjangSMP->id, 'fase_id' => $faseD->id, 'tingkat' => 7, 'nama_kelas' => 'Kelas 7 SMP']);
        $kelas8 = Kelas::create(['jenjang_id' => $jenjangSMP->id, 'fase_id' => $faseD->id, 'tingkat' => 8, 'nama_kelas' => 'Kelas 8 SMP']);
        $kelas9 = Kelas::create(['jenjang_id' => $jenjangSMP->id, 'fase_id' => $faseD->id, 'tingkat' => 9, 'nama_kelas' => 'Kelas 9 SMP']);

        // SMA (Kelas 10, 11, 12)
        Kelas::create(['jenjang_id' => $jenjangSMA->id, 'fase_id' => $faseE->id, 'tingkat' => 10, 'nama_kelas' => 'Kelas 10 SMA']);
        Kelas::create(['jenjang_id' => $jenjangSMA->id, 'fase_id' => $faseF->id, 'tingkat' => 11, 'nama_kelas' => 'Kelas 11 SMA']);
        Kelas::create(['jenjang_id' => $jenjangSMA->id, 'fase_id' => $faseF->id, 'tingkat' => 12, 'nama_kelas' => 'Kelas 12 SMA']);

        // 6. Akun Pengguna Utama (Sesuai Kasus Lapangan dan Mockup Desain)
        $guruAhmad = User::create([
            'peran_id' => $peranGuru->id,
            'unit_id' => $unitSMP->id,
            'name' => 'Ustadz Ahmad Fauzi, S.Pd.',
            'username' => 'guru.ahmad',
            'nip' => '198804122019031004',
            'email' => 'ahmad.fauzi@alimasykur.sch.id',
            'jabatan' => 'Guru Matematika',
            'password' => Hash::make('password'),
            'avatar_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBx0rZxyzbuDdh-0ANep6cf9GJ787f5hx2euxkHJF59wfAYB__L_Q2IcRznC324W-gjderBtNHcmf_lp-AXcnN22s-I6BP8zPTG0fqWf5HyaRmSxuc928UrZIfB_T9uiN3G_7WEedSHXk_YGZmbn7F6RVPjVnNhhni8z_g3Bzo_BcTZRelQs5XlKq-VEPTYc5OrW_xhw6FAb-ofTsQYpfNshUL72ZKLl-g0lnBcqwt0KtfeipzWysV3qA',
            'status_aktif' => true,
        ]);

        $kepsekSMP = User::create([
            'peran_id' => $peranKepsek->id,
            'unit_id' => $unitSMP->id,
            'name' => 'Drs. H. Makmun Ridwan, M.Pd.',
            'username' => 'kepsek.smp',
            'nip' => '196908151994031002',
            'email' => 'makmun.ridwan@alimasykur.sch.id',
            'jabatan' => 'Kepala SMP Alfa Ali Masykur',
            'password' => Hash::make('password'),
            'status_aktif' => true,
        ]);

        $kepsekMI = User::create([
            'peran_id' => $peranKepsek->id,
            'unit_id' => $unitMI->id,
            'name' => 'Ibu Anisa, S.Pd.I',
            'username' => 'kepsek.mi',
            'nip' => '198502102011012015',
            'email' => 'anisa@alimasykur.sch.id',
            'jabatan' => 'Kepala MI Tahfidz Alfa Ali Masykur',
            'password' => Hash::make('password'),
            'status_aktif' => true,
        ]);

        $kepsekSMA = User::create([
            'peran_id' => $peranKepsek->id,
            'unit_id' => $unitSMA->id,
            'name' => 'Ibu Ulfah, M.Pd.',
            'username' => 'kepsek.sma',
            'nip' => '198103192008012011',
            'email' => 'ulfah@alimasykur.sch.id',
            'jabatan' => 'Kepala SMA Alfa Ali Masykur',
            'password' => Hash::make('password'),
            'status_aktif' => true,
        ]);

        // Waka Kurikulum per Unit Sekolah
        $wakaMI = User::create([
            'peran_id' => $peranWaka->id,
            'unit_id' => $unitMI->id,
            'name' => 'Ustadzah Fatimah Azzahra, S.Pd.I',
            'username' => 'waka.mi',
            'nip' => '198905142014022003',
            'email' => 'waka.mi@alimasykur.sch.id',
            'jabatan' => 'Waka Kurikulum MI Tahfidz Alfa',
            'password' => Hash::make('password'),
            'status_aktif' => true,
        ]);

        $wakaSMP = User::create([
            'peran_id' => $peranWaka->id,
            'unit_id' => $unitSMP->id,
            'name' => 'Ustadz M. Yusuf Arifin, M.Pd.',
            'username' => 'waka.smp',
            'nip' => '198307222009011008',
            'email' => 'waka.smp@alimasykur.sch.id',
            'jabatan' => 'Waka Kurikulum SMP Alfa Ali Masykur',
            'password' => Hash::make('password'),
            'status_aktif' => true,
        ]);

        $wakaSMA = User::create([
            'peran_id' => $peranWaka->id,
            'unit_id' => $unitSMA->id,
            'name' => 'Ustadz Hendra Gunawan, S.Si., M.Pd.',
            'username' => 'waka.sma',
            'nip' => '198611052010011012',
            'email' => 'waka.sma@alimasykur.sch.id',
            'jabatan' => 'Waka Kurikulum SMA Alfa Ali Masykur',
            'password' => Hash::make('password'),
            'status_aktif' => true,
        ]);

        $pengurusYayasan = User::create([
            'peran_id' => $peranYayasan->id,
            'unit_id' => null, // Seluruh unit
            'name' => 'KH. Ali Masykur, Lc., M.A.',
            'username' => 'yayasan',
            'nip' => 'YAY-AM-001',
            'email' => 'yayasan@alimasykur.sch.id',
            'jabatan' => 'Ketua Dewan Pembina Yayasan',
            'password' => Hash::make('password'),
            'status_aktif' => true,
        ]);

        $adminSistem = User::create([
            'peran_id' => $peranAdmin->id,
            'unit_id' => null,
            'name' => 'Administrator Sistem',
            'username' => 'admin',
            'nip' => 'ADM-SYS-01',
            'email' => 'admin@alimasykur.sch.id',
            'jabatan' => 'Super Administrator IT',
            'password' => Hash::make('password'),
            'status_aktif' => true,
        ]);

        // 7. Kurikulum
        $kurikulumSMP = Kurikulum::create([
            'unit_id' => $unitSMP->id,
            'nama_kurikulum' => 'Kurikulum Merdeka Plus Pesantren SMP',
            'deskripsi' => 'Kurikulum Nasional Kemendikbud yang disinergikan dengan kultur dan muatan kepesantrenan terpadu.',
            'tahun_ajaran' => '2024/2025',
            'semester' => 'Ganjil',
            'is_active' => true,
        ]);

        $kurikulumMI = Kurikulum::create([
            'unit_id' => $unitMI->id,
            'nama_kurikulum' => 'Kurikulum Merdeka KBC & Tahfidz Terpadu',
            'deskripsi' => 'Integrasi Kurikulum Merdeka, Kurikulum Berbasis Cinta (KBC) Kemenag, dan Program Intensif Tahfidz Al-Qur\'an.',
            'tahun_ajaran' => '2024/2025',
            'semester' => 'Ganjil',
            'is_active' => true,
        ]);

        $kurikulumSMA = Kurikulum::create([
            'unit_id' => $unitSMA->id,
            'nama_kurikulum' => 'Kurikulum Merdeka Paket Peminatan & Pondok SMA',
            'deskripsi' => 'Kurikulum Merdeka Fase E & F dengan sistem paket rumpun IPA/IPS dan Kajian Risalah Ushul.',
            'tahun_ajaran' => '2024/2025',
            'semester' => 'Ganjil',
            'is_active' => true,
        ]);

        // 8. Mata Pelajaran SMP
        $mapelMatematika = MataPelajaran::create([
            'kurikulum_id' => $kurikulumSMP->id,
            'kode_mapel' => 'MAT-SMP-01',
            'nama_mapel' => 'Matematika (Reguler)',
            'kategori' => 'Intrakurikuler',
            'deskripsi' => 'Mata pelajaran wajib berfokus pada fondasi berhitung, aljabar, geometri, dan literasi finansial syariah.',
        ]);

        $mapelMatematikaPeminatan = MataPelajaran::create([
            'kurikulum_id' => $kurikulumSMP->id,
            'kode_mapel' => 'MAT-SMP-02',
            'nama_mapel' => 'Matematika Peminatan & Logika',
            'kategori' => 'Peminatan',
            'deskripsi' => 'Mata pelajaran pengayaan logika matematika dan olimpiade santri.',
        ]);

        $mapelTahfidzSMP = MataPelajaran::create([
            'kurikulum_id' => $kurikulumSMP->id,
            'kode_mapel' => 'TFZ-SMP-01',
            'nama_mapel' => 'Tahfidz Al-Qur\'an',
            'kategori' => 'Muatan Pesantren',
            'deskripsi' => 'Program tahfidz dan tahsin target juz 28-30 dengan metode tasmi\' dan muraja\'ah.',
        ]);

        $mapelBahasaArabSMP = MataPelajaran::create([
            'kurikulum_id' => $kurikulumSMP->id,
            'kode_mapel' => 'ARB-SMP-01',
            'nama_mapel' => 'Bahasa Arab Komunikatif',
            'kategori' => 'Muatan Pesantren',
            'deskripsi' => 'Pembelajaran muhadatsah harian dan pemahaman teks bahasa Arab dasar.',
        ]);

        $mapelPAI = MataPelajaran::create([
            'kurikulum_id' => $kurikulumSMP->id,
            'kode_mapel' => 'PAI-SMP-01',
            'nama_mapel' => 'Pendidikan Agama Islam & Budi Pekerti',
            'kategori' => 'Intrakurikuler',
            'deskripsi' => 'Pendidikan nilai akhlak mulia dan fiqih ubudiyah.',
        ]);

        // Hubungkan Mapel Matematika ke Kelas 7 & 8
        $mapelMatematika->kelas()->attach([$kelas7->id, $kelas8->id]);
        $mapelMatematikaPeminatan->kelas()->attach([$kelas8->id]);

        // Mapel MI (Sesuai Observasi Dokumen Analisis)
        $mapelMI1 = MataPelajaran::create([
            'kurikulum_id' => $kurikulumMI->id,
            'kode_mapel' => 'TFZ-MI-01',
            'nama_mapel' => 'Tahfidz Al-Qur\'an (Buku Kontrol)',
            'kategori' => 'Muatan Pesantren',
            'deskripsi' => 'Pemantauan hafalan juz 30 fleksibel sesuai kecepatan masing-masing siswa.',
        ]);
        $mapelMI2 = MataPelajaran::create([
            'kurikulum_id' => $kurikulumMI->id,
            'kode_mapel' => 'ASW-MI-01',
            'nama_mapel' => 'Ke-NU-an / Aswaja',
            'kategori' => 'Muatan Pesantren',
            'deskripsi' => 'Muatan keaswajaan dan tradisi kepesantrenan.',
        ]);
        $mapelMI3 = MataPelajaran::create([
            'kurikulum_id' => $kurikulumMI->id,
            'kode_mapel' => 'QHD-MI-01',
            'nama_mapel' => 'Al-Qur\'an Hadis',
            'kategori' => 'Intrakurikuler',
            'deskripsi' => 'Pembelajaran dasar hadis dan tajwid Kemenag.',
        ]);

        // Mapel SMA (Sesuai Observasi Dokumen Analisis)
        MataPelajaran::create([
            'kurikulum_id' => $kurikulumSMA->id,
            'kode_mapel' => 'KRU-SMA-01',
            'nama_mapel' => 'Kajian Risalah Ushul (KRU 1)',
            'kategori' => 'Muatan Pesantren',
            'deskripsi' => 'Kajian kitab ushul fiqih khas pondok pesantren Ali Masykur.',
        ]);
        MataPelajaran::create([
            'kurikulum_id' => $kurikulumSMA->id,
            'kode_mapel' => 'SEJ-SMA-01',
            'nama_mapel' => 'Sejarah Umum Wajib',
            'kategori' => 'Intrakurikuler',
            'deskripsi' => 'Sejarah umum untuk seluruh siswa kelas 10 dan 11.',
        ]);

        // 9. Penugasan Guru
        PenugasanGuru::create([
            'pengguna_id' => $guruAhmad->id,
            'mapel_id' => $mapelMatematika->id,
            'beban_jp' => 24,
            'jumlah_rombel' => 8,
        ]);

        // 10. Capaian Pembelajaran (CP) untuk Matematika SMP
        $cp01 = CapaianPembelajaran::create([
            'mapel_id' => $mapelMatematika->id,
            'fase_id' => $faseD->id,
            'kode_cp' => 'CP-01',
            'elemen' => 'Bilangan',
            'deskripsi_cp' => 'Peserta didik dapat membaca, menulis, dan membandingkan bilangan bulat, bilangan rasional dan irasional, bilangan desimal. Mereka dapat menerapkan operasi aritmetika pada bilangan real, dan memberikan estimasi/perkiraan dalam menyelesaikan masalah (termasuk literasi finansial syariah dan aplikasi dalam muamalah peradaban Islam).',
            'total_beban_jp' => 32,
        ]);

        $cp02 = CapaianPembelajaran::create([
            'mapel_id' => $mapelMatematika->id,
            'fase_id' => $faseD->id,
            'kode_cp' => 'CP-02',
            'elemen' => 'Aljabar',
            'deskripsi_cp' => 'Peserta didik dapat mengenali, memprediksi dan menggeneralisasi pola dalam bentuk susunan benda dan bilangan. Mereka dapat menyatakan suatu situasi ke dalam bentuk aljabar dan menggunakannya untuk menyelesaikan persamaan serta pertidaksamaan linier satu variabel.',
            'total_beban_jp' => 28,
        ]);

        $cp03 = CapaianPembelajaran::create([
            'mapel_id' => $mapelMatematika->id,
            'fase_id' => $faseD->id,
            'kode_cp' => 'CP-03',
            'elemen' => 'Geometri',
            'deskripsi_cp' => 'Peserta didik dapat membuktikan teorema yang terkait dengan sudut pada garis sejajar, segitiga, dan segiempat, serta menerapkan rumus keliling dan luas bidang datar dalam konteks arsitektur Islam.',
            'total_beban_jp' => 24,
        ]);

        $cp04 = CapaianPembelajaran::create([
            'mapel_id' => $mapelMatematika->id,
            'fase_id' => $faseD->id,
            'kode_cp' => 'CP-04',
            'elemen' => 'Analisis Data & Peluang',
            'deskripsi_cp' => 'Peserta didik dapat merumuskan pertanyaan, mengumpulkan, menyajikan, dan menganalisis data untuk menjawab pertanyaan kontekstual serta mengevaluasi laporan berbasis data.',
            'total_beban_jp' => 20,
        ]);

        // 11. Tujuan Pembelajaran (TP) untuk CP-01 (Bilangan)
        $tp1 = TujuanPembelajaran::create([
            'cp_id' => $cp01->id,
            'kode_tp' => 'TP-7.1',
            'deskripsi_tp' => 'Menjelaskan konsep bilangan bulat positif dan negatif serta representasinya dalam garis bilangan kehidupan sehari-hari.',
            'beban_jp' => 8,
            'periode' => 'Bulan Juli - Agustus',
            'status_pengesahan' => 'Disetujui',
        ]);

        $tp2 = TujuanPembelajaran::create([
            'cp_id' => $cp01->id,
            'kode_tp' => 'TP-7.2',
            'deskripsi_tp' => 'Menerapkan operasi hitung bilangan rasional untuk menyelesaikan masalah kontekstual.',
            'beban_jp' => 10,
            'periode' => 'Bulan Agustus - September',
            'status_pengesahan' => 'Disetujui',
        ]);

        $tp3 = TujuanPembelajaran::create([
            'cp_id' => $cp01->id,
            'kode_tp' => 'TP-7.3',
            'deskripsi_tp' => 'Menganalisis perbandingan senilai dan berbalik nilai dalam konteks muamalah dan perdagangan syariah.',
            'beban_jp' => 8,
            'periode' => 'Bulan September - Oktober',
            'status_pengesahan' => 'Disetujui',
        ]);

        $tp4 = TujuanPembelajaran::create([
            'cp_id' => $cp01->id,
            'kode_tp' => 'TP-7.4',
            'deskripsi_tp' => 'Menyelesaikan masalah kontekstual pembagian pecahan bertingkat untuk efisiensi beban ajar kelas 7.',
            'beban_jp' => 6,
            'periode' => 'Bulan Oktober',
            'status_pengesahan' => 'Perlu Revisi',
        ]);

        // 12. Materi Pokok untuk TP-7.1 & TP-7.2
        Materi::create([
            'tp_id' => $tp1->id,
            'kode_materi' => 'Materi 7.1.1',
            'judul_materi' => 'Konsep Bilangan Bulat dan Garis Bilangan',
            'isi_materi' => 'Pemahaman arah bilangan positif dan negatif, penerapan suhu derajat termometer dan elevasi permukaan laut.',
            'beban_jp' => 4,
            'media_ajar' => 'Lembar Kerja Garis Termometer',
        ]);

        Materi::create([
            'tp_id' => $tp1->id,
            'kode_materi' => 'Materi 7.1.2',
            'judul_materi' => 'Operasi Penjumlahan dan Pengurangan Bilangan Bulat',
            'isi_materi' => 'Sifat komutatif, asosiatif, dan penggunaan model koin muatan listrik dalam penjumlahan serta pengurangan.',
            'beban_jp' => 4,
            'media_ajar' => 'Simulasi Koin Magnetik Dua Sisi',
        ]);

        Materi::create([
            'tp_id' => $tp2->id,
            'kode_materi' => 'Materi 7.2.1',
            'judul_materi' => 'Pecahan dan Desimal dalam Masalah Kehidupan Nyata (Zakat & Muamalah)',
            'isi_materi' => 'Menghitung persentase zakat fitrah dan perniagaan, pembagian waris sederhana, dan konversi pecahan biasa ke desimal.',
            'beban_jp' => 6,
            'media_ajar' => 'Literasi Finansial Islam & Kalkulator Zakat',
        ]);

        Materi::create([
            'tp_id' => $tp2->id,
            'kode_materi' => 'Materi 7.2.2',
            'judul_materi' => 'Perkalian dan Pembagian Bilangan Rasional Pecahan Campuran',
            'isi_materi' => 'Metode reciprocal perkalian pecahan dan pemecahan kasus proporsi resep takaran pangan.',
            'beban_jp' => 4,
            'media_ajar' => 'Modul Latihan Problem Solving Mandiri',
        ]);

        // 13. Data Usulan Perubahan (Sesuai Exact Mockup di Desain)
        // Usulan 1: Ditolak oleh Kepala SMP
        UsulanPerubahan::create([
            'nomor_usulan' => 'PROP-MAT-003',
            'pengusul_id' => $guruAhmad->id,
            'unit_id' => $unitSMP->id,
            'mapel_id' => $mapelMatematika->id,
            'jenis_usulan' => 'Ubah',
            'objek_data' => 'TP',
            'data_id' => $tp4->id,
            'judul_usulan' => 'Pemadatan Alokasi Waktu Pecahan Bertingkat Kelas 7',
            'data_usulan' => [
                'kode_tp' => 'TP-7.4',
                'deskripsi_tp' => 'Menyelesaikan masalah kontekstual pembagian pecahan bertingkat untuk efisiensi beban ajar kelas 7.',
                'beban_jp_semula' => 6,
                'beban_jp_usulan' => 2,
            ],
            'alasan_pengajuan' => 'Usulan pemadatan beban materi pecahan agar topik dasar aljabar pada bulan November dapat dimulai lebih awal.',
            'status' => 'Ditolak',
            'peninjau_id' => $kepsekSMP->id,
            'alasan_penolakan' => 'Ustadz Fauzi, usulan pemadatan waktu dari 6 JP menjadi 2 JP terlalu signifikan dan berpotensi mengurangi capaian pemahaman konsep dasar pecahan bertingkat peserta didik kelas 7. Mohon dikaji ulang dengan mempertahankan minimal 4 JP serta menambahkan rasional adaptif sesuai taksonomi Bloom tingkat C3.',
            'tanggal_pengajuan' => '2024-10-12 09:15:00',
            'tanggal_keputusan' => '2024-10-14 11:20:00',
        ]);

        // Usulan 2: Menunggu Persetujuan
        UsulanPerubahan::create([
            'nomor_usulan' => 'PROP-MAT-004',
            'pengusul_id' => $guruAhmad->id,
            'unit_id' => $unitSMP->id,
            'mapel_id' => $mapelMatematika->id,
            'jenis_usulan' => 'Tambah',
            'objek_data' => 'Materi',
            'data_id' => null,
            'judul_usulan' => 'Pengayaan Studi Kasus Muamalah Finansial Syariah pada Materi Pecahan',
            'data_usulan' => [
                'target_tp' => 'TP-7.2',
                'judul_materi' => 'Simulasi Bagi Hasil Mudharabah Sederhana',
                'beban_jp' => 2,
                'media_ajar' => 'Lembar Kerja Muamalah Santri',
            ],
            'alasan_pengajuan' => 'Menyesuaikan rekomendasi kurikulum pesantren Yayasan Ali Masykur agar peserta didik memiliki literasi ekonomi syariah sejak dini.',
            'status' => 'Menunggu Persetujuan',
            'peninjau_id' => null,
            'alasan_penolakan' => null,
            'tanggal_pengajuan' => '2024-10-22 14:30:00',
            'tanggal_keputusan' => null,
        ]);

        // Usulan 3: Disetujui
        UsulanPerubahan::create([
            'nomor_usulan' => 'PROP-MAT-002',
            'pengusul_id' => $guruAhmad->id,
            'unit_id' => $unitSMP->id,
            'mapel_id' => $mapelMatematika->id,
            'jenis_usulan' => 'Ubah',
            'objek_data' => 'TP',
            'data_id' => $tp1->id,
            'judul_usulan' => 'Integrasi Konsep Suhu Pegunungan Dieng pada Garis Bilangan',
            'data_usulan' => [
                'kode_tp' => 'TP-7.1',
                'deskripsi_tp' => 'Menjelaskan konsep bilangan bulat positif dan negatif serta representasinya dalam garis bilangan kehidupan sehari-hari (fenomena es embun upas Dieng).',
            ],
            'alasan_pengajuan' => 'Memanfaatkan kearifan lokal iklim Wonosobo dan Dieng agar peserta didik lebih mudah membayangkan bilangan di bawah nol.',
            'status' => 'Disetujui',
            'peninjau_id' => $kepsekSMP->id,
            'alasan_penolakan' => null,
            'tanggal_pengajuan' => '2024-09-05 10:00:00',
            'tanggal_keputusan' => '2024-09-08 13:45:00',
        ]);

        // 14. Kokurikuler (P5-RA)
        KegiatanKokurikuler::create([
            'unit_id' => $unitSMP->id,
            'nama_kegiatan' => 'Projek Penguatan Profil Pelajar Pancasila & Rahmatan Lil Alamin (P5-RA)',
            'tema' => 'Kearifan Lokal & Budaya Pesantren Wonosobo',
            'deskripsi' => 'Penggalian nilai-nilai ketawadhu\'an santri dan tradisi lokal melalui pembuatan karya literasi dan kaligrafi.',
            'alokasi_waktu' => '120 JP / Tahun',
            'pengelola_id' => $guruAhmad->id,
        ]);

        KegiatanKokurikuler::create([
            'unit_id' => $unitMI->id,
            'nama_kegiatan' => 'P5-RA: Lingkungan Sehat Santri Cilik',
            'tema' => 'Gaya Hidup Berkelanjutan',
            'deskripsi' => 'Edukasi kebersihan madrasah dan pemilahan sampah organik untuk kompos.',
            'alokasi_waktu' => '90 JP / Tahun',
            'pengelola_id' => $kepsekMI->id,
        ]);

        // 15. Ekstrakurikuler
        KegiatanEkstrakurikuler::create([
            'unit_id' => $unitSMP->id,
            'pembina_id' => $guruAhmad->id,
            'nama_kegiatan' => 'Klub Sains & Olimpiade Matematika (KSOM)',
            'kategori' => 'Akademik',
            'jadwal' => 'Setiap Rabu Pukul 15.30 - 17.00 WIB',
            'deskripsi' => 'Bimbingan intensif persiapan KSM Kemenag dan OSN Matematika SMP.',
        ]);

        KegiatanEkstrakurikuler::create([
            'unit_id' => $unitSMP->id,
            'pembina_id' => null,
            'nama_kegiatan' => 'Pencak Silat Pagar Nusa',
            'kategori' => 'Bela Diri & Karakter',
            'jadwal' => 'Setiap Jumat Pukul 15.45 - 17.15 WIB',
            'deskripsi' => 'Latihan ketangkasan fisik, mentalitas ksatria, dan jurus tradisi Pagar Nusa.',
        ]);

        KegiatanEkstrakurikuler::create([
            'unit_id' => $unitSMP->id,
            'pembina_id' => null,
            'nama_kegiatan' => 'Kaligrafi Islam (Khat Kufi & Naskhi)',
            'kategori' => 'Seni Islami',
            'jadwal' => 'Setiap Sabtu Pukul 09.00 - 11.00 WIB',
            'deskripsi' => 'Seni penulisan ayat Al-Qur\'an dengan kaidah khat standar internasional.',
        ]);

        // 16. Jurnal Mengajar (Solusi Temuan Observasi)
        JurnalMengajar::create([
            'guru_id' => $guruAhmad->id,
            'mapel_id' => $mapelMatematika->id,
            'kelas_id' => $kelas7->id,
            'tanggal' => now()->format('Y-m-d'),
            'jam_ke' => '1 - 2 (07.15 - 08.35 WIB)',
            'materi_diajarkan' => 'Konsep Bilangan Bulat dan Garis Bilangan (Materi 7.1.1)',
            'catatan_kegiatan' => 'Pembelajaran berjalan interaktif menggunakan media termometer digital. Seluruh santri aktif mengerjakan latihan kelompok.',
            'jumlah_hadir' => 31,
            'jumlah_tidak_hadir' => 1,
        ]);

        // 17. Monitoring Tahfidz (Solusi Temuan Observasi MI & SMA)
        MonitoringTahfidz::create([
            'unit_id' => $unitSMP->id,
            'nama_santri' => 'Muhammad Wildan Al-Farisi',
            'kelas' => '7A SMP Alfa',
            'juz' => 'Juz 30',
            'surat' => 'An-Naba\'',
            'ayat' => 'Ayat 1 - 40 (Selesai)',
            'predikat' => 'Mumtaz',
            'catatan_mutqin' => 'Makharijul huruf sangat fasih, hukum mad thabi\'i konsisten 2 harakat.',
            'penguji_id' => $guruAhmad->id,
            'tanggal_setoran' => now()->format('Y-m-d'),
        ]);

        MonitoringTahfidz::create([
            'unit_id' => $unitSMP->id,
            'nama_santri' => 'Fathimah Az-Zahra',
            'kelas' => '7B SMP Alfa',
            'juz' => 'Juz 29',
            'surat' => 'Al-Mulk',
            'ayat' => 'Ayat 1 - 30 (Selesai)',
            'predikat' => 'Jayyid Jiddan',
            'catatan_mutqin' => 'Kelancaran hafalan baik, perlu perhatian pada ikhfa haqiqi huruf qaf.',
            'penguji_id' => $guruAhmad->id,
            'tanggal_setoran' => now()->subDay()->format('Y-m-d'),
        ]);
    }
}

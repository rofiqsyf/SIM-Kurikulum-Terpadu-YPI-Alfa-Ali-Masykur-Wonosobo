<?php

namespace Tests\Feature;

use App\Models\CapaianPembelajaran;
use App\Models\MataPelajaran;
use App\Models\TujuanPembelajaran;
use App\Models\User;
use App\Models\UsulanPerubahan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SimKurikulumCompleteFlowTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->artisan('db:seed');
    }

    public function test_all_pages_render_successfully_for_authenticated_users(): void
    {
        $guru = User::where('username', 'guru.ahmad')->first();
        $this->assertNotNull($guru);

        // Test Landing Page
        $this->get('/')->assertStatus(200);

        // Test Login Page
        $this->get('/login')->assertStatus(200);

        // Test Standard Authentication Flow
        $loginResponse = $this->post('/login', [
            'identity' => 'guru.ahmad',
            'password' => 'password',
        ]);
        $loginResponse->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();

        $this->post('/logout')->assertRedirect(route('login'));
        $this->assertGuest();

        // Test Failed Login
        $failResponse = $this->from('/login')->post('/login', [
            'identity' => 'guru.ahmad',
            'password' => 'wrongpassword',
        ]);
        $failResponse->assertRedirect('/login');
        $this->assertGuest();

        // Test Dashboard
        $this->actingAs($guru)->get('/dashboard')->assertStatus(200);

        // Test Mata Pelajaran & Workspace (Katalog vs Workspace view)
        $this->actingAs($guru)->get('/mata-pelajaran')->assertStatus(200);
        $this->actingAs($guru)->get('/mata-pelajaran?view=katalog')
            ->assertStatus(200)
            ->assertSee('Katalog Mata Pelajaran &amp; Silabus', false)
            ->assertSee('MI Tahfidz Alfa Ali Masykur');
        $this->actingAs($guru)->get('/mata-pelajaran?view=workspace')
            ->assertStatus(200)
            ->assertSee('Kembali ke Katalog Kartu Mapel');

        // Test Riwayat Usulan
        $this->actingAs($guru)->get('/usulan')->assertStatus(200);

        // Test Kegiatan Kokurikuler & Ekstrakurikuler
        $this->actingAs($guru)->get('/kegiatan')->assertStatus(200);

        // Test Jurnal & Tahfidz
        $this->actingAs($guru)->get('/jurnal')->assertStatus(200);

        // Test Panduan
        $this->actingAs($guru)->get('/panduan')->assertStatus(200);

        // Test Arsip Kurikulum & Pengawasan
        $this->actingAs($guru)->get('/arsip')->assertStatus(200);

        // Test Yayasan Monitoring
        $yayasan = User::where('username', 'yayasan')->first();
        $this->actingAs($yayasan)->get('/yayasan/monitoring')->assertStatus(200);

        // Test Admin Users
        $admin = User::where('username', 'admin')->first();
        $this->actingAs($admin)->get('/admin/users')->assertStatus(200);
    }

    public function test_proposal_submission_and_headmaster_approval_workflow(): void
    {
        $guru = User::where('username', 'guru.ahmad')->first();
        $kepsek = User::where('username', 'kepsek.smp')->first();
        $mapel = MataPelajaran::first();

        // 1. Guru submits a proposal
        $response = $this->actingAs($guru)->post(route('curriculum.proposal.store'), [
            'mapel_id' => $mapel->id,
            'jenis_usulan' => 'Tambah',
            'objek_data' => 'TP',
            'judul_usulan' => 'Uji Coba Sasaran TP Matematika Finansial Berkah',
            'deskripsi_usulan' => 'Santri mampu menghitung dan menganalisis nisab zakat emas dan perniagaan kontemporer.',
            'beban_jp' => 6,
            'media_ajar' => 'LKPD Fikih Muamalah',
            'alasan_pengajuan' => 'Taksonomi Bloom tingkat C4 (Menganalisis) terintegrasi kurikulum kitab Safinatun Najah.',
        ]);

        $response->assertRedirect(route('usulan.index'));

        $usulan = UsulanPerubahan::where('judul_usulan', 'Uji Coba Sasaran TP Matematika Finansial Berkah')->first();
        $this->assertNotNull($usulan);
        $this->assertEquals('Menunggu Persetujuan', $usulan->status);

        // 2. Kepala Sekolah approves proposal
        $reviewResponse = $this->actingAs($kepsek)->post(route('usulan.review', $usulan->id), [
            'keputusan' => 'setujui',
        ]);

        $reviewResponse->assertSessionHas('success');
        $usulan->refresh();
        $this->assertEquals('Disetujui', $usulan->status);
        $this->assertEquals($kepsek->id, $usulan->peninjau_id);
    }

    public function test_proposal_rejection_workflow_with_feedback_note(): void
    {
        $guru = User::where('username', 'guru.ahmad')->first();
        $kepsek = User::where('username', 'kepsek.smp')->first();
        $mapel = MataPelajaran::first();

        $this->actingAs($guru)->post(route('curriculum.proposal.store'), [
            'mapel_id' => $mapel->id,
            'jenis_usulan' => 'Ubah',
            'objek_data' => 'TP',
            'judul_usulan' => 'Uji Coba Pemadatan Waktu Drastis',
            'deskripsi_usulan' => 'Pemadatan dari 8 JP menjadi 1 JP.',
            'beban_jp' => 1,
            'alasan_pengajuan' => 'Ingin mempercepat ujian akhir.',
        ]);

        $usulan = UsulanPerubahan::where('judul_usulan', 'Uji Coba Pemadatan Waktu Drastis')->first();
        $this->assertNotNull($usulan);

        // Kepala sekolah rejects with pedagogical feedback
        $this->actingAs($kepsek)->post(route('usulan.review', $usulan->id), [
            'keputusan' => 'tolak',
            'alasan_penolakan' => 'Pemadatan 1 JP terlalu ekstrem dan berpotensi menghilangkan pemahaman konsep dasar.',
        ]);

        $usulan->refresh();
        $this->assertEquals('Ditolak', $usulan->status);
        $this->assertStringContainsString('Pemadatan 1 JP terlalu ekstrem', $usulan->alasan_penolakan);
    }

    public function test_jurnal_mengajar_and_tahfidz_store(): void
    {
        $guru = User::where('username', 'guru.ahmad')->first();
        $mapel = MataPelajaran::first();
        $kelas = \App\Models\Kelas::first();
        $unit = \App\Models\UnitPendidikan::first();

        // 1. Store Jurnal Mengajar
        $responseJurnal = $this->actingAs($guru)->post(route('jurnal.store'), [
            'mapel_id' => $mapel->id,
            'kelas_id' => $kelas->id,
            'tanggal' => date('Y-m-d'),
            'jam_ke' => '1 - 2 (07.15 - 08.35)',
            'materi_diajarkan' => 'Materi Aljabar Lanjutan & Latihan Mandiri',
            'catatan_kegiatan' => 'Santri sangat antusias dalam mengerjakan latihan soal.',
            'jumlah_hadir' => 32,
            'jumlah_tidak_hadir' => 0,
        ]);
        $responseJurnal->assertSessionHas('success');

        $this->assertDatabaseHas('jurnal_mengajar', [
            'materi_diajarkan' => 'Materi Aljabar Lanjutan & Latihan Mandiri',
            'guru_id' => $guru->id,
        ]);

        // 2. Store Tahfidz
        $responseTahfidz = $this->actingAs($guru)->post(route('tahfidz.store'), [
            'unit_id' => $unit->id,
            'nama_santri' => 'Muhammad Azhar',
            'kelas' => 'Kelas 7A',
            'juz' => 'Juz 30',
            'surat' => 'An-Nazi\'at',
            'ayat' => 'Ayat 1 - 25',
            'predikat' => 'Mumtaz',
            'catatan_mutqin' => 'Lancar makharijul huruf dan tajwid sangat baik.',
            'tanggal_setoran' => date('Y-m-d'),
        ]);
        $responseTahfidz->assertSessionHas('success');

        $this->assertDatabaseHas('monitoring_tahfidz', [
            'nama_santri' => 'Muhammad Azhar',
            'predikat' => 'Mumtaz',
        ]);

        // 3. Store Jurnal Kerja Pendidik
        $responseKerja = $this->actingAs($guru)->post(route('jurnal-kerja.store'), [
            'judul' => 'Koreksi tugas matematika santri kelas 7B',
            'kategori' => 'penilaian',
            'prioritas' => 'tinggi',
            'tanggal_target' => date('Y-m-d'),
            'catatan_refleksi' => 'Harus selesai sebelum evaluasi pekan depan',
        ]);
        $responseKerja->assertSessionHas('success');

        $kerjaTask = \App\Models\JurnalKerja::where('judul', 'Koreksi tugas matematika santri kelas 7B')->first();
        $this->assertNotNull($kerjaTask);
        $this->assertEquals('belum', $kerjaTask->status);

        // 4. Toggle Jurnal Kerja status
        $responseToggle = $this->actingAs($guru)->post(route('jurnal-kerja.toggle', $kerjaTask->id));
        $responseToggle->assertSessionHas('success');
        $this->assertEquals('selesai', $kerjaTask->fresh()->status);
    }

    public function test_admin_can_create_user_and_assign_mapel(): void
    {
        $admin = User::where('username', 'admin')->first();
        $role = \App\Models\Peran::first();
        $unit = \App\Models\UnitPendidikan::first();
        $mapel = MataPelajaran::first();

        // 1. Create user
        $responseUser = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Ustadzah Halimah, S.Pd.',
            'username' => 'guru.halimah',
            'email' => 'halimah@alimasykur.sch.id',
            'nip' => '199201012024012001',
            'peran_id' => $role->id,
            'unit_id' => $unit->id,
            'jabatan' => 'Guru IPA Terpadu',
            'password' => 'password123',
        ]);
        $responseUser->assertSessionHas('success');

        $newUser = User::where('username', 'guru.halimah')->first();
        $this->assertNotNull($newUser);

        // 2. Assign Mapel
        $responseAssign = $this->actingAs($admin)->post(route('admin.assign.mapel'), [
            'pengguna_id' => $newUser->id,
            'mapel_id' => $mapel->id,
            'beban_jp' => 24,
            'jumlah_rombel' => 4,
        ]);
        $responseAssign->assertSessionHas('success');

        $this->assertDatabaseHas('penugasan_guru', [
            'pengguna_id' => $newUser->id,
            'mapel_id' => $mapel->id,
            'beban_jp' => 24,
        ]);
    }

    public function test_realtime_notifications_and_sync_endpoint(): void
    {
        $guru = User::where('username', 'guru.ahmad')->first();
        $kepsek = User::where('username', 'kepsek.smp')->first();
        $mapel = MataPelajaran::first();

        // 1. Guru submits a proposal, triggering notification to Kepsek
        $this->actingAs($guru)->post(route('curriculum.proposal.store'), [
            'mapel_id' => $mapel->id,
            'jenis_usulan' => 'Tambah',
            'objek_data' => 'TP',
            'judul_usulan' => 'TP Realtime Notification Check',
            'deskripsi_usulan' => 'Deskripsi usulan realtime',
            'alasan_pengajuan' => 'Integrasi kurikulum Bloom C3',
        ]);

        // 2. Kepsek checks /realtime/sync
        $syncResponse = $this->actingAs($kepsek)->getJson(route('realtime.sync'));
        $syncResponse->assertStatus(200);
        $syncResponse->assertJsonStructure([
            'unread_count',
            'new_notifications',
            'recent_notifications',
            'stats',
        ]);
        $this->assertGreaterThan(0, $syncResponse->json('unread_count'));

        $notif = \App\Models\Notifikasi::where('user_id', $kepsek->id)->latest()->first();
        $this->assertNotNull($notif);

        // 3. Kepsek marks notification as read
        $readResponse = $this->actingAs($kepsek)->postJson(route('realtime.read', $notif->id));
        $readResponse->assertStatus(200)->assertJson(['success' => true]);

        $this->assertTrue($notif->fresh()->dibaca);

        // 4. Mark all as read
        $readAllResponse = $this->actingAs($kepsek)->postJson(route('realtime.read-all'));
        $readAllResponse->assertStatus(200)->assertJson(['success' => true]);
    }

    public function test_waka_kurikulum_workflow_and_review_capabilities(): void
    {
        $wakaSMP = User::where('username', 'waka.smp')->first();
        $this->assertNotNull($wakaSMP);
        $this->assertTrue($wakaSMP->isWakaKurikulum());
        $this->assertTrue($wakaSMP->canReviewProposals());

        // 1. Waka can access dashboard and receives starter tasks
        $this->actingAs($wakaSMP)->get('/dashboard')->assertStatus(200);
        $this->actingAs($wakaSMP)->get('/jurnal')->assertStatus(200);

        // Verify Waka starter tasks were generated
        $this->assertDatabaseHas('jurnal_kerja', [
            'user_id' => $wakaSMP->id,
            'judul' => 'Review teknis berkas usulan revisi TP & materi silabus unit',
        ]);

        // 2. Guru submits proposal in SMP unit
        $guru = User::where('username', 'guru.ahmad')->first();
        $mapel = MataPelajaran::where('kode_mapel', 'MAT-SMP-01')->first();

        $this->actingAs($guru)->post(route('curriculum.proposal.store'), [
            'mapel_id' => $mapel->id,
            'jenis_usulan' => 'Tambah',
            'objek_data' => 'TP',
            'judul_usulan' => 'TP Khusus Pengayaan Geometri Ruang Santri',
            'deskripsi_usulan' => 'Santri mampu mengkonstruksi jaring-jaring kubus dan balok.',
            'alasan_pengajuan' => 'Taksonomi Bloom C6 (Mencipta) berbasis kerajinan santri.',
        ]);

        $usulan = UsulanPerubahan::where('judul_usulan', 'TP Khusus Pengayaan Geometri Ruang Santri')->first();
        $this->assertNotNull($usulan);

        // 3. Waka Kurikulum reviews and approves the proposal
        $reviewResponse = $this->actingAs($wakaSMP)->post(route('usulan.review', $usulan->id), [
            'keputusan' => 'setujui',
        ]);
        $reviewResponse->assertSessionHas('success');
        $this->assertEquals('Disetujui', $usulan->fresh()->status);
        $this->assertEquals($wakaSMP->id, $usulan->fresh()->peninjau_id);

        // 4. Waka can manage teaching assignments (assignMapel) for teachers in their unit
        $this->actingAs($wakaSMP)->get(route('admin.users'))->assertStatus(200);

        $assignResponse = $this->actingAs($wakaSMP)->post(route('admin.assign.mapel'), [
            'pengguna_id' => $guru->id,
            'mapel_id' => $mapel->id,
            'beban_jp' => 28,
            'jumlah_rombel' => 5,
        ]);
        $assignResponse->assertSessionHas('success');
        $this->assertDatabaseHas('penugasan_guru', [
            'pengguna_id' => $guru->id,
            'mapel_id' => $mapel->id,
            'beban_jp' => 28,
        ]);

        // 5. Waka can send KBM reminder notification to teacher
        $remindResponse = $this->actingAs($wakaSMP)->post(route('jurnal.remind', $guru->id));
        $remindResponse->assertSessionHas('success');
        $this->assertDatabaseHas('notifikasi', [
            'user_id' => $guru->id,
            'tipe' => 'kbm_reminder',
        ]);
    }

    public function test_arsip_kurikulum_and_annual_inspection_flow(): void
    {
        $wakaSMP = User::where('username', 'waka.smp')->first();
        $admin = User::where('username', 'admin')->first();
        $guru = User::where('username', 'guru.ahmad')->first();
        $unitSMP = \App\Models\UnitPendidikan::where('kode_unit', 'SMP-ALFA')->first();

        // 1. Waka SMP can access /arsip
        $responseArsip = $this->actingAs($wakaSMP)->get(route('arsip.index'));
        $responseArsip->assertStatus(200);
        $responseArsip->assertSee('Arsip Dokumen Kurikulum &amp; Pengawasan Tahunan', false);

        // 2. Waka can store a new inspection document
        $storeResponse = $this->actingAs($wakaSMP)->post(route('arsip.store'), [
            'unit_id' => $unitSMP->id,
            'judul_dokumen' => 'Modul Ajar Matematika Diferensiasi Fase D',
            'kategori' => 'modul_ajar',
            'tahun_ajaran' => '2024/2025',
            'semester' => 'Ganjil',
            'tingkat_fase' => 'Fase D (Kelas 7)',
            'status_verifikasi' => 'Menunggu Supervisi',
            'nama_pengawas' => 'Drs. H. Suwandi, M.Pd.',
            'catatan_supervisi' => 'Menunggu visitasi pengawas semester ganjil.',
            'file_size' => '3.5 MB PDF',
            'tanggal_arsip' => '2024-09-01',
        ]);
        $storeResponse->assertSessionHas('success');

        $doc = \App\Models\ArsipDokumen::where('judul_dokumen', 'Modul Ajar Matematika Diferensiasi Fase D')->first();
        $this->assertNotNull($doc);
        $this->assertStringStartsWith('DOK-MOD-', $doc->kode_dokumen);
        $this->assertEquals('Menunggu Supervisi', $doc->status_verifikasi);

        // 3. Filter by unit and category
        $filterResponse = $this->actingAs($wakaSMP)->get(route('arsip.index', [
            'unit_id' => $unitSMP->id,
            'kategori' => 'modul_ajar',
        ]));
        $filterResponse->assertStatus(200);
        $filterResponse->assertSee($doc->kode_dokumen);

        // 4. Update status by Waka / Pengawas to 'Terverifikasi'
        $statusResponse = $this->actingAs($wakaSMP)->post(route('arsip.status', $doc->id), [
            'status_verifikasi' => 'Terverifikasi',
            'nama_pengawas' => 'Drs. H. Suwandi, M.Pd.',
            'catatan_supervisi' => 'Modul ajar telah memuat asesmen diagnostik dan diferensiasi konten secara optimal.',
        ]);
        $statusResponse->assertSessionHas('success');

        $doc->refresh();
        $this->assertEquals('Terverifikasi', $doc->status_verifikasi);
        $this->assertStringContainsString('diferensiasi konten', $doc->catatan_supervisi);

        // 5. Guru cannot delete official archive documents
        $guruDeleteResponse = $this->actingAs($guru)->delete(route('arsip.destroy', $doc->id));
        $guruDeleteResponse->assertSessionHas('error');
        $this->assertDatabaseHas('arsip_dokumen', ['id' => $doc->id]);

        // 6. Admin can delete archive document
        $adminDeleteResponse = $this->actingAs($admin)->delete(route('arsip.destroy', $doc->id));
        $adminDeleteResponse->assertSessionHas('success');
        $this->assertDatabaseMissing('arsip_dokumen', ['id' => $doc->id]);
    }
}

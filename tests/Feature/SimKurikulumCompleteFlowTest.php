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

        // Test Login Page as Root
        $this->get('/')->assertStatus(200);
        $this->get('/login')->assertStatus(200);
        $this->get('/standar-prosedur')->assertRedirect('/login');
        $this->get('/sop')->assertRedirect('/login');

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

        // Test Forgot Password Flow
        $this->get('/forgot-password')->assertStatus(200)->assertSee('Bantuan Lupa Kata Sandi');

        // Test Forgot Password Validation Failure (wrong email)
        $this->from('/login')->post('/forgot-password/reset', [
            'email' => 'tidakada@alimasykur.sch.id',
            'nip_or_username' => 'guru.ahmad',
            'password' => 'passwordbaru123',
            'password_confirmation' => 'passwordbaru123',
        ])->assertRedirect('/login')->assertSessionHas('forgot_error');

        // Test Forgot Password Success
        $resetResponse = $this->from('/login')->post('/forgot-password/reset', [
            'email' => $guru->email,
            'nip_or_username' => $guru->username,
            'password' => 'sandiBaruAhmad99',
            'password_confirmation' => 'sandiBaruAhmad99',
        ]);
        $resetResponse->assertRedirect('/login');
        $resetResponse->assertSessionHas('success');

        // Verify login works with new password
        $this->post('/login', [
            'identity' => $guru->username,
            'password' => 'sandiBaruAhmad99',
        ])->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();
        $this->post('/logout');

        // Test Dashboard
        $this->actingAs($guru)->get('/dashboard')->assertStatus(200);

        // Test Mata Pelajaran & Workspace (Katalog vs Workspace view)
        $this->actingAs($guru)->get('/mata-pelajaran')->assertStatus(200);
        $this->actingAs($guru)->get('/mata-pelajaran?view=katalog')
            ->assertStatus(200)
            ->assertSee('Katalog Mata Pelajaran &amp; Silabus', false)
            ->assertSee('SMP Alfa Ali Masykur');
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

    public function test_segmented_roles_for_mi_smp_sma_and_admin_edit_user_flow(): void
    {
        $admin = User::where('username', 'admin')->first();
        $this->assertNotNull($admin);

        // 1. Verify that all 15 segmented roles exist in the database (5 per segment)
        $expectedSegmentRoles = [
            'MI' => ['Guru MI', 'Waka Kurikulum MI', 'Kepala Sekolah (Kepsek) MI', 'Admin 1 MI', 'Pembina Ekstrakurikuler MI'],
            'SMP' => ['Guru SMP', 'Waka Kurikulum SMP', 'Kepala Sekolah (Kepsek) SMP', 'Admin 2 SMP', 'Pembina Ekstrakurikuler SMP'],
            'SMA' => ['Guru SMA', 'Waka Kurikulum SMA', 'Kepala Sekolah (Kepsek) SMA', 'Admin 3 SMA', 'Pembina Ekstrakurikuler SMA'],
        ];

        foreach ($expectedSegmentRoles as $segment => $roles) {
            foreach ($roles as $roleName) {
                $this->assertDatabaseHas('peran', [
                    'nama_peran' => $roleName,
                ]);
            }
        }

        // Verify generic roles are cleanly deleted
        $this->assertDatabaseMissing('peran', ['nama_peran' => 'Admin Sistem']);
        $this->assertDatabaseMissing('peran', ['nama_peran' => 'Kepala Sekolah/Madrasah']);
        $this->assertDatabaseMissing('peran', ['nama_peran' => 'Guru Mata Pelajaran']);
        $this->assertDatabaseMissing('peran', ['nama_peran' => 'Waka Kurikulum']);
        $this->assertDatabaseMissing('peran', ['nama_peran' => 'Pembina Ekstrakurikuler']);

        // Verify Yayasan role remains solely for Yayasan
        $this->assertDatabaseHas('peran', ['nama_peran' => 'Pengurus Yayasan']);

        $unitMI = \App\Models\UnitPendidikan::where('kode_unit', 'like', '%MI%')->first();
        $unitSMP = \App\Models\UnitPendidikan::where('kode_unit', 'like', '%SMP%')->first();
        $roleGuruMI = \App\Models\Peran::where('nama_peran', 'Guru MI')->first();
        $roleWakaMI = \App\Models\Peran::where('nama_peran', 'Waka Kurikulum MI')->first();
        $roleKepsekMI = \App\Models\Peran::where('nama_peran', 'Kepala Sekolah (Kepsek) MI')->first();
        $roleAdminMI = \App\Models\Peran::where('nama_peran', 'Admin 1 MI')->first();
        $rolePembinaMI = \App\Models\Peran::where('nama_peran', 'Pembina Ekstrakurikuler MI')->first();

        // 2. Admin creates a new user with segmented role (Guru MI) with auto-resolved or specified unit
        $createResponse = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Ustadzah Nurul Hidayah, S.Pd.',
            'username' => 'guru.nurul',
            'email' => 'nurul@alimasykur.sch.id',
            'nip' => '199505052024012001',
            'peran_id' => $roleGuruMI->id,
            'unit_id' => null, // Test auto-resolution to MI unit!
            'jabatan' => 'Guru Kelas 1 MI',
            'password' => 'password123',
        ]);
        $createResponse->assertSessionHas('success');

        $createdUser = User::where('username', 'guru.nurul')->first();
        $this->assertNotNull($createdUser);
        $this->assertEquals($unitMI->id, $createdUser->unit_id);
        $this->assertTrue($createdUser->isGuru());

        // 3. Admin edits existing user's role segment, unit, and details
        $updateResponse = $this->actingAs($admin)->post(route('admin.users.update', $createdUser->id), [
            'name' => 'Ustadzah Nurul Hidayah, M.Pd.',
            'username' => 'nurul.hidayah',
            'email' => 'nurul.hidayah@alimasykur.sch.id',
            'nip' => '199505052024012001',
            'peran_id' => $roleWakaMI->id,
            'unit_id' => $unitMI->id,
            'jabatan' => 'Waka Kurikulum MI Tahfidz Alfa',
            'status_aktif' => 1,
            'password' => 'newpassword123',
        ]);
        $updateResponse->assertSessionHas('success');

        $updatedUser = $createdUser->fresh();
        $this->assertEquals('Ustadzah Nurul Hidayah, M.Pd.', $updatedUser->name);
        $this->assertEquals('nurul.hidayah', $updatedUser->username);
        $this->assertEquals($roleWakaMI->id, $updatedUser->peran_id);
        $this->assertTrue($updatedUser->isWakaKurikulum());

        // 4. Test Kepsek role detection with isKepalaSekolah()
        $updatedUser->update(['peran_id' => $roleKepsekMI->id]);
        $this->assertTrue($updatedUser->fresh()->isKepalaSekolah());

        // Test Pembina role detection with isPembina()
        $updatedUser->update(['peran_id' => $rolePembinaMI->id]);
        $this->assertTrue($updatedUser->fresh()->isPembina());

        // 5. Test 3 segment admin permissions (Admin 1 MI, Admin 2 SMP, Admin 3 SMA share admin duties)
        $adminMIUser = User::where('username', 'admin.mi')->first();
        if (!$adminMIUser) {
            $adminMIUser = User::create([
                'peran_id' => $roleAdminMI->id,
                'unit_id' => $unitMI->id,
                'name' => 'Admin MI Test',
                'username' => 'admin.mi.test',
                'email' => 'admin.mi.test@alimasykur.sch.id',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'status_aktif' => true,
            ]);
        }
        $this->assertTrue($adminMIUser->isAdmin());
        $this->assertTrue($adminMIUser->canAccessAllUnits());
        $this->assertTrue($adminMIUser->canManageUnit($unitMI->id));

        // Admin MI can edit user
        $adminMIAttempt = $this->actingAs($adminMIUser)->post(route('admin.users.update', $updatedUser->id), [
            'name' => 'Ustadzah Nurul Hidayah, M.Pd. (Verified)',
            'username' => 'nurul.hidayah',
            'email' => 'nurul.hidayah@alimasykur.sch.id',
            'peran_id' => $roleWakaMI->id,
            'unit_id' => $unitMI->id,
            'status_aktif' => 1,
        ]);
        $adminMIAttempt->assertSessionHas('success');

        // Admin can edit SMP user role segment
        $guruSMP = User::where('username', 'guru.ahmad')->first();
        $adminSMPEditAttempt = $this->actingAs($adminMIUser)->post(route('admin.users.update', $guruSMP->id), [
            'name' => 'Ustadz Ahmad Fauzi, S.Pd. (Updated)',
            'username' => 'guru.ahmad',
            'email' => 'ahmad.fauzi@alimasykur.sch.id',
            'peran_id' => $guruSMP->peran_id,
            'unit_id' => $guruSMP->unit_id,
            'status_aktif' => 1,
        ]);
        $adminSMPEditAttempt->assertSessionHas('success');
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
        $responseArsip->assertSee('Daftar Arsip Dokumen');

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

    public function test_multi_tenancy_and_strict_unit_scoping_per_user_role(): void
    {
        $wakaMI = User::where('username', 'waka.mi')->first();
        $kepsekMI = User::where('username', 'kepsek.mi')->first();
        $wakaSMP = User::where('username', 'waka.smp')->first();
        $yayasan = User::where('username', 'yayasan')->first();
        $admin = User::where('username', 'admin')->first();

        $mapelSMP = \App\Models\MataPelajaran::whereHas('kurikulum.unit', fn($q) => $q->where('kode_unit', 'SMP-ALFA'))->first();
        $mapelMI = \App\Models\MataPelajaran::whereHas('kurikulum.unit', fn($q) => $q->where('kode_unit', 'MI-ALFA'))->first();
        $mapelSMA = \App\Models\MataPelajaran::whereHas('kurikulum.unit', fn($q) => $q->where('kode_unit', 'SMA-ALFA'))->first();

        // 1. Waka MI cannot access /yayasan/monitoring (restricted to Admin & Yayasan)
        $wakaYayasanAttempt = $this->actingAs($wakaMI)->get('/yayasan/monitoring');
        $wakaYayasanAttempt->assertRedirect(route('dashboard'));
        $wakaYayasanAttempt->assertSessionHas('error');

        // 2. Yayasan and Admin CAN access /yayasan/monitoring
        $this->actingAs($yayasan)->get('/yayasan/monitoring')->assertStatus(200);
        $this->actingAs($admin)->get('/yayasan/monitoring')->assertStatus(200);

        // 3. Waka MI in Katalog view only sees MI subjects, NOT SMP or SMA
        $katalogMIResponse = $this->actingAs($wakaMI)->get('/mata-pelajaran?view=katalog');
        $katalogMIResponse->assertStatus(200);
        $katalogMIResponse->assertSee($mapelMI->nama_mapel);
        $katalogMIResponse->assertDontSee($mapelSMP->nama_mapel);
        $katalogMIResponse->assertDontSee($mapelSMA->nama_mapel);

        // 4. Waka MI cannot access SMP subject workspace via mapel_id (redirected with error)
        $crossUnitAttempt = $this->actingAs($wakaMI)->get('/mata-pelajaran?mapel_id=' . $mapelSMP->id . '&view=workspace');
        $crossUnitAttempt->assertRedirect(route('curriculum.index', ['view' => 'katalog']));
        $crossUnitAttempt->assertSessionHas('error');

        // 5. Yayasan can see all subjects in Katalog (MI, SMP, SMA)
        $katalogYayasanResponse = $this->actingAs($yayasan)->get('/mata-pelajaran?view=katalog');
        $katalogYayasanResponse->assertStatus(200);
        $katalogYayasanResponse->assertSee($mapelMI->nama_mapel);
        $katalogYayasanResponse->assertSee($mapelSMP->nama_mapel);
        $katalogYayasanResponse->assertSee($mapelSMA->nama_mapel);

        // 6. Waka MI cannot review proposals from SMP
        $usulanSMP = \App\Models\UsulanPerubahan::whereHas('mataPelajaran.kurikulum.unit', fn($q) => $q->where('kode_unit', 'SMP-ALFA'))->first();
        if ($usulanSMP) {
            $crossReviewAttempt = $this->actingAs($wakaMI)->post(route('usulan.review', $usulanSMP->id), [
                'keputusan' => 'setujui',
            ]);
            $crossReviewAttempt->assertSessionHas('error');
        }

        // 7. Waka MI in Arsip only sees MI documents
        $arsipMIResponse = $this->actingAs($wakaMI)->get(route('arsip.index'));
        $arsipMIResponse->assertStatus(200);
        $arsipMIResponse->assertSee('MI Tahfidz Alfa Ali Masykur');
    }

    public function test_calendar_agenda_editing_date_range_colors_and_deadline_notifications(): void
    {
        $guru = User::where('username', 'guru.ahmad')->first();
        $this->assertNotNull($guru);

        // 1. Create agenda with date range, custom color, and note
        $startDate = now()->format('Y-m-d');
        $endDate = now()->addDays(3)->format('Y-m-d');

        $storeResponse = $this->actingAs($guru)->post(route('jurnal-kerja.store'), [
            'judul' => 'Penyusunan Modul Ajar Aljabar',
            'kategori' => 'administrasi',
            'prioritas' => 'tinggi',
            'tanggal_mulai' => $startDate,
            'tanggal_selesai' => $endDate,
            'warna' => '#059669',
            'catatan' => 'Siapkan modul ajar dan lembar asesmen formatif',
        ], ['Accept' => 'application/json']);

        $storeResponse->assertStatus(200);
        $storeResponse->assertJson(['success' => true]);

        $createdTask = \App\Models\JurnalKerja::where('user_id', $guru->id)
            ->where('judul', 'Penyusunan Modul Ajar Aljabar')
            ->first();
        $this->assertNotNull($createdTask);
        $this->assertEquals($startDate, $createdTask->tanggal_mulai->format('Y-m-d'));
        $this->assertEquals($endDate, $createdTask->tanggal_selesai->format('Y-m-d'));
        $this->assertEquals('#059669', $createdTask->warna);
        $this->assertEquals('Siapkan modul ajar dan lembar asesmen formatif', $createdTask->catatan);
        $this->assertFalse((bool)$createdTask->notif_deadline_sent);

        // 2. Edit / update agenda (change dates, color, notes, status)
        $newEndDate = now()->addDays(5)->format('Y-m-d');
        $updateResponse = $this->actingAs($guru)->post("/jurnal-kerja/{$createdTask->id}/update", [
            'judul' => 'Penyusunan Modul Ajar Aljabar Revisi',
            'kategori' => 'administrasi',
            'prioritas' => 'tinggi',
            'status' => 'proses',
            'tanggal_mulai' => $startDate,
            'tanggal_selesai' => $newEndDate,
            'warna' => '#e11d48',
            'catatan' => 'Tambahkan rubrik penilaian kelompok',
        ], ['Accept' => 'application/json']);

        $updateResponse->assertStatus(200);
        $updateResponse->assertJson(['success' => true]);

        $createdTask->refresh();
        $this->assertEquals('Penyusunan Modul Ajar Aljabar Revisi', $createdTask->judul);
        $this->assertEquals($newEndDate, $createdTask->tanggal_selesai->format('Y-m-d'));
        $this->assertEquals('#e11d48', $createdTask->warna);
        $this->assertEquals('Tambahkan rubrik penilaian kelompok', $createdTask->catatan);
        $this->assertEquals('proses', $createdTask->status);

        // 3. Calendar events JSON endpoint feed
        $eventsResponse = $this->actingAs($guru)->get('/jurnal-kerja/events');
        $eventsResponse->assertStatus(200);
        $events = $eventsResponse->json();
        $this->assertIsArray($events);
        $eventFound = collect($events)->firstWhere('id', $createdTask->id);
        $this->assertNotNull($eventFound);
        $this->assertEquals('#e11d48', $eventFound['warna']);
        $this->assertEquals($startDate, $eventFound['start']);
        $this->assertEquals($newEndDate, $eventFound['end']);

        // 4. Automated deadline notification
        // Simulate a task due today or overdue
        $deadlineTask = \App\Models\JurnalKerja::create([
            'user_id' => $guru->id,
            'judul' => 'Deadline Submit Soal PTS Matematika',
            'kategori' => 'penilaian',
            'tanggal_mulai' => now()->subDays(2)->format('Y-m-d'),
            'tanggal_selesai' => now()->format('Y-m-d'), // Today
            'tanggal_target' => now()->format('Y-m-d'),
            'prioritas' => 'tinggi',
            'status' => 'belum',
            'warna' => '#e11d48',
            'catatan' => 'Serahkan naskah soal ke Waka Kurikulum',
            'notif_deadline_sent' => false,
        ]);

        $notifCountBefore = \App\Models\Notifikasi::where('user_id', $guru->id)
            ->where('tipe', 'deadline_reminder')
            ->count();

        // Run deadline checker
        \App\Services\NotificationService::checkAndNotifyUserDeadlines($guru->id);

        $deadlineTask->refresh();
        $this->assertTrue((bool)$deadlineTask->notif_deadline_sent);

        $notifCountAfter = \App\Models\Notifikasi::where('user_id', $guru->id)
            ->where('tipe', 'deadline_reminder')
            ->count();
        $this->assertEquals($notifCountBefore + 1, $notifCountAfter);

        // Re-running checker should not produce duplicates
        \App\Services\NotificationService::checkAndNotifyUserDeadlines($guru->id);
        $notifCountAfterSecond = \App\Models\Notifikasi::where('user_id', $guru->id)
            ->where('tipe', 'deadline_reminder')
            ->count();
        $this->assertEquals($notifCountAfter, $notifCountAfterSecond);

        // 5. Delete agenda
        $deleteResponse = $this->actingAs($guru)->delete("/jurnal-kerja/{$createdTask->id}", [], ['Accept' => 'application/json']);
        $deleteResponse->assertStatus(200);
        $deleteResponse->assertJson(['success' => true]);
        $this->assertDatabaseMissing('jurnal_kerja', ['id' => $createdTask->id]);

        $deadlineTask->delete();
    }

    public function test_materi_document_upload_validation_and_download_flow(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $guru = User::where('username', 'guru.ahmad')->first();
        $materi = \App\Models\Materi::whereHas('tujuanPembelajaran.capaianPembelajaran.mataPelajaran.kurikulum.unit', function ($q) {
            $q->where('kode_unit', 'SMP-ALFA');
        })->first();

        $this->assertNotNull($materi);

        // 1. Validation test: Invalid file format (.exe) should be rejected
        $invalidFile = \Illuminate\Http\UploadedFile::fake()->create('malicious.exe', 500, 'application/x-msdownload');
        $failResponse = $this->actingAs($guru)->post(route('curriculum.materi.upload', $materi->id), [
            'dokumen' => $invalidFile,
        ], ['Accept' => 'application/json']);
        $failResponse->assertStatus(422);
        $failResponse->assertJsonValidationErrors(['dokumen']);

        // 2. Successful Upload: PDF file
        $validPdf = \Illuminate\Http\UploadedFile::fake()->create('Modul_Ajar_Bab1.pdf', 1024, 'application/pdf');
        $successResponse = $this->actingAs($guru)->post(route('curriculum.materi.upload', $materi->id), [
            'dokumen' => $validPdf,
        ], ['Accept' => 'application/json']);
        $successResponse->assertStatus(200);
        $successResponse->assertJson(['success' => true]);

        $materi->refresh();
        $this->assertEquals('Modul_Ajar_Bab1.pdf', $materi->file_name);
        $this->assertEquals('pdf', $materi->file_type);
        $this->assertNotNull($materi->file_path);
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($materi->file_path);

        // 3. Download Endpoint
        $downloadResponse = $this->actingAs($guru)->get(route('curriculum.materi.download', $materi->id));
        $downloadResponse->assertStatus(200);

        // 4. Delete File Endpoint
        $deleteResponse = $this->actingAs($guru)->delete(route('curriculum.materi.delete_file', $materi->id), [], [
            'Accept' => 'application/json'
        ]);
        $deleteResponse->assertStatus(200);
        $deleteResponse->assertJson(['success' => true]);

        $materi->refresh();
        $this->assertNull($materi->file_path);
        $this->assertNull($materi->file_name);
        $this->assertFalse($materi->hasDocument());

        // 5. Cross-unit authorization check: Guru SMP cannot upload to Materi MI
        $materiMI = \App\Models\Materi::whereHas('tujuanPembelajaran.capaianPembelajaran.mataPelajaran.kurikulum.unit', function ($q) {
            $q->where('kode_unit', 'MI-ALFA');
        })->first();
        if ($materiMI) {
            $crossUpload = $this->actingAs($guru)->post(route('curriculum.materi.upload', $materiMI->id), [
                'dokumen' => $validPdf,
            ], ['Accept' => 'application/json']);
            $crossUpload->assertStatus(403);
        }
    }

    public function test_helpdesk_chat_with_administrator_and_attachment_flow(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $guru = User::where('username', 'guru.ahmad')->first();
        $admin = User::where('username', 'admin')->first();
        $wakaMI = User::where('username', 'waka.mi')->first();

        // 1. Guru accesses helpdesk chat
        $guruView = $this->actingAs($guru)->get(route('helpdesk.index'));
        $guruView->assertStatus(200);
        $guruView->assertSee('Hubungi Administrator');

        $thread = \App\Models\AdminChatThread::where('user_id', $guru->id)->first();
        $this->assertNotNull($thread);

        // 2. Guru sends message with an attached screenshot image
        $imageFile = \Illuminate\Http\UploadedFile::fake()->create('kendala_tampilan.png', 500, 'image/png');
        $sendResponse = $this->actingAs($guru)->post(route('helpdesk.send', $thread->id), [
            'pesan' => 'Mohon bantuan admin, ada kendala pada tampilan silabus saya.',
            'lampiran' => $imageFile,
        ], ['Accept' => 'application/json']);
        $sendResponse->assertStatus(200);
        $sendResponse->assertJson(['success' => true]);

        $thread->refresh();
        $this->assertEquals(1, $thread->unread_for_admin);
        $this->assertStringContainsString('Mohon bantuan admin', $thread->last_message_preview);

        $lastGuruMsg = $thread->messages()->latest('id')->first();
        $this->assertNotNull($lastGuruMsg);
        $this->assertEquals('kendala_tampilan.png', $lastGuruMsg->file_name);
        $this->assertEquals('image', $lastGuruMsg->file_type);
        $this->assertTrue($lastGuruMsg->isImage());
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($lastGuruMsg->file_path);

        // Verify Admin received notification
        $adminNotif = \App\Models\Notifikasi::where('user_id', $admin->id)
            ->where('tipe', 'chat_admin')
            ->latest('id')
            ->first();
        $this->assertNotNull($adminNotif);
        $this->assertStringContainsString('Pesan Bantuan', $adminNotif->judul);

        // 3. Admin opens helpdesk index
        $adminView = $this->actingAs($admin)->get(route('helpdesk.index', ['thread_id' => $thread->id]));
        $adminView->assertStatus(200);
        $adminView->assertSee('Kotak Masuk Bantuan');
        $adminView->assertSee($guru->name);

        $thread->refresh();
        $this->assertEquals(0, $thread->unread_for_admin); // Marked as read

        // 4. Admin replies with an attached PDF document
        $pdfFile = \Illuminate\Http\UploadedFile::fake()->create('Solusi_Teknis.pdf', 512, 'application/pdf');
        $adminReply = $this->actingAs($admin)->post(route('helpdesk.send', $thread->id), [
            'pesan' => 'Halo Pak Ahmad, sudah kami perbaiki. Silakan cek berkas panduan terlampir.',
            'lampiran' => $pdfFile,
        ], ['Accept' => 'application/json']);
        $adminReply->assertStatus(200);

        $thread->refresh();
        $this->assertEquals(1, $thread->unread_for_user);

        $lastAdminMsg = $thread->messages()->latest('id')->first();
        $this->assertEquals('Solusi_Teknis.pdf', $lastAdminMsg->file_name);
        $this->assertEquals('pdf', $lastAdminMsg->file_type);
        $this->assertTrue($lastAdminMsg->isDocument());

        // Verify Guru received notification
        $guruNotif = \App\Models\Notifikasi::where('user_id', $guru->id)
            ->where('tipe', 'chat_admin')
            ->latest('id')
            ->first();
        $this->assertNotNull($guruNotif);
        $this->assertEquals('Balasan Administrator', $guruNotif->judul);

        // 5. Polling endpoint
        $pollResponse = $this->actingAs($guru)->get(route('helpdesk.poll', ['threadId' => $thread->id, 'after_id' => $lastGuruMsg->id]));
        $pollResponse->assertStatus(200);
        $pollData = $pollResponse->json();
        $this->assertTrue($pollData['success']);
        $this->assertCount(1, $pollData['messages']);
        $this->assertEquals('Solusi_Teknis.pdf', $pollData['messages'][0]['file_name']);

        // 6. Download attachment
        $downloadResponse = $this->actingAs($guru)->get(route('helpdesk.download', $lastAdminMsg->id));
        $downloadResponse->assertStatus(200);

        // 7. Toggle ticket status
        $statusToggle = $this->actingAs($admin)->post(route('helpdesk.status', $thread->id), [], ['Accept' => 'application/json']);
        $statusToggle->assertStatus(200);
        $this->assertEquals('resolved', $statusToggle->json('status'));

        // 8. Guru sends message again -> automatically reopens
        $followUp = $this->actingAs($guru)->post(route('helpdesk.send', $thread->id), [
            'pesan' => 'Terima kasih banyak tim IT, masalah sudah selesai!',
        ], ['Accept' => 'application/json']);
        $followUp->assertStatus(200);

        $thread->refresh();
        $this->assertEquals('open', $thread->status);

        // 9. Cross-user security check: Waka MI cannot send message to Guru Ahmad's thread
        $unauthorizedSend = $this->actingAs($wakaMI)->post(route('helpdesk.send', $thread->id), [
            'pesan' => 'Mencoba kirim ke thread orang lain.',
        ], ['Accept' => 'application/json']);
        $unauthorizedSend->assertStatus(403);
    }

    public function test_user_can_edit_their_own_profile_data_and_password_flow(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $guru = User::where('username', 'guru.ahmad')->first();
        $this->assertNotNull($guru);

        // 1. Access profile edit page
        $pageResponse = $this->actingAs($guru)->get(route('profile.edit'));
        $pageResponse->assertStatus(200);
        $pageResponse->assertSee($guru->name);
        $pageResponse->assertSee('Perbarui Data Diri');

        // 2. Update profile with new info and avatar
        $avatarFile = \Illuminate\Http\UploadedFile::fake()->create('profile_foto.png', 300, 'image/png');

        $updateResponse = $this->actingAs($guru)->post(route('profile.update'), [
            'name' => 'Ahmad Fauzi, S.Pd., M.Pd.',
            'email' => 'ahmad.fauzi.guru@alimasykur.sch.id',
            'nomor_telepon' => '0812-9876-5432',
            'nip' => '198801012015011003',
            'jabatan' => 'Guru Senior Matematika SMP',
            'alamat' => 'Jl. Menara No. 45 Kudus',
            'bio' => 'Pendidik matematika dengan pendekatan diferensiasi berbasis proyek.',
            'avatar' => $avatarFile,
        ]);

        $updateResponse->assertSessionHas('success');

        $guru->refresh();
        $this->assertEquals('Ahmad Fauzi, S.Pd., M.Pd.', $guru->name);
        $this->assertEquals('ahmad.fauzi.guru@alimasykur.sch.id', $guru->email);
        $this->assertEquals('0812-9876-5432', $guru->nomor_telepon);
        $this->assertEquals('198801012015011003', $guru->nip);
        $this->assertEquals('Guru Senior Matematika SMP', $guru->jabatan);
        $this->assertEquals('Jl. Menara No. 45 Kudus', $guru->alamat);
        $this->assertEquals('Pendidik matematika dengan pendekatan diferensiasi berbasis proyek.', $guru->bio);
        $this->assertNotNull($guru->avatar_url);
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($guru->avatar_url);

        // 3. Test validation: invalid email or duplicate email
        $duplicateResponse = $this->actingAs($guru)->post(route('profile.update'), [
            'name' => 'Ahmad Fauzi',
            'email' => 'admin@alimasykur.sch.id', // Already taken by admin
        ]);
        $duplicateResponse->assertSessionHasErrors(['email']);

        // 4. Update Password flow
        // Wrong current password
        $wrongPass = $this->actingAs($guru)->post(route('profile.password'), [
            'current_password' => 'passwordsalah123',
            'password' => 'passwordbaru123',
            'password_confirmation' => 'passwordbaru123',
        ]);
        $wrongPass->assertSessionHasErrors(['current_password']);

        // Password mismatch confirmation
        $mismatchPass = $this->actingAs($guru)->post(route('profile.password'), [
            'current_password' => 'password',
            'password' => 'passwordbaru123',
            'password_confirmation' => 'tidaksama123',
        ]);
        $mismatchPass->assertSessionHasErrors(['password']);

        // Successful password update
        $validPass = $this->actingAs($guru)->post(route('profile.password'), [
            'current_password' => 'password',
            'password' => 'passwordbaru123',
            'password_confirmation' => 'passwordbaru123',
        ]);
        $validPass->assertSessionHas('success');

        // Verify can login with new password
        $this->post('/logout');
        $loginResponse = $this->post(route('login.submit'), [
            'identity' => $guru->username,
            'password' => 'passwordbaru123',
        ]);
        $loginResponse->assertRedirect(route('dashboard'));

        // 5. Delete avatar
        $this->actingAs($guru);
        $deleteAvatarResponse = $this->delete(route('profile.avatar.delete'));
        $deleteAvatarResponse->assertSessionHas('success');

        $guru->refresh();
        $this->assertNull($guru->avatar_url);
        $this->assertNull($guru->avatar_image);
    }

    public function test_system_audit_improvements_and_bureaucratic_controls(): void
    {
        // 1. Setup Guru SMP, Kepala Sekolah SMP, and Mapels
        $guru = \App\Models\User::where('username', 'guru.ahmad')->first();
        $kepsek = \App\Models\User::where('username', 'kepsek.smp')->first();
        $admin = \App\Models\User::where('username', 'admin')->first();

        $assignedMapel = $guru->penugasan()->first()->mataPelajaran;
        $kurikulum = $assignedMapel->kurikulum;

        // An unassigned mapel in the same unit
        $unassignedMapel = \App\Models\MataPelajaran::whereHas('kurikulum', fn($q) => $q->where('unit_id', $guru->unit_id))
            ->whereNotIn('id', $guru->penugasan()->pluck('mapel_id'))
            ->first();
        if (!$unassignedMapel) {
            $unassignedMapel = \App\Models\MataPelajaran::create([
                'kurikulum_id' => $kurikulum->id,
                'kode_mapel' => 'IPA-TEST',
                'nama_mapel' => 'Ilmu Pengetahuan Alam SMP Test',
                'fase' => 'D',
                'tingkat_kelas' => 'VII',
                'alokasi_jp_minggu' => 4,
                'alokasi_jp_tahun' => 144,
                'kategori' => 'Wajib',
                'status' => 'Aktif',
            ]);
        }

        // 2. Strict Subject Penugasan check: Guru cannot submit proposal for unassigned mapel
        $forbiddenResponse = $this->actingAs($guru)->post(route('curriculum.proposal.store'), [
            'mapel_id' => $unassignedMapel->id,
            'jenis_usulan' => 'Tambah',
            'objek_data' => 'Materi',
            'judul_usulan' => 'Percobaan Usulan Mapel Lain',
            'alasan_pengajuan' => 'Mencoba mengajukan tanpa penugasan resmi.',
            'deskripsi_usulan' => 'Pengayaan Materi Asing',
        ]);
        $forbiddenResponse->assertSessionHas('error');
        $this->assertStringContainsString('guru pengampu', session('error'));

        // 3. Curriculum Lock: Kepala Sekolah locks the curriculum
        $lockResponse = $this->actingAs($kepsek)->post(route('curriculum.toggle_lock', $kurikulum->id));
        $lockResponse->assertSessionHas('success');
        $kurikulum->refresh();
        $this->assertTrue((bool)$kurikulum->is_locked);
        $this->assertEquals($kepsek->id, $kurikulum->locked_by);
        $this->assertNotNull($kurikulum->locked_at);

        // Guru attempts to propose changes while curriculum is locked -> BLOCKED
        $blockedByLockResponse = $this->actingAs($guru)->post(route('curriculum.proposal.store'), [
            'mapel_id' => $assignedMapel->id,
            'jenis_usulan' => 'Tambah',
            'objek_data' => 'Materi',
            'judul_usulan' => 'Materi Baru Pasca Lock',
            'alasan_pengajuan' => 'Penambahan materi ketika kurikulum dikunci.',
            'deskripsi_usulan' => 'Bab Pembahasan Baru',
        ]);
        $blockedByLockResponse->assertSessionHas('error');
        $this->assertStringContainsString('Periode Kurikulum Terkunci', session('error'));

        // Unlock curriculum
        $unlockResponse = $this->actingAs($kepsek)->post(route('curriculum.toggle_lock', $kurikulum->id));
        $unlockResponse->assertSessionHas('success');
        $kurikulum->refresh();
        $this->assertFalse((bool)$kurikulum->is_locked);

        // 4. Guru submits valid proposal on assigned mapel
        $validProposalResponse = $this->actingAs($guru)->post(route('curriculum.proposal.store'), [
            'mapel_id' => $assignedMapel->id,
            'jenis_usulan' => 'Tambah',
            'objek_data' => 'Materi',
            'judul_usulan' => 'Penambahan Modul Aljabar Terapan',
            'alasan_pengajuan' => 'Memperkuat kompetensi numerasi santri sesuai Capaian Pembelajaran Fase D.',
            'deskripsi_usulan' => 'Modul 4: Pemodelan Linear Kontekstual',
        ]);
        $validProposalResponse->assertSessionHas('success');

        $proposal = \App\Models\UsulanPerubahan::where('judul_usulan', 'Penambahan Modul Aljabar Terapan')->latest()->first();
        $this->assertNotNull($proposal);
        $this->assertEquals('Menunggu Persetujuan', $proposal->status);

        // Check SLA status calculation
        $sla = $proposal->sla_status;
        $this->assertIsArray($sla);
        $this->assertArrayHasKey('days', $sla);
        $this->assertArrayHasKey('label', $sla);
        $this->assertArrayHasKey('badge_class', $sla);

        // 5. Kepsek rejects proposal with review feedback
        $rejectResponse = $this->actingAs($kepsek)->post(route('usulan.review', $proposal->id), [
            'keputusan' => 'tolak',
            'alasan_penolakan' => 'Indikator belum memuat contoh aplikatif studi kasus santri.',
        ]);
        $rejectResponse->assertSessionHas('info');
        $proposal->refresh();
        $this->assertEquals('Ditolak', $proposal->status);
        $this->assertEquals('Indikator belum memuat contoh aplikatif studi kasus santri.', $proposal->alasan_penolakan);

        // 6. Guru re-submits rejected proposal with revised rationale
        $resubmitResponse = $this->actingAs($guru)->post(route('usulan.resubmit', $proposal->id), [
            'alasan_pengajuan' => 'Telah diperbaiki dengan menambahkan 3 studi kasus pesantren di bab aljabar.',
        ]);
        $resubmitResponse->assertSessionHas('success');

        $proposal->refresh();
        $this->assertEquals('Menunggu Persetujuan', $proposal->status);
        $this->assertNull($proposal->alasan_penolakan);
        $this->assertStringContainsString('Telah diperbaiki', $proposal->alasan_pengajuan);
        $this->assertStringContainsString('Riwayat Evaluasi', $proposal->alasan_pengajuan);

        // Kepsek approves the resubmitted proposal
        $approveResponse = $this->actingAs($kepsek)->post(route('usulan.review', $proposal->id), [
            'keputusan' => 'setujui',
        ]);
        $approveResponse->assertSessionHas('success');
        $proposal->refresh();
        $this->assertEquals('Disetujui', $proposal->status);

        // 7. Official Syllabus Export View
        $exportResponse = $this->actingAs($guru)->get(route('curriculum.mapel.export', $assignedMapel->id));
        $exportResponse->assertStatus(200);
        $exportResponse->assertSee('YPI ALI MASYKUR');
        $exportResponse->assertSee('ALUR TUJUAN PEMBELAJARAN');
        $exportResponse->assertSee($assignedMapel->nama_mapel);
        $exportResponse->assertSee('Kepala Sekolah');
        $exportResponse->assertSee('Waka Kurikulum');
        $exportResponse->assertSee('Guru Pengampu');
    }

    public function test_role_transparency_and_differentiated_views_per_unit_and_job(): void
    {
        $guru = User::where('username', 'guru.ahmad')->first();
        $kepsek = User::where('username', 'kepsek.smp')->first();
        $waka = User::where('username', 'waka.smp')->first();
        $yayasan = User::where('username', 'yayasan')->first();
        $admin = User::where('username', 'admin.smp')->first();

        // Buat akun pembina ekstrakurikuler jika belum ada di database seeder
        $peranPembina = \App\Models\Peran::where('nama_peran', 'Pembina Ekstrakurikuler SMP')->first();
        $pembina = User::firstOrCreate([
            'username' => 'pembina.smp',
        ], [
            'peran_id' => $peranPembina->id,
            'unit_id' => $kepsek->unit_id,
            'name' => 'Ustadz Zaid Pembina, S.Pd.',
            'email' => 'pembina.smp@alimasykur.sch.id',
            'password' => bcrypt('password'),
            'status_aktif' => true,
        ]);

        // 1. Verifikasi Transparansi & Menu Guru
        $guruDash = $this->actingAs($guru)->get(route('dashboard'));
        $guruDash->assertStatus(200);
        $guruDash->assertSee('Dashboard Guru');
        $guruDash->assertSee('Mata Pelajaran Saya');
        $guruDash->assertSee('Usulan Saya');
        $guruDash->assertSee('Jurnal KBM & Tahfidz');
        $guruDash->assertSee('Portofolio Modul Ajar');
        $guruDash->assertDontSee('Monitoring 3 Unit');
        $guruDash->assertDontSee('Dewan Guru & Beban Jam');

        $guruJurnal = $this->actingAs($guru)->get(route('jurnal.index'));
        $guruJurnal->assertStatus(200);
        $guruJurnal->assertSee('Jurnal Mengajar Harian');
        $guruJurnal->assertSee('Buku Tahfidz Santri');

        // 2. Verifikasi Transparansi & Menu Pembina Ekstra
        $pembinaDash = $this->actingAs($pembina)->get(route('dashboard'));
        $pembinaDash->assertStatus(200);
        $pembinaDash->assertSee('Dashboard Pembina');
        $pembinaDash->assertSee('Kegiatan Ekstrakurikuler');
        $pembinaDash->assertSee('Agenda Pembinaan');
        $pembinaDash->assertSee('Arsip Kegiatan Ekstra');
        $pembinaDash->assertDontSee('Mata Pelajaran Saya');
        $pembinaDash->assertDontSee('Kurikulum & Silabus');
        $pembinaDash->assertDontSee('Riwayat Usulan');
        $pembinaDash->assertDontSee('Monitoring 3 Unit');

        // 3. Verifikasi Transparansi & Menu Waka Kurikulum
        $wakaDash = $this->actingAs($waka)->get(route('dashboard'));
        $wakaDash->assertStatus(200);
        $wakaDash->assertSee('Dashboard Waka');
        $wakaDash->assertSee('Kurikulum & ATP Unit');
        $wakaDash->assertSee('Telaah Usulan Guru');
        $wakaDash->assertSee('Supervisi KBM & Tahfidz');
        $wakaDash->assertSee('Verifikasi Arsip Ajar');
        $wakaDash->assertSee('Dewan Guru & Beban Jam');
        $wakaDash->assertDontSee('Monitoring 3 Unit');

        $wakaJurnal = $this->actingAs($waka)->get(route('jurnal.index'));
        $wakaJurnal->assertStatus(200);
        $wakaJurnal->assertSee('Monitoring Pelaksanaan KBM & Kepatuhan Jurnal Guru');
        $wakaJurnal->assertSee('Halaman Tindak Lanjut & Supervisi KBM Pimpinan');

        // 4. Verifikasi Transparansi & Menu Kepala Sekolah
        $kepsekDash = $this->actingAs($kepsek)->get(route('dashboard'));
        $kepsekDash->assertStatus(200);
        $kepsekDash->assertSee('Dashboard Pimpinan');
        $kepsekDash->assertSee('Otorisasi Silabus Unit');
        $kepsekDash->assertSee('Persetujuan Usulan');
        $kepsekDash->assertSee('Supervisi KBM & Hafalan');
        $kepsekDash->assertSee('Pengesahan Arsip KOSP');
        $kepsekDash->assertSee('Dewan Guru & SK Jam');
        $kepsekDash->assertDontSee('Monitoring 3 Unit');

        // 5. Verifikasi Transparansi & Menu Pengurus Yayasan
        $yayasanDash = $this->actingAs($yayasan)->get(route('dashboard'));
        $yayasanDash->assertStatus(200);
        $yayasanDash->assertSee('Dashboard Yayasan');
        $yayasanDash->assertSee('Monitoring 3 Unit');
        $yayasanDash->assertSee('Kurikulum 3 Unit');
        $yayasanDash->assertSee('Monitoring KBM & Tahfidz');
        $yayasanDash->assertSee('Arsip Induk Yayasan');
        $yayasanDash->assertSee('Audit SDM & Pendidik');
        $yayasanDash->assertDontSee('Usulan Saya');

        $yayasanJurnal = $this->actingAs($yayasan)->get(route('jurnal.index'));
        $yayasanJurnal->assertStatus(200);
        $yayasanJurnal->assertSee('Monitoring Pelaksanaan KBM Terpadu 3 Unit');
        $yayasanJurnal->assertSee('Statistik Komparatif KBM 3 Unit (Yayasan)');
    }

    public function test_pembina_ekstrakurikuler_workspace_and_student_attendance_flow(): void
    {
        $pembina = User::where('username', 'pembina.smp')->first();
        if (!$pembina) {
            $peranPembina = \App\Models\Peran::firstOrCreate(['nama_peran' => 'Pembina Ekstrakurikuler SMP']);
            $unitSMP = \App\Models\UnitPendidikan::first();
            $pembina = User::create([
                'name' => 'Ustadz Zaid Pembina, S.Pd.',
                'username' => 'pembina.smp',
                'email' => 'pembina.smp.test@alimasykur.sch.id',
                'peran_id' => $peranPembina->id,
                'unit_id' => $unitSMP->id,
                'password' => bcrypt('password'),
                'status_aktif' => true,
            ]);
        }

        $ekskul = \App\Models\KegiatanEkstrakurikuler::where('unit_id', $pembina->unit_id)->first();
        $this->assertNotNull($ekskul);

        // 1. Render Halaman Workspace Pembina
        $response = $this->actingAs($pembina)->get(route('pembina.index', ['ekskul_id' => $ekskul->id]));
        $response->assertStatus(200);
        $response->assertSee('Workspace Pembina');
        $response->assertSee('Daftar Siswa');
        $response->assertSee('Jadwal Latihan');
        $response->assertSee($ekskul->nama_kegiatan);

        // 2. Tambah Anggota Santri Baru
        $tambahAnggota = $this->actingAs($pembina)->post(route('pembina.anggota.store'), [
            'ekstrakurikuler_id' => $ekskul->id,
            'nama_siswa' => 'Santri Binaan Baru Test',
            'nis' => '99887766',
            'kelas' => '8B',
            'jenis_kelamin' => 'L',
            'nilai_kualitatif' => 'A',
            'catatan_bakat' => 'Fisik prima dan sangat antusias berlatih',
        ]);
        $tambahAnggota->assertRedirect();
        $this->assertDatabaseHas('ekstrakurikuler_anggota', [
            'ekstrakurikuler_id' => $ekskul->id,
            'nama_siswa' => 'Santri Binaan Baru Test',
            'kelas' => '8B',
        ]);

        $anggota = \App\Models\EkstrakurikulerAnggota::where('nama_siswa', 'Santri Binaan Baru Test')->first();

        // 3. Tambah Jadwal Latihan Baru
        $tambahJadwal = $this->actingAs($pembina)->post(route('pembina.jadwal.store'), [
            'ekstrakurikuler_id' => $ekskul->id,
            'pertemuan_ke' => 12,
            'tanggal' => now()->addDays(2)->format('Y-m-d'),
            'jam_mulai' => '15:30',
            'jam_selesai' => '17:00',
            'tempat' => 'Lapangan Utama Ponpes',
            'materi_pembinaan' => 'Simulasi Tanding Antar Ranting Ponpes',
            'catatan_evaluasi' => 'Peralatan body protector lengkap',
            'status' => 'Dijadwalkan',
        ]);
        $tambahJadwal->assertRedirect();
        $this->assertDatabaseHas('ekstrakurikuler_jadwal', [
            'ekstrakurikuler_id' => $ekskul->id,
            'pertemuan_ke' => 12,
            'materi_pembinaan' => 'Simulasi Tanding Antar Ranting Ponpes',
        ]);

        $jadwal = \App\Models\EkstrakurikulerJadwal::where('ekstrakurikuler_id', $ekskul->id)
            ->where('pertemuan_ke', 12)
            ->first();

        // 4. Catat Presensi Santri per Sesi
        $simpanPresensi = $this->actingAs($pembina)->post(route('pembina.jadwal.presensi', $jadwal->id), [
            'presensi' => [
                $anggota->id => 'Hadir',
            ],
        ]);
        $simpanPresensi->assertRedirect();
        $this->assertDatabaseHas('ekstrakurikuler_presensi', [
            'jadwal_id' => $jadwal->id,
            'anggota_id' => $anggota->id,
            'status_kehadiran' => 'Hadir',
        ]);

        // 5. Update Anggota Santri
        $updateAnggota = $this->actingAs($pembina)->post(route('pembina.anggota.update', $anggota->id), [
            'nama_siswa' => 'Santri Binaan Baru Test (Updated)',
            'kelas' => '8B Unggulan',
            'nis' => '99887766',
            'status_keaktifan' => 'Aktif',
            'nilai_kualitatif' => 'A',
            'catatan_bakat' => 'Peraih Juara 1 Internal',
        ]);
        $updateAnggota->assertRedirect();
        $this->assertDatabaseHas('ekstrakurikuler_anggota', [
            'id' => $anggota->id,
            'nama_siswa' => 'Santri Binaan Baru Test (Updated)',
            'kelas' => '8B Unggulan',
        ]);
    }
}

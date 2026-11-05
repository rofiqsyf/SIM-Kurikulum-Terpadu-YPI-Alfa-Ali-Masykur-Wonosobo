<?php

namespace App\Http\Controllers;

use App\Models\ArsipDokumen;
use App\Models\UnitPendidikan;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArsipController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Auto-seed initial realistic inspection archive documents if empty
        if (ArsipDokumen::count() === 0) {
            $this->seedInitialInspectionDocuments();
        }

        // Scope units according to user role
        if ($user->canAccessAllUnits()) {
            $units = UnitPendidikan::all();
            $selectedUnitId = $request->get('unit_id', 'all');
        } else {
            $units = UnitPendidikan::where('id', $user->unit_id)->get();
            $selectedUnitId = $user->unit_id; // Forced strictly
        }

        $selectedTahun = $request->get('tahun', '2024/2025');
        $selectedKategori = $request->get('kategori', 'all');

        $query = ArsipDokumen::with(['unit', 'uploader']);

        if ($selectedUnitId !== 'all') {
            $query->where('unit_id', $selectedUnitId);
        }

        if ($selectedTahun !== 'all') {
            $query->where('tahun_ajaran', $selectedTahun);
        }

        if ($selectedKategori !== 'all') {
            $query->where('kategori', $selectedKategori);
        }

        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('judul_dokumen', 'like', "%{$search}%")
                  ->orWhere('kode_dokumen', 'like', "%{$search}%")
                  ->orWhere('nama_pengawas', 'like', "%{$search}%")
                  ->orWhere('catatan_supervisi', 'like', "%{$search}%");
            });
        }

        $documents = $query->latest('tanggal_arsip')->get();

        // Metrics for inspection readiness
        $baseQuery = ArsipDokumen::when($selectedUnitId !== 'all', fn($q) => $q->where('unit_id', $selectedUnitId))
                                ->when($selectedTahun !== 'all', fn($q) => $q->where('tahun_ajaran', $selectedTahun));

        $totalDokumen = (clone $baseQuery)->count();
        $totalTerverifikasi = (clone $baseQuery)->where('status_verifikasi', 'Terverifikasi')->count();
        $totalPerluRevisi = (clone $baseQuery)->where('status_verifikasi', 'Perlu Dilengkapi')->count();
        $totalDraft = (clone $baseQuery)->where('status_verifikasi', 'Menunggu Supervisi')->count();

        $persentaseKesiapan = $totalDokumen > 0 ? round(($totalTerverifikasi / $totalDokumen) * 100) : 0;

        $availableYears = ArsipDokumen::select('tahun_ajaran')->distinct()->pluck('tahun_ajaran')->toArray();
        if (!in_array('2024/2025', $availableYears)) {
            $availableYears[] = '2024/2025';
        }
        if (!in_array('2023/2024', $availableYears)) {
            $availableYears[] = '2023/2024';
        }
        rsort($availableYears);

        return view('arsip.index', compact(
            'user',
            'units',
            'selectedUnitId',
            'selectedTahun',
            'selectedKategori',
            'documents',
            'totalDokumen',
            'totalTerverifikasi',
            'totalPerluRevisi',
            'totalDraft',
            'persentaseKesiapan',
            'availableYears'
        ));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'unit_id' => 'required|exists:unit_pendidikan,id',
            'judul_dokumen' => 'required|string|max:200',
            'kategori' => 'required|string|in:kosp,atp,modul_ajar,p5_ra,sk_pengesahan,instrumen_asesmen',
            'tahun_ajaran' => 'required|string|max:20',
            'semester' => 'required|string|in:Ganjil,Genap,Tahunan',
            'tingkat_fase' => 'nullable|string|max:50',
            'status_verifikasi' => 'required|string|in:Terverifikasi,Perlu Dilengkapi,Menunggu Supervisi',
            'nama_pengawas' => 'nullable|string|max:150',
            'catatan_supervisi' => 'nullable|string',
            'file_size' => 'nullable|string|max:50',
            'tanggal_arsip' => 'required|date',
        ]);

        // Generate unique document code
        if (!$user->canAccessAllUnits() && $user->unit_id) {
            $validated['unit_id'] = $user->unit_id;
        }

        $prefix = 'DOK-' . strtoupper(substr($validated['kategori'], 0, 3));
        $count = ArsipDokumen::where('kode_dokumen', 'like', "{$prefix}-%")->count() + 1;
        do {
            $kode = sprintf('%s-%s-%03d', $prefix, str_replace('/', '', $validated['tahun_ajaran']), $count);
            $count++;
        } while (ArsipDokumen::where('kode_dokumen', $kode)->exists());

        $doc = ArsipDokumen::create(array_merge($validated, [
            'kode_dokumen' => $kode,
            'user_id' => $user->id,
            'file_size' => $validated['file_size'] ?: '2.8 MB PDF',
        ]));

        NotificationService::notifyKepsekAndYayasan(
            $validated['unit_id'],
            "Dokumen Diarsipkan: {$kode}",
            "{$user->name} mengarsipkan dokumen '{$validated['judul_dokumen']}' untuk persiapan pengawasan tahunan.",
            'info',
            route('arsip.index', ['unit_id' => $validated['unit_id']])
        );

        return back()->with('success', "Dokumen resmi {$kode} berhasil diarsipkan ke bank data pengawasan.");
    }

    public function updateStatus(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->isKepalaSekolah() && !$user->isWakaKurikulum() && !$user->isAdmin() && !$user->isYayasan()) {
            return back()->with('error', 'Hanya Waka Kurikulum, Kepala Sekolah, atau Pengawas yang berhak memperbarui status supervisi.');
        }

        $validated = $request->validate([
            'status_verifikasi' => 'required|string|in:Terverifikasi,Perlu Dilengkapi,Menunggu Supervisi',
            'nama_pengawas' => 'nullable|string|max:150',
            'catatan_supervisi' => 'nullable|string',
        ]);

        $doc = ArsipDokumen::findOrFail($id);
        if (!$user->canManageUnit($doc->unit_id)) {
            return back()->with('error', 'Akses Dibatasi: Anda hanya berhak memverifikasi status dokumen pada unit sekolah Anda sendiri.');
        }
        $doc->update($validated);

        return back()->with('success', "Status supervisi dokumen {$doc->kode_dokumen} berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isWakaKurikulum() && !$user->isKepalaSekolah()) {
            return back()->with('error', 'Anda tidak memiliki hak akses untuk menghapus arsip dokumen resmi.');
        }

        $doc = ArsipDokumen::findOrFail($id);
        if (!$user->canManageUnit($doc->unit_id)) {
            return back()->with('error', 'Akses Dibatasi: Anda hanya berhak menghapus arsip dokumen pada unit sekolah Anda sendiri.');
        }
        $kode = $doc->kode_dokumen;
        $doc->delete();

        return back()->with('success', "Arsip dokumen {$kode} berhasil dihapus dari sistem.");
    }

    protected function seedInitialInspectionDocuments(): void
    {
        $unitSMP = UnitPendidikan::where('kode_unit', 'SMP-ALFA')->first() ?? UnitPendidikan::first();
        $unitMI = UnitPendidikan::where('kode_unit', 'MI-ALFA')->first() ?? $unitSMP;
        $unitSMA = UnitPendidikan::where('kode_unit', 'SMA-ALFA')->first() ?? $unitSMP;
        $admin = User::where('username', 'admin')->first() ?? User::first();

        $docs = [
            // SMP Alfa
            [
                'unit_id' => $unitSMP->id,
                'user_id' => $admin?->id,
                'kode_dokumen' => 'DOK-KOSP-SMP-2401',
                'judul_dokumen' => 'Kurikulum Operasional Satuan Pendidikan (KOSP) SMP Alfa Ali Masykur 2024/2025',
                'kategori' => 'kosp',
                'tahun_ajaran' => '2024/2025',
                'semester' => 'Tahunan',
                'tingkat_fase' => 'Fase D (Kelas 7, 8, 9)',
                'status_verifikasi' => 'Terverifikasi',
                'nama_pengawas' => 'Drs. H. Suwandi, M.Pd. (Pengawas Disdikbud Wonosobo)',
                'catatan_supervisi' => 'Dokumen KOSP telah selaras dengan visi pesantren dan memenuhi 5 prinsip Kurikulum Merdeka.',
                'file_size' => '4.2 MB PDF',
                'tanggal_arsip' => '2024-07-15',
            ],
            [
                'unit_id' => $unitSMP->id,
                'user_id' => $admin?->id,
                'kode_dokumen' => 'DOK-ATP-SMP-2402',
                'judul_dokumen' => 'Matriks Alur Tujuan Pembelajaran (ATP) Matematika & Rumpun MIPA Fase D',
                'kategori' => 'atp',
                'tahun_ajaran' => '2024/2025',
                'semester' => 'Ganjil',
                'tingkat_fase' => 'Fase D (Kelas 7 & 8)',
                'status_verifikasi' => 'Terverifikasi',
                'nama_pengawas' => 'Drs. H. Suwandi, M.Pd.',
                'catatan_supervisi' => 'Urutan TP logis, alokasi beban JP terpenuhi, serta terintegrasi Taksonomi Bloom C1-C6.',
                'file_size' => '2.1 MB PDF',
                'tanggal_arsip' => '2024-07-20',
            ],
            [
                'unit_id' => $unitSMP->id,
                'user_id' => $admin?->id,
                'kode_dokumen' => 'DOK-MOD-SMP-2403',
                'judul_dokumen' => 'Bundel Modul Ajar Berdiferensiasi Matematika Aljabar Terpadu Kelas 7',
                'kategori' => 'modul_ajar',
                'tahun_ajaran' => '2024/2025',
                'semester' => 'Ganjil',
                'tingkat_fase' => 'Kelas 7 SMP',
                'status_verifikasi' => 'Terverifikasi',
                'nama_pengawas' => 'Drs. H. Suwandi, M.Pd.',
                'catatan_supervisi' => 'Lengkap dengan rubrik asesmen formatif dan LKPD berbasis kontekstual santri.',
                'file_size' => '3.5 MB PDF',
                'tanggal_arsip' => '2024-08-05',
            ],
            [
                'unit_id' => $unitSMP->id,
                'user_id' => $admin?->id,
                'kode_dokumen' => 'DOK-P5-SMP-2404',
                'judul_dokumen' => 'Modul Projek Penguatan Profil Pelajar Pancasila & RA: Kewirausahaan Santri Berkah',
                'kategori' => 'p5_ra',
                'tahun_ajaran' => '2024/2025',
                'semester' => 'Ganjil',
                'tingkat_fase' => 'Fase D',
                'status_verifikasi' => 'Terverifikasi',
                'nama_pengawas' => 'Drs. H. Suwandi, M.Pd.',
                'catatan_supervisi' => 'Tema selaras dengan kemandirian pondok dan dimensi Bergotong Royong & Bernalar Kritis.',
                'file_size' => '2.9 MB PDF',
                'tanggal_arsip' => '2024-08-12',
            ],
            [
                'unit_id' => $unitSMP->id,
                'user_id' => $admin?->id,
                'kode_dokumen' => 'DOK-SK-SMP-2405',
                'judul_dokumen' => 'SK Kepala Sekolah tentang Pembagian Tugas Mengajar & Beban JP Guru 2024/2025',
                'kategori' => 'sk_pengesahan',
                'tahun_ajaran' => '2024/2025',
                'semester' => 'Tahunan',
                'tingkat_fase' => 'Semua Tingkat',
                'status_verifikasi' => 'Terverifikasi',
                'nama_pengawas' => 'Drs. H. Suwandi, M.Pd.',
                'catatan_supervisi' => 'Distribusi jam memenuhi standar minimal 24 JP per guru tetap yayasan.',
                'file_size' => '1.8 MB PDF',
                'tanggal_arsip' => '2024-07-10',
            ],

            // MI Tahfidz Alfa
            [
                'unit_id' => $unitMI->id,
                'user_id' => $admin?->id,
                'kode_dokumen' => 'DOK-KOM-MI-2401',
                'judul_dokumen' => 'Kurikulum Operasional Madrasah (KOM) & Kurikulum Berbasis Cinta (KBC) MI Tahfidz Alfa',
                'kategori' => 'kosp',
                'tahun_ajaran' => '2024/2025',
                'semester' => 'Tahunan',
                'tingkat_fase' => 'Fase A, B, C',
                'status_verifikasi' => 'Terverifikasi',
                'nama_pengawas' => 'Hj. Siti Romlah, M.Ag. (Pengawas Kemenag Kab. Wonosobo)',
                'catatan_supervisi' => 'Harmonisasi Kurikulum Merdeka Kemenag dengan target hafalan Juz 30 telah tervalidasi.',
                'file_size' => '3.8 MB PDF',
                'tanggal_arsip' => '2024-07-18',
            ],
            [
                'unit_id' => $unitMI->id,
                'user_id' => $admin?->id,
                'kode_dokumen' => 'DOK-ATP-MI-2402',
                'judul_dokumen' => 'Alur Tujuan Pembelajaran (ATP) Program Khusus Tahfidz & Bahasa Arab Madrasah',
                'kategori' => 'atp',
                'tahun_ajaran' => '2024/2025',
                'semester' => 'Ganjil',
                'tingkat_fase' => 'Fase B (Kelas 3 & 4)',
                'status_verifikasi' => 'Terverifikasi',
                'nama_pengawas' => 'Hj. Siti Romlah, M.Ag.',
                'catatan_supervisi' => 'Target hafalan bertahap metode tasmi lancar.',
                'file_size' => '2.3 MB PDF',
                'tanggal_arsip' => '2024-07-25',
            ],
            [
                'unit_id' => $unitMI->id,
                'user_id' => $admin?->id,
                'kode_dokumen' => 'DOK-MOD-MI-2403',
                'judul_dokumen' => 'Perangkat Modul Ajar IPAS & Muatan Lokal Budaya Pesantren Kelas 4 MI',
                'kategori' => 'modul_ajar',
                'tahun_ajaran' => '2024/2025',
                'semester' => 'Ganjil',
                'tingkat_fase' => 'Kelas 4 MI',
                'status_verifikasi' => 'Perlu Dilengkapi',
                'nama_pengawas' => 'Hj. Siti Romlah, M.Ag.',
                'catatan_supervisi' => 'Mohon lengkapi rubrik penilaian sikap santri pada lembar observasi pertemuan 3.',
                'file_size' => '2.6 MB PDF',
                'tanggal_arsip' => '2024-08-20',
            ],

            // SMA Alfa Ali Masykur
            [
                'unit_id' => $unitSMA->id,
                'user_id' => $admin?->id,
                'kode_dokumen' => 'DOK-KOSP-SMA-2401',
                'judul_dokumen' => 'Kurikulum Operasional Satuan Pendidikan (KOSP) SMA Alfa Paket Peminatan & Pondok',
                'kategori' => 'kosp',
                'tahun_ajaran' => '2024/2025',
                'semester' => 'Tahunan',
                'tingkat_fase' => 'Fase E & F',
                'status_verifikasi' => 'Terverifikasi',
                'nama_pengawas' => 'Drs. H. Mulyono, M.Pd. (Cabang Dinas Pendidikan Wilayah IX)',
                'catatan_supervisi' => 'Struktur peminatan IPA/IPS bersinergi dengan kitab kuning dan risalah ushul.',
                'file_size' => '4.5 MB PDF',
                'tanggal_arsip' => '2024-07-16',
            ],
            [
                'unit_id' => $unitSMA->id,
                'user_id' => $admin?->id,
                'kode_dokumen' => 'DOK-ATP-SMA-2402',
                'judul_dokumen' => 'Dokumen ATP & Capaian Pembelajaran Rumpun Peminatan Saintek Fase F',
                'kategori' => 'atp',
                'tahun_ajaran' => '2024/2025',
                'semester' => 'Ganjil',
                'tingkat_fase' => 'Fase F (Kelas 11)',
                'status_verifikasi' => 'Terverifikasi',
                'nama_pengawas' => 'Drs. H. Mulyono, M.Pd.',
                'catatan_supervisi' => 'Cakupan materi kalkulus dan fisika modern telah memenuhi standar kelayakan akreditasi.',
                'file_size' => '2.7 MB PDF',
                'tanggal_arsip' => '2024-08-01',
            ],
            [
                'unit_id' => $unitSMA->id,
                'user_id' => $admin?->id,
                'kode_dokumen' => 'DOK-P5-SMA-2403',
                'judul_dokumen' => 'Modul P5-RA SMA Alfa: Rekayasa Teknologi Ramah Lingkungan Santri Mandiri Energi',
                'kategori' => 'p5_ra',
                'tahun_ajaran' => '2024/2025',
                'semester' => 'Ganjil',
                'tingkat_fase' => 'Fase E & F',
                'status_verifikasi' => 'Terverifikasi',
                'nama_pengawas' => 'Drs. H. Mulyono, M.Pd.',
                'catatan_supervisi' => 'Projek aplikatif pembuatan biogas dan solar panel mini di lingkungan asrama.',
                'file_size' => '3.1 MB PDF',
                'tanggal_arsip' => '2024-08-18',
            ],
        ];

        foreach ($docs as $d) {
            ArsipDokumen::create($d);
        }
    }
}


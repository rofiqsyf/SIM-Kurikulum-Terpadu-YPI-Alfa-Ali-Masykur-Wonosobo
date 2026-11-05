<?php

namespace App\Http\Controllers;

use App\Models\CapaianPembelajaran;
use App\Models\Fase;
use App\Models\MataPelajaran;
use App\Models\Materi;
use App\Models\TujuanPembelajaran;
use App\Models\UnitPendidikan;
use App\Models\UsulanPerubahan;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CurriculumController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // View mode: 'katalog' (grid of shape cards) or 'workspace' (CP -> TP -> Materi tree)
        $viewMode = $request->get('view', $request->has('mapel_id') ? 'workspace' : 'katalog');

        // Scope unit: Admin & Yayasan can switch units or view all. Others are strictly locked to their own unit.
        if ($user->canAccessAllUnits()) {
            $unitId = $request->get('unit_id', 2); // Default SMP Alfa
            $currentUnit = UnitPendidikan::find($unitId) ?? UnitPendidikan::first();
        } else {
            $currentUnit = $user->unit ?? UnitPendidikan::first();
        }

        // Catalog of subjects: If user is scoped to their unit, only fetch their unit's subjects!
        $catalogQuery = MataPelajaran::with([
            'kurikulum.unit',
            'penugasanGuru.user',
            'kelas.fase',
            'tujuanPembelajaran',
        ])->withCount(['tujuanPembelajaran']);

        if (!$user->canAccessAllUnits()) {
            $catalogQuery->whereHas('kurikulum', fn($q) => $q->where('unit_id', $currentUnit->id));
        }

        $allCatalogMapel = $catalogQuery->get();

        // Daftar Mata Pelajaran pada unit ini
        $availableMapel = MataPelajaran::whereHas('kurikulum', function ($q) use ($currentUnit) {
            $q->where('unit_id', $currentUnit->id);
        })->get();

        // Selected Mapel with strict authorization check
        if ($request->has('mapel_id')) {
            $candidate = MataPelajaran::with(['kurikulum.unit', 'kelas.fase', 'penugasanGuru.user'])->find($request->get('mapel_id'));
            if ($candidate) {
                if (!$user->canAccessAllUnits() && $candidate->kurikulum?->unit_id !== $currentUnit->id) {
                    return redirect()->route('curriculum.index', ['view' => 'katalog'])
                        ->with('error', "Akses Dibatasi: Anda terdaftar pada unit {$currentUnit->nama_unit} dan tidak berwenang mengakses mata pelajaran di unit {$candidate->kurikulum?->unit?->nama_unit}.");
                }
                $selectedMapel = $candidate;
                if ($user->canAccessAllUnits()) {
                    $currentUnit = $candidate->kurikulum?->unit ?? $currentUnit;
                }
            } else {
                $selectedMapel = $availableMapel->first();
            }
        } else {
            $selectedMapel = $availableMapel->first();
        }

        // Search query auto-switch subject within permitted scope
        if ($search = $request->get('q')) {
            $searchQuery = MataPelajaran::where(function ($sq) use ($search) {
                $sq->where('nama_mapel', 'like', "%{$search}%")
                   ->orWhere('kode_mapel', 'like', "%{$search}%");
            });

            if (!$user->canAccessAllUnits()) {
                $searchQuery->whereHas('kurikulum', fn($q) => $q->where('unit_id', $currentUnit->id));
            }

            $matchedMapel = $searchQuery->first();
            if ($matchedMapel) {
                $selectedMapel = $matchedMapel;
                if ($user->canAccessAllUnits()) {
                    $currentUnit = $matchedMapel->kurikulum?->unit ?? $currentUnit;
                }
            }
        }

        // Fase list
        $faseList = Fase::all();
        $selectedFaseId = $request->get('fase_id', 4); // Default Fase D

        // Load CP dengan TP dan Materi
        $capaianList = CapaianPembelajaran::where('mapel_id', $selectedMapel?->id)
            ->with(['tujuanPembelajaran.materi', 'fase'])
            ->get();

        // Hitung metrik
        $totalCP = $capaianList->count();
        $totalTP = $capaianList->sum(fn($cp) => $cp->tujuanPembelajaran->count());
        $totalMateri = $capaianList->sum(fn($cp) => $cp->tujuanPembelajaran->sum(fn($tp) => $tp->materi->count()));
        $totalJP = $capaianList->sum('total_beban_jp');

        // Status usulan aktif yang diajukan guru untuk mapel ini
        $usulanMenunggu = UsulanPerubahan::where('mapel_id', $selectedMapel?->id)
            ->where('status', 'Menunggu Persetujuan')
            ->count();

        // Usulan terbaru untuk feedback verifikator (misal TP-7.4 yang ditolak)
        $latestRejectedProposal = UsulanPerubahan::where('mapel_id', $selectedMapel?->id)
            ->where('status', 'Ditolak')
            ->with('peninjau')
            ->latest('tanggal_keputusan')
            ->first();

        return view('curriculum.workspace', compact(
            'user',
            'viewMode',
            'allCatalogMapel',
            'currentUnit',
            'availableMapel',
            'selectedMapel',
            'faseList',
            'selectedFaseId',
            'capaianList',
            'totalCP',
            'totalTP',
            'totalMateri',
            'totalJP',
            'usulanMenunggu',
            'latestRejectedProposal'
        ));
    }

    public function storeProposal(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'jenis_usulan' => 'required|in:Tambah,Ubah,Hapus',
            'objek_data' => 'required|in:CP,TP,Materi',
            'data_id' => 'nullable|integer',
            'judul_usulan' => 'required|string|max:200',
            'alasan_pengajuan' => 'required|string|min:10',
            'deskripsi_usulan' => 'nullable|string',
            'beban_jp' => 'nullable|integer',
            'media_ajar' => 'nullable|string',
            'target_parent_id' => 'nullable|integer',
        ]);

        $mapel = MataPelajaran::with('kurikulum')->findOrFail($validated['mapel_id']);
        if (!$user->canAccessAllUnits() && $user->unit_id && $mapel->kurikulum?->unit_id !== $user->unit_id) {
            return back()->with('error', 'Akses Dibatasi: Anda hanya berhak mengajukan usulan kurikulum pada mata pelajaran di unit sekolah Anda.');
        }
        $unitId = $mapel->kurikulum->unit_id;

        // Generate Nomor Usulan unik (Menghindari tabrakan unik dengan nomor eksisting)
        $prefix = 'PROP-' . strtoupper(substr($mapel->kode_mapel ?? 'GEN', 0, 3));
        $count = UsulanPerubahan::where('nomor_usulan', 'like', "{$prefix}-%")->count() + 1;
        do {
            $nomorUsulan = sprintf('%s-%03d', $prefix, $count);
            $count++;
        } while (UsulanPerubahan::where('nomor_usulan', $nomorUsulan)->exists());

        $dataUsulan = [
            'isi_usulan' => $validated['deskripsi_usulan'] ?? $validated['judul_usulan'],
            'beban_jp' => $validated['beban_jp'] ?? null,
            'media_ajar' => $validated['media_ajar'] ?? null,
            'target_parent_id' => $validated['target_parent_id'] ?? null,
        ];

        if (!empty($validated['data_id'])) {
            if ($validated['objek_data'] === 'TP') {
                $tp = TujuanPembelajaran::find($validated['data_id']);
                if ($tp) {
                    $dataUsulan['data_semula'] = [
                        'kode_tp' => $tp->kode_tp,
                        'deskripsi_tp' => $tp->deskripsi_tp,
                        'beban_jp' => $tp->beban_jp,
                    ];
                }
            } elseif ($validated['objek_data'] === 'Materi') {
                $materi = Materi::find($validated['data_id']);
                if ($materi) {
                    $dataUsulan['data_semula'] = [
                        'judul_materi' => $materi->judul_materi,
                        'beban_jp' => $materi->beban_jp,
                        'media_ajar' => $materi->media_ajar,
                    ];
                }
            }
        }

        $filePath = null;
        $fileName = null;
        $fileType = null;
        $fileSize = null;

        if ($request->hasFile('dokumen')) {
            $request->validate([
                'dokumen' => 'file|mimes:pdf,docx,xlsx,doc,xls|max:20480',
            ], [
                'dokumen.mimes' => 'Format file usulan tidak didukung! Format yang diperbolehkan hanya PDF (.pdf), Word (.docx, .doc), dan Excel (.xlsx, .xls).',
                'dokumen.max' => 'Ukuran file usulan melebihi batas maksimal (Maksimal 20 MB).',
            ]);

            $file = $request->file('dokumen');
            $fileType = strtolower($file->getClientOriginalExtension());
            $fileName = $file->getClientOriginalName();
            $bytes = $file->getSize();
            $fileSize = $bytes >= 1048576 ? round($bytes / 1048576, 1) . ' MB' : round($bytes / 1024, 1) . ' KB';
            $filePath = $file->store('usulan_dokumen/' . ($mapel->kode_mapel ?? 'general'), 'public');
        }

        $usulan = UsulanPerubahan::create([
            'nomor_usulan' => $nomorUsulan,
            'pengusul_id' => $user->id,
            'unit_id' => $unitId,
            'mapel_id' => $mapel->id,
            'jenis_usulan' => $validated['jenis_usulan'],
            'objek_data' => $validated['objek_data'],
            'data_id' => $validated['data_id'] ?? null,
            'judul_usulan' => $validated['judul_usulan'],
            'data_usulan' => $dataUsulan,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_type' => $fileType,
            'file_size' => $fileSize,
            'alasan_pengajuan' => $validated['alasan_pengajuan'],
            'status' => 'Menunggu Persetujuan',
            'tanggal_pengajuan' => now(),
        ]);

        NotificationService::notifyKepsekAndYayasan(
            $unitId,
            "Usulan Baru: {$nomorUsulan}",
            "{$user->name} mengajukan usulan {$validated['jenis_usulan']} {$validated['objek_data']} pada mapel {$mapel->nama_mapel}.",
            'proposal_created',
            route('usulan.index'),
            ['nomor_usulan' => $nomorUsulan, 'usulan_id' => $usulan->id]
        );

        return redirect()->route('usulan.index')->with('success', "Usulan {$nomorUsulan} berhasil diajukan ke Waka Kurikulum & Kepala Sekolah untuk ditinjau.");
    }

    /**
     * Upload dokumen modul ajar langsung pada materi pembelajaran.
     */
    public function uploadMateriDocument(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $materi = Materi::with('tujuanPembelajaran.capaianPembelajaran.mataPelajaran.kurikulum')->findOrFail($id);
        $mapel = $materi->tujuanPembelajaran?->capaianPembelajaran?->mataPelajaran;
        $unitId = $mapel?->kurikulum?->unit_id;

        $isAssignedGuru = $mapel && $mapel->penugasanGuru()->where('user_id', $user->id)->exists();
        $canManage = $user->canAccessAllUnits() || $user->canManageUnit($unitId) || $isAssignedGuru;

        if (!$canManage) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses Dibatasi: Anda tidak berwenang mengunggah modul pada mata pelajaran unit ini.',
                ], 403);
            }
            return back()->with('error', 'Akses Dibatasi: Anda tidak berwenang mengunggah modul pada mata pelajaran unit ini.');
        }

        $validated = $request->validate([
            'dokumen' => [
                'required',
                'file',
                'mimes:pdf,docx,xlsx,doc,xls',
                'max:20480', // 20 MB
            ],
            'keterangan' => 'nullable|string|max:255',
        ], [
            'dokumen.required' => 'Silakan pilih berkas dokumen yang akan diunggah.',
            'dokumen.file' => 'Berkas yang diunggah harus berupa file yang valid.',
            'dokumen.mimes' => 'Format file tidak didukung! Format yang diperbolehkan hanya PDF (.pdf), Word (.docx, .doc), dan Excel (.xlsx, .xls).',
            'dokumen.max' => 'Ukuran file melebihi batas maksimal (Maksimal 20 MB).',
        ]);

        $file = $request->file('dokumen');
        $ext = strtolower($file->getClientOriginalExtension());
        $origName = $file->getClientOriginalName();
        $sizeBytes = $file->getSize();
        $sizeStr = $sizeBytes >= 1048576 
            ? round($sizeBytes / 1048576, 1) . ' MB' 
            : round($sizeBytes / 1024, 1) . ' KB';

        // Delete old file if exists
        if ($materi->file_path && Storage::disk('public')->exists($materi->file_path)) {
            Storage::disk('public')->delete($materi->file_path);
        }

        $folder = 'modul_materi/' . ($mapel?->kode_mapel ?? 'general');
        $storedPath = $file->store($folder, 'public');

        $materi->update([
            'file_path' => $storedPath,
            'file_name' => $origName,
            'file_type' => $ext,
            'file_size' => $sizeStr,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Berkas '{$origName}' ({$sizeStr}) berhasil diunggah sebagai dokumen modul materi.",
                'data' => [
                    'id' => $materi->id,
                    'file_name' => $origName,
                    'file_type' => $ext,
                    'file_size' => $sizeStr,
                    'badge' => $materi->document_badge,
                    'download_url' => route('curriculum.materi.download', $materi->id),
                ],
            ]);
        }

        return back()->with('success', "Berkas '{$origName}' ({$sizeStr}) berhasil diunggah ke modul materi.");
    }

    /**
     * Hapus berkas dokumen modul materi.
     */
    public function deleteMateriDocument(Request $request, $id)
    {
        $user = Auth::user();
        $materi = Materi::with('tujuanPembelajaran.capaianPembelajaran.mataPelajaran.kurikulum')->findOrFail($id);
        $mapel = $materi->tujuanPembelajaran?->capaianPembelajaran?->mataPelajaran;
        $unitId = $mapel?->kurikulum?->unit_id;

        $isAssignedGuru = $mapel && $mapel->penugasanGuru()->where('user_id', $user->id)->exists();
        $canManage = $user->canAccessAllUnits() || $user->canManageUnit($unitId) || $isAssignedGuru;

        if (!$canManage) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Akses Dibatasi.'], 403);
            }
            return back()->with('error', 'Akses Dibatasi.');
        }

        if ($materi->file_path && Storage::disk('public')->exists($materi->file_path)) {
            Storage::disk('public')->delete($materi->file_path);
        }

        $oldName = $materi->file_name;
        $materi->update([
            'file_path' => null,
            'file_name' => null,
            'file_type' => null,
            'file_size' => null,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Berkas lampiran '{$oldName}' berhasil dihapus dari modul materi.",
            ]);
        }

        return back()->with('success', "Berkas lampiran berhasil dihapus dari materi.");
    }

    /**
     * Unduh berkas dokumen modul materi dengan otorisasi unit.
     */
    public function downloadMateriDocument($id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $materi = Materi::with('tujuanPembelajaran.capaianPembelajaran.mataPelajaran.kurikulum')->findOrFail($id);
        $mapel = $materi->tujuanPembelajaran?->capaianPembelajaran?->mataPelajaran;
        $unitId = $mapel?->kurikulum?->unit_id;

        if (!$user->canAccessAllUnits() && $user->unit_id && $unitId && $user->unit_id !== $unitId) {
            return back()->with('error', 'Akses Dibatasi: Anda tidak berwenang mengunduh dokumen kurikulum di luar unit sekolah Anda.');
        }

        if (!$materi->file_path || !Storage::disk('public')->exists($materi->file_path)) {
            return back()->with('error', 'Berkas fisik dokumen modul materi tidak ditemukan pada media penyimpanan.');
        }

        return Storage::disk('public')->download($materi->file_path, $materi->file_name);
    }
}


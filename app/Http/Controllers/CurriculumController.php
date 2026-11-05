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

        // Unit aktif
        $unitId = $request->get('unit_id', $user->unit_id ?? 2); // Default SMP Alfa
        $currentUnit = UnitPendidikan::find($unitId) ?? UnitPendidikan::first();

        // All subjects across units with relationships for the catalog cards
        $allCatalogMapel = MataPelajaran::with([
            'kurikulum.unit',
            'penugasanGuru.user',
            'kelas.fase',
            'tujuanPembelajaran',
        ])->withCount(['tujuanPembelajaran'])->get();

        // Daftar Mata Pelajaran pada unit ini
        $availableMapel = MataPelajaran::whereHas('kurikulum', function ($q) use ($currentUnit) {
            $q->where('unit_id', $currentUnit->id);
        })->get();

        $selectedMapelId = $request->get('mapel_id', $availableMapel->first()?->id);
        $selectedMapel = MataPelajaran::with(['kurikulum', 'kelas.fase', 'penugasanGuru.user'])->find($selectedMapelId) ?? $availableMapel->first();

        // Search query auto-switch subject
        if ($search = $request->get('q')) {
            $matchedMapel = MataPelajaran::where('nama_mapel', 'like', "%{$search}%")
                ->orWhere('kode_mapel', 'like', "%{$search}%")
                ->first();
            if ($matchedMapel) {
                $selectedMapel = $matchedMapel;
                $currentUnit = $matchedMapel->kurikulum?->unit ?? $currentUnit;
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
}


<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\Materi;
use App\Models\TujuanPembelajaran;
use App\Models\UsulanPerubahan;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $query = UsulanPerubahan::with(['pengusul', 'peninjau', 'mataPelajaran', 'unit']);

        // Filter batasan hak akses multi-tenant unit
        if ($user->isGuru()) {
            $query->where('pengusul_id', $user->id);
        } elseif (!$user->canAccessAllUnits()) {
            // Waka Kurikulum & Kepala Sekolah hanya melihat usulan pada unit sekolahnya sendiri
            $query->where('unit_id', $user->unit_id);
        } elseif ($user->canAccessAllUnits() && $request->filled('unit_id') && $request->get('unit_id') !== 'all') {
            // Admin & Yayasan dapat menyaring berdasarkan unit tertentu
            $query->where('unit_id', $request->get('unit_id'));
        }

        // Metrics
        $totalPengajuan = (clone $query)->count();
        $menungguCount = (clone $query)->where('status', 'Menunggu Persetujuan')->count();
        $disetujuiCount = (clone $query)->where('status', 'Disetujui')->count();
        $ditolakCount = (clone $query)->where('status', 'Ditolak')->count();

        // Status filter
        $statusFilter = $request->get('status', 'all');
        if ($statusFilter && $statusFilter !== 'all') {
            if ($statusFilter === 'menunggu') {
                $query->where('status', 'Menunggu Persetujuan');
            } elseif ($statusFilter === 'disetujui') {
                $query->where('status', 'Disetujui');
            } elseif ($statusFilter === 'ditolak') {
                $query->where('status', 'Ditolak');
            }
        }

        // Search query
        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_usulan', 'like', "%{$search}%")
                  ->orWhere('judul_usulan', 'like', "%{$search}%")
                  ->orWhere('alasan_pengajuan', 'like', "%{$search}%");
            });
        }

        $proposals = $query->latest('tanggal_pengajuan')->get();

        // Mapel yang tersedia untuk pengajuan usulan baru
        if (!$user->canAccessAllUnits() && $user->unit_id) {
            $availableMapel = MataPelajaran::whereHas('kurikulum', fn($q) => $q->where('unit_id', $user->unit_id))->get();
        } else {
            $availableMapel = MataPelajaran::with('kurikulum.unit')->get();
        }

        return view('proposals.index', compact(
            'user',
            'proposals',
            'totalPengajuan',
            'menungguCount',
            'disetujuiCount',
            'ditolakCount',
            'statusFilter',
            'availableMapel'
        ));
    }

    public function show(UsulanPerubahan $usulan)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        if (!$user->canAccessAllUnits()) {
            if ($user->isGuru() && $usulan->pengusul_id !== $user->id) {
                return response()->json(['error' => 'Akses Dibatasi: Anda hanya berhak melihat usulan mandiri.'], 403);
            }
            if (($user->isKepalaSekolah() || $user->isWakaKurikulum()) && $usulan->unit_id !== $user->unit_id) {
                return response()->json(['error' => 'Akses Dibatasi: Usulan ini berada di luar unit wewenang Anda.'], 403);
            }
        }

        $usulan->load(['pengusul', 'peninjau', 'mataPelajaran', 'unit']);
        return response()->json($usulan);
    }

    public function review(Request $request, UsulanPerubahan $usulan)
    {
        $user = Auth::user();
        if (!$user || (!$user->isKepalaSekolah() && !$user->isWakaKurikulum() && !$user->isAdmin())) {
            return back()->with('error', 'Hanya Kepala Sekolah, Waka Kurikulum, atau Admin yang berhak meninjau usulan ini.');
        }

        if (!$user->canManageUnit($usulan->unit_id)) {
            return back()->with('error', 'Akses Dibatasi: Anda hanya berhak meninjau usulan kurikulum pada unit sekolah Anda sendiri.');
        }

        $validated = $request->validate([
            'keputusan' => 'required|in:setujui,tolak',
            'alasan_penolakan' => 'nullable|string',
        ]);

        if ($validated['keputusan'] === 'setujui') {
            $usulan->status = 'Disetujui';
            $usulan->alasan_penolakan = null;
            $usulan->peninjau_id = $user->id;
            $usulan->tanggal_keputusan = now();
            $usulan->save();

            // Terapkan perubahan ke kurikulum utama sesuai aturan bisnis di dokumen analisis
            $this->applyProposalToMaster($usulan);

            $roleTitle = $user->isWakaKurikulum() ? 'Waka Kurikulum' : ($user->isKepalaSekolah() ? 'Kepala Sekolah' : 'Pimpinan Unit');

            NotificationService::send(
                $usulan->pengusul_id,
                "Usulan Disetujui: {$usulan->nomor_usulan}",
                "{$roleTitle} ({$user->name}) telah menyetujui usulan '{$usulan->judul_usulan}'. Data telah aktif di kurikulum.",
                'proposal_approved',
                route('curriculum.index'),
                ['usulan_id' => $usulan->id, 'status' => 'Disetujui']
            );

            return back()->with('success', "Usulan {$usulan->nomor_usulan} berhasil DISETUJUI oleh {$roleTitle} dan diterapkan ke Kurikulum Utama.");
        } else {
            $request->validate([
                'alasan_penolakan' => 'required|string|min:5',
            ]);

            $usulan->status = 'Ditolak';
            $usulan->alasan_penolakan = $validated['alasan_penolakan'];
            $usulan->peninjau_id = $user->id;
            $usulan->tanggal_keputusan = now();
            $usulan->save();

            $roleTitle = $user->isWakaKurikulum() ? 'Waka Kurikulum' : ($user->isKepalaSekolah() ? 'Kepala Sekolah' : 'Pimpinan Unit');

            NotificationService::send(
                $usulan->pengusul_id,
                "Usulan Perlu Revisi: {$usulan->nomor_usulan}",
                "Catatan Telaah {$roleTitle} ({$user->name}): \"{$validated['alasan_penolakan']}\"",
                'proposal_rejected',
                route('curriculum.index'),
                ['usulan_id' => $usulan->id, 'status' => 'Ditolak']
            );

            return back()->with('info', "Usulan {$usulan->nomor_usulan} dikembalikan ke pengusul untuk direvisi sesuai catatan telaah.");
        }
    }

    protected function applyProposalToMaster(UsulanPerubahan $usulan): void
    {
        $data = $usulan->data_usulan;

        if ($usulan->objek_data === 'TP') {
            if ($usulan->jenis_usulan === 'Tambah') {
                $targetCpId = $data['target_parent_id'] ?? \App\Models\CapaianPembelajaran::where('mapel_id', $usulan->mapel_id)->first()?->id ?? 1;
                $count = TujuanPembelajaran::where('cp_id', $targetCpId)->count() + 1;
                TujuanPembelajaran::create([
                    'cp_id' => $targetCpId,
                    'kode_tp' => 'TP-7.' . $count,
                    'deskripsi_tp' => $data['isi_usulan'] ?? $usulan->judul_usulan,
                    'beban_jp' => $data['beban_jp'] ?? 8,
                    'periode' => 'Semester Ganjil',
                    'status_pengesahan' => 'Disetujui',
                ]);
            } elseif ($usulan->jenis_usulan === 'Ubah' && $usulan->data_id) {
                $tp = TujuanPembelajaran::find($usulan->data_id);
                if ($tp) {
                    if (isset($data['isi_usulan'])) {
                        $tp->deskripsi_tp = $data['isi_usulan'];
                    }
                    if (isset($data['beban_jp'])) {
                        $tp->beban_jp = $data['beban_jp'];
                    }
                    $tp->status_pengesahan = 'Disetujui';
                    $tp->save();
                }
            } elseif ($usulan->jenis_usulan === 'Hapus' && $usulan->data_id) {
                TujuanPembelajaran::destroy($usulan->data_id);
            }
        } elseif ($usulan->objek_data === 'Materi') {
            if ($usulan->jenis_usulan === 'Tambah') {
                $targetTpId = $data['target_parent_id'] ?? \App\Models\TujuanPembelajaran::whereHas('capaianPembelajaran', function($q) use ($usulan) {
                    $q->where('mapel_id', $usulan->mapel_id);
                })->first()?->id ?? 1;
                $count = Materi::where('tp_id', $targetTpId)->count() + 1;
                Materi::create([
                    'tp_id' => $targetTpId,
                    'kode_materi' => 'Materi ' . $targetTpId . '.' . $count,
                    'judul_materi' => $usulan->judul_usulan,
                    'isi_materi' => $data['isi_usulan'] ?? $usulan->judul_usulan,
                    'beban_jp' => $data['beban_jp'] ?? 4,
                    'media_ajar' => $data['media_ajar'] ?? 'Modul Ajar Santri',
                ]);
            } elseif ($usulan->jenis_usulan === 'Ubah' && $usulan->data_id) {
                $materi = Materi::find($usulan->data_id);
                if ($materi) {
                    $materi->judul_materi = $usulan->judul_usulan;
                    if (isset($data['isi_usulan'])) {
                        $materi->isi_materi = $data['isi_usulan'];
                    }
                    if (isset($data['beban_jp'])) {
                        $materi->beban_jp = $data['beban_jp'];
                    }
                    $materi->save();
                }
            } elseif ($usulan->jenis_usulan === 'Hapus' && $usulan->data_id) {
                Materi::destroy($usulan->data_id);
            }
        }
    }
}


<?php

namespace App\Http\Controllers;

use App\Models\CapaianPembelajaran;
use App\Models\JurnalKerja;
use App\Models\MataPelajaran;
use App\Models\TujuanPembelajaran;
use App\Models\UnitPendidikan;
use App\Models\UsulanPerubahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Statistik Usulan
        $queryUsulan = UsulanPerubahan::query();
        if ($user->isGuru()) {
            $queryUsulan->where('pengusul_id', $user->id);
        } elseif (($user->isKepalaSekolah() || $user->isWakaKurikulum()) && $user->unit_id) {
            $queryUsulan->where('unit_id', $user->unit_id);
        }

        $totalUsulan = (clone $queryUsulan)->count();
        $usulanMenunggu = (clone $queryUsulan)->where('status', 'Menunggu Persetujuan')->count();
        $usulanDisetujui = (clone $queryUsulan)->where('status', 'Disetujui')->count();
        $usulanDitolak = (clone $queryUsulan)->where('status', 'Ditolak')->count();

        $recentUsulan = (clone $queryUsulan)->with(['mataPelajaran', 'pengusul', 'peninjau'])
            ->latest('tanggal_pengajuan')
            ->take(5)
            ->get();

        // Data Akademik & Kurikulum
        $unit = $user->unit ?? UnitPendidikan::first();
        $mapelList = MataPelajaran::whereHas('kurikulum', function ($q) use ($unit) {
            if ($unit) {
                $q->where('unit_id', $unit->id);
            }
        })
        ->withCount('tujuanPembelajaran')
        ->with(['penugasanGuru.user'])
        ->get();

        $currentDateStr = now()->locale('id')->translatedFormat('d M Y, l');

        $totalCP = CapaianPembelajaran::whereHas('mataPelajaran.kurikulum', function ($q) use ($unit) {
            if ($unit) {
                $q->where('unit_id', $unit->id);
            }
        })->count();

        $totalTP = TujuanPembelajaran::whereHas('capaianPembelajaran.mataPelajaran.kurikulum', function ($q) use ($unit) {
            if ($unit) {
                $q->where('unit_id', $unit->id);
            }
        })->count();

        // Pending review list for Kepala Sekolah & Waka Kurikulum
        $pendingReviews = [];
        if (($user->isKepalaSekolah() || $user->isWakaKurikulum()) && $user->unit_id) {
            $pendingReviews = UsulanPerubahan::where('unit_id', $user->unit_id)
                ->where('status', 'Menunggu Persetujuan')
                ->with(['pengusul', 'mataPelajaran'])
                ->get();
        }

        // User Work Journal & Reminder Tasks (agar tidak kelupaan tugas mengajar/kerja)
        $userAgendaTasks = JurnalKerja::where('user_id', $user->id)
            ->where('status', '!=', 'selesai')
            ->orderBy('tanggal_target')
            ->take(4)
            ->get();

        // Unit Inspection & Teacher Stats (for Waka Kurikulum & Kepala Sekolah)
        $unitArsipQuery = \App\Models\ArsipDokumen::where('unit_id', $unit?->id);
        $totalArsipUnit = (clone $unitArsipQuery)->count();
        $terverifikasiArsipUnit = (clone $unitArsipQuery)->where('status_verifikasi', 'Terverifikasi')->count();
        $persentaseArsip = $totalArsipUnit > 0 ? round(($terverifikasiArsipUnit / $totalArsipUnit) * 100) : 0;

        $totalGuruUnit = \App\Models\User::where('unit_id', $unit?->id)
            ->whereHas('peran', fn($q) => $q->where('nama_peran', 'like', '%guru%'))
            ->count();

        return view('dashboard.index', compact(
            'user',
            'unit',
            'totalUsulan',
            'usulanMenunggu',
            'usulanDisetujui',
            'usulanDitolak',
            'recentUsulan',
            'mapelList',
            'totalCP',
            'totalTP',
            'pendingReviews',
            'currentDateStr',
            'userAgendaTasks',
            'totalArsipUnit',
            'terverifikasiArsipUnit',
            'persentaseArsip',
            'totalGuruUnit'
        ));
    }
}


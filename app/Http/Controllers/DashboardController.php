<?php

namespace App\Http\Controllers;

use App\Models\CapaianPembelajaran;
use App\Models\JurnalKerja;
use App\Models\MataPelajaran;
use App\Models\TujuanPembelajaran;
use App\Models\UnitPendidikan;
use App\Models\UsulanPerubahan;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Otomatis cek dan beri notifikasi jika ada agenda yang deadline hari ini atau lewat
        NotificationService::checkAndNotifyUserDeadlines($user->id);

        // Scope unit: Admin & Yayasan can switch units or view all. Others are strictly locked to their unit.
        $availableUnits = UnitPendidikan::all();
        if ($user->canAccessAllUnits()) {
            $selectedUnitId = $request->get('unit_id');
            $unit = $selectedUnitId ? UnitPendidikan::find($selectedUnitId) : null;
        } else {
            $unit = $user->unit ?? UnitPendidikan::first();
        }

        // Statistik Usulan
        $queryUsulan = UsulanPerubahan::query();
        if ($user->isGuru()) {
            $queryUsulan->where('pengusul_id', $user->id);
        } elseif (!$user->canAccessAllUnits() && $user->unit_id) {
            $queryUsulan->where('unit_id', $user->unit_id);
        } elseif ($user->canAccessAllUnits() && $unit) {
            $queryUsulan->where('unit_id', $unit->id);
        }

        $totalUsulan = (clone $queryUsulan)->count();
        $usulanMenunggu = (clone $queryUsulan)->where('status', 'Menunggu Persetujuan')->count();
        $usulanDisetujui = (clone $queryUsulan)->where('status', 'Disetujui')->count();
        $usulanDitolak = (clone $queryUsulan)->where('status', 'Ditolak')->count();

        $recentUsulan = (clone $queryUsulan)->with(['mataPelajaran', 'pengusul', 'peninjau', 'unit'])
            ->latest('tanggal_pengajuan')
            ->take(5)
            ->get();

        // Data Akademik & Kurikulum
        $mapelQuery = MataPelajaran::with(['penugasanGuru.user', 'kurikulum.unit'])
            ->withCount('tujuanPembelajaran');

        if ($unit) {
            $mapelQuery->whereHas('kurikulum', fn($q) => $q->where('unit_id', $unit->id));
        }

        $mapelList = $mapelQuery->get();

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

        // Pending review list for Kepala Sekolah & Waka Kurikulum (Unit-scoped) or Admin/Yayasan
        $pendingReviews = [];
        if (!$user->canAccessAllUnits() && ($user->isKepalaSekolah() || $user->isWakaKurikulum()) && $user->unit_id) {
            $pendingReviews = UsulanPerubahan::where('unit_id', $user->unit_id)
                ->where('status', 'Menunggu Persetujuan')
                ->with(['pengusul', 'mataPelajaran', 'unit'])
                ->get();
        } elseif ($user->canAccessAllUnits()) {
            $pendingQuery = UsulanPerubahan::where('status', 'Menunggu Persetujuan')
                ->with(['pengusul', 'mataPelajaran', 'unit']);
            if ($unit) {
                $pendingQuery->where('unit_id', $unit->id);
            }
            $pendingReviews = $pendingQuery->get();
        }

        // User Work Journal & Reminder Tasks (agar tidak kelupaan tugas mengajar/kerja)
        $userAgendaTasks = JurnalKerja::where('user_id', $user->id)
            ->where('status', '!=', 'selesai')
            ->orderBy('tanggal_target')
            ->take(4)
            ->get();

        // Seluruh agenda kalender pengguna untuk penanda warna & tanggal
        $allUserAgendas = JurnalKerja::where('user_id', $user->id)->get();

        $formattedUserAgendas = $allUserAgendas->map(function ($t) {
            return [
                'id' => $t->id,
                'judul' => $t->judul,
                'kategori' => $t->kategori,
                'kategori_label' => $t->kategori_badge['label'] ?? ucfirst($t->kategori),
                'start' => ($t->tanggal_mulai ?? $t->tanggal_target)?->toDateString(),
                'end' => ($t->tanggal_selesai ?? $t->tanggal_target)?->toDateString(),
                'warna' => $t->warna ?: '#2563eb',
                'catatan' => $t->catatan ?? $t->catatan_refleksi ?? '',
                'prioritas' => $t->prioritas,
                'status' => $t->status,
                'is_overdue' => $t->isOverdue(),
                'is_due_today' => $t->isDueToday(),
                'is_selesai' => $t->isSelesai(),
            ];
        })->values()->toArray();

        // Unit Inspection & Teacher Stats
        $unitArsipQuery = \App\Models\ArsipDokumen::query();
        if ($unit) {
            $unitArsipQuery->where('unit_id', $unit->id);
        }
        $totalArsipUnit = (clone $unitArsipQuery)->count();
        $terverifikasiArsipUnit = (clone $unitArsipQuery)->where('status_verifikasi', 'Terverifikasi')->count();
        $persentaseArsip = $totalArsipUnit > 0 ? round(($terverifikasiArsipUnit / $totalArsipUnit) * 100) : 0;

        $guruQuery = \App\Models\User::whereHas('peran', fn($q) => $q->where('nama_peran', 'like', '%guru%'));
        if ($unit) {
            $guruQuery->where('unit_id', $unit->id);
        }
        $totalGuruUnit = $guruQuery->count();

        return view('dashboard.index', compact(
            'user',
            'unit',
            'availableUnits',
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
            'totalGuruUnit',
            'allUserAgendas',
            'formattedUserAgendas'
        ));
    }
}


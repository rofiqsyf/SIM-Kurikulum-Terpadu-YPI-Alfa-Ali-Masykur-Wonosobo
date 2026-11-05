<?php

namespace App\Http\Controllers;

use App\Models\CapaianPembelajaran;
use App\Models\Kurikulum;
use App\Models\MataPelajaran;
use App\Models\TujuanPembelajaran;
use App\Models\UnitPendidikan;
use App\Models\UsulanPerubahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class YayasanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $units = UnitPendidikan::with(['jenjang', 'kurikulum.mataPelajaran'])->get();

        // Statistik komparatif antar-unit
        $unitStats = $units->map(function ($unit) {
            $mapelCount = MataPelajaran::whereHas('kurikulum', fn($q) => $q->where('unit_id', $unit->id))->count();
            $cpCount = CapaianPembelajaran::whereHas('mataPelajaran.kurikulum', fn($q) => $q->where('unit_id', $unit->id))->count();
            $tpCount = TujuanPembelajaran::whereHas('capaianPembelajaran.mataPelajaran.kurikulum', fn($q) => $q->where('unit_id', $unit->id))->count();
            $usulanCount = UsulanPerubahan::where('unit_id', $unit->id)->count();
            $usulanApproved = UsulanPerubahan::where('unit_id', $unit->id)->where('status', 'Disetujui')->count();

            return [
                'unit' => $unit,
                'mapel_count' => $mapelCount,
                'cp_count' => $cpCount,
                'tp_count' => $tpCount,
                'usulan_count' => $usulanCount,
                'usulan_approved' => $usulanApproved,
            ];
        });

        $allProposals = UsulanPerubahan::with(['unit', 'pengusul', 'peninjau', 'mataPelajaran'])
            ->latest('tanggal_pengajuan')
            ->take(10)
            ->get();

        return view('yayasan.monitoring', compact('user', 'unitStats', 'allProposals'));
    }
}


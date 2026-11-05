<?php

namespace App\Http\Controllers;

use App\Models\KegiatanEkstrakurikuler;
use App\Models\KegiatanKokurikuler;
use App\Models\UnitPendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->canAccessAllUnits()) {
            $units = UnitPendidikan::all();
            $selectedUnitId = $request->get('unit_id', $units->first()?->id);
        } else {
            $units = UnitPendidikan::where('id', $user->unit_id)->get();
            $selectedUnitId = $user->unit_id;
        }

        $kokurikuler = KegiatanKokurikuler::where('unit_id', $selectedUnitId)
            ->with(['pengelola', 'unit'])
            ->get();

        $ekstrakurikuler = KegiatanEkstrakurikuler::where('unit_id', $selectedUnitId)
            ->with(['pembina', 'unit'])
            ->get();

        return view('kegiatan.index', compact('user', 'units', 'selectedUnitId', 'kokurikuler', 'ekstrakurikuler'));
    }
}


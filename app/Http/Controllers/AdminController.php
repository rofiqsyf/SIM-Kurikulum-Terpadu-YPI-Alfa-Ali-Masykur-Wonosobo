<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\PenugasanGuru;
use App\Models\Peran;
use App\Models\UnitPendidikan;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        if (!$user->isAdmin() && !$user->isWakaKurikulum() && !$user->isKepalaSekolah() && !$user->isYayasan()) {
            return redirect()->route('dashboard')->with('error', 'Hanya Admin, Waka Kurikulum, dan Pimpinan yang berhak mengakses direktori pengguna.');
        }

        $query = User::with(['peran', 'unit', 'penugasan.mataPelajaran']);
        
        // Scope to unit for non-admin/yayasan (Waka Kurikulum & Kepala Sekolah)
        if (!$user->canAccessAllUnits() && $user->unit_id) {
            $query->where('unit_id', $user->unit_id);
        }

        $users = $query->orderBy('name')->get();
        $roles = Peran::orderBy('id')->get();
        $units = !$user->canAccessAllUnits() && $user->unit_id
            ? UnitPendidikan::where('id', $user->unit_id)->get()
            : UnitPendidikan::all();

        $mapelQuery = MataPelajaran::query();
        if (!$user->canAccessAllUnits() && $user->unit_id) {
            $mapelQuery->whereHas('kurikulum', fn($q) => $q->where('unit_id', $user->unit_id));
        }
        $mapelList = $mapelQuery->get();

        return view('admin.users', compact('user', 'users', 'roles', 'units', 'mapelList'));
    }

    public function storeUser(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            return back()->with('error', 'Hanya Administrator yang berhak mendaftarkan akun baru.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|max:100|unique:users,email',
            'nip' => 'nullable|string|max:50',
            'peran_id' => 'required|exists:peran,id',
            'unit_id' => 'nullable|exists:unit_pendidikan,id',
            'jabatan' => 'nullable|string|max:150',
            'password' => 'required|string|min:6',
        ]);

        // Auto-resolve unit_id if empty and a segmented role was selected
        if (empty($validated['unit_id'])) {
            $selectedRole = Peran::find($validated['peran_id']);
            if ($selectedRole) {
                $roleNameUpper = strtoupper($selectedRole->nama_peran);
                if (str_contains($roleNameUpper, 'MI')) {
                    $unitMI = UnitPendidikan::where('kode_unit', 'like', '%MI%')->first();
                    if ($unitMI) $validated['unit_id'] = $unitMI->id;
                } elseif (str_contains($roleNameUpper, 'SMP')) {
                    $unitSMP = UnitPendidikan::where('kode_unit', 'like', '%SMP%')->first();
                    if ($unitSMP) $validated['unit_id'] = $unitSMP->id;
                } elseif (str_contains($roleNameUpper, 'SMA')) {
                    $unitSMA = UnitPendidikan::where('kode_unit', 'like', '%SMA%')->first();
                    if ($unitSMA) $validated['unit_id'] = $unitSMA->id;
                }
            }
        }

        $validated['password'] = Hash::make($validated['password']);
        $validated['status_aktif'] = true;

        User::create($validated);

        return back()->with('success', 'Akun pengguna baru berhasil ditambahkan.');
    }

    public function updateUser(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            return back()->with('error', 'Hanya Administrator yang memiliki wewenang untuk mengubah data dan peran pengguna.');
        }

        $targetUser = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username,' . $targetUser->id,
            'email' => 'required|email|max:100|unique:users,email,' . $targetUser->id,
            'nip' => 'nullable|string|max:50',
            'peran_id' => 'required|exists:peran,id',
            'unit_id' => 'nullable|exists:unit_pendidikan,id',
            'jabatan' => 'nullable|string|max:150',
            'status_aktif' => 'required|boolean',
            'password' => 'nullable|string|min:6',
        ]);

        // Auto-resolve unit_id if empty and a segmented role was selected
        if (empty($validated['unit_id'])) {
            $selectedRole = Peran::find($validated['peran_id']);
            if ($selectedRole) {
                $roleNameUpper = strtoupper($selectedRole->nama_peran);
                if (str_contains($roleNameUpper, 'MI')) {
                    $unitMI = UnitPendidikan::where('kode_unit', 'like', '%MI%')->first();
                    if ($unitMI) $validated['unit_id'] = $unitMI->id;
                } elseif (str_contains($roleNameUpper, 'SMP')) {
                    $unitSMP = UnitPendidikan::where('kode_unit', 'like', '%SMP%')->first();
                    if ($unitSMP) $validated['unit_id'] = $unitSMP->id;
                } elseif (str_contains($roleNameUpper, 'SMA')) {
                    $unitSMA = UnitPendidikan::where('kode_unit', 'like', '%SMA%')->first();
                    if ($unitSMA) $validated['unit_id'] = $unitSMA->id;
                }
            }
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $targetUser->update($validated);

        return back()->with('success', "Data dan hak akses peran segment untuk {$targetUser->name} berhasil diperbarui.");
    }

    public function assignMapel(Request $request)
    {
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isWakaKurikulum() && !$user->isKepalaSekolah()) {
            return back()->with('error', 'Hanya Admin, Waka Kurikulum, atau Kepala Sekolah yang berhak mengatur pembagian tugas mengajar.');
        }

        $validated = $request->validate([
            'pengguna_id' => 'required|exists:users,id',
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'beban_jp' => 'required|integer|min:1',
            'jumlah_rombel' => 'required|integer|min:1',
        ]);

        $guruTarget = User::findOrFail($validated['pengguna_id']);
        if (!$user->canManageUnit($guruTarget->unit_id)) {
            return back()->with('error', 'Akses Dibatasi: Anda hanya dapat mengatur penugasan guru di unit pendidikan Anda sendiri.');
        }

        PenugasanGuru::updateOrCreate(
            ['pengguna_id' => $validated['pengguna_id'], 'mapel_id' => $validated['mapel_id']],
            ['beban_jp' => $validated['beban_jp'], 'jumlah_rombel' => $validated['jumlah_rombel']]
        );

        $roleTitle = $user->isWakaKurikulum() ? 'Waka Kurikulum' : ($user->isKepalaSekolah() ? 'Kepala Sekolah' : 'Admin Sistem');

        NotificationService::send(
            $validated['pengguna_id'],
            "Penugasan Beban Mengajar (SK)",
            "{$roleTitle} ({$user->name}) telah memperbarui beban mengajar Anda: {$validated['beban_jp']} JP ({$validated['jumlah_rombel']} Rombel).",
            'assignment_created',
            route('curriculum.index')
        );

        return back()->with('success', "Penugasan mata pelajaran untuk {$guruTarget->name} berhasil diperbarui.");
    }
}


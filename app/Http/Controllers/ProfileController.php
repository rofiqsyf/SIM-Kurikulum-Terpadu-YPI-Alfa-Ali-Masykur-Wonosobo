<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Show the profile edit page.
     */
    public function edit()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $user->load([
            'peran',
            'unit',
            'penugasan.mataPelajaran.kurikulum',
            'penugasan.mataPelajaran.kelas.fase',
        ]);

        $penugasan = $user->penugasan;
        $totalJP = $penugasan->sum('beban_jp');

        $metrics = [
            'agenda_kerja' => $user->jurnalKerja()->count(),
            'jurnal_kbm' => $user->jurnalMengajar()->count(),
            'usulan_tp' => $user->usulanDiajukan()->count(),
            'total_jp' => $totalJP,
        ];

        return view('profile.edit', compact('user', 'penugasan', 'metrics'));
    }

    /**
     * Update personal profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150|unique:users,email,' . $user->id,
            'nomor_telepon' => 'nullable|string|max:30',
            'nip' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:100',
            'alamat' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email ini telah digunakan oleh akun lain.',
            'avatar.image' => 'Berkas foto profil harus berupa gambar.',
            'avatar.mimes' => 'Format foto profil harus JPG, PNG, atau WebP.',
            'avatar.max' => 'Ukuran foto profil maksimal 4 MB.',
        ]);

        // Handle Avatar File Upload
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            // Delete old avatar if stored locally
            if ($user->avatar_url && Storage::disk('public')->exists($user->avatar_url)) {
                Storage::disk('public')->delete($user->avatar_url);
            }

            $extension = $file->getClientOriginalExtension();
            $filename = 'avatar_' . $user->id . '_' . time() . '.' . $extension;
            $path = $file->storeAs('avatars', $filename, 'public');
            $user->avatar_url = $path;
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->nomor_telepon = $validated['nomor_telepon'] ?? null;
        $user->nip = $validated['nip'] ?? $user->nip;
        $user->jabatan = $validated['jabatan'] ?? $user->jabatan;
        $user->alamat = $validated['alamat'] ?? null;
        $user->bio = $validated['bio'] ?? null;
        $user->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Data diri akun berhasil diperbarui.',
                'data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'nomor_telepon' => $user->nomor_telepon,
                    'nip' => $user->nip,
                    'jabatan' => $user->jabatan,
                    'avatar_url' => $user->avatar_image,
                ],
            ]);
        }

        return back()->with('success', 'Data diri akun Anda berhasil diperbarui.');
    }

    /**
     * Update account password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'current_password.current_password' => 'Kata sandi saat ini yang Anda masukkan salah.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal terdiri dari 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak sesuai.',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Kata sandi akun Anda berhasil diperbarui.',
            ]);
        }

        return back()->with('success', 'Kata sandi akun Anda berhasil diperbarui.');
    }

    /**
     * Delete user profile avatar.
     */
    public function deleteAvatar(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->avatar_url && Storage::disk('public')->exists($user->avatar_url)) {
            Storage::disk('public')->delete($user->avatar_url);
        }

        $user->avatar_url = null;
        $user->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil dihapus.',
            ]);
        }

        return back()->with('success', 'Foto profil berhasil dihapus.');
    }
}

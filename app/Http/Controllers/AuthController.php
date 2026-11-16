<?php

namespace App\Http\Controllers;

use App\Models\UnitPendidikan;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function showForgotPassword()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login', ['openForgotModal' => true]);
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'nip_or_username' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.required' => 'Email resmi wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'nip_or_username.required' => 'Username login atau NIP wajib diisi.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return back()->with('forgot_error', 'Email tidak ditemukan dalam pangkalan data SIM Kurikulum.')
                         ->withInput();
        }

        $inputIdentity = trim($validated['nip_or_username']);
        $matched = false;

        if (!empty($user->username) && strcasecmp($user->username, $inputIdentity) === 0) {
            $matched = true;
        }
        if (!empty($user->nip) && strcasecmp($user->nip, $inputIdentity) === 0) {
            $matched = true;
        }

        if (!$matched) {
            return back()->with('forgot_error', 'Kombinasi Email dan Username/NIP tidak cocok dengan data terdaftar.')
                         ->withInput();
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        NotificationService::send(
            $user->id,
            'Kata Sandi Berhasil Diperbarui',
            'Kata sandi akun Anda telah berhasil diperbarui melalui fitur Pemulihan Sandi Mandiri.',
            'security_alert',
            route('login')
        );

        return redirect()->route('login')->with('success', 'Kata sandi berhasil diperbarui! Silakan masuk dengan kata sandi baru Anda.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'identity' => 'required',
            'password' => 'required',
        ]);

        $identity = $credentials['identity'];
        $field = filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'email' : (is_numeric($identity) ? 'nip' : 'username');

        $user = User::where($field, $identity)->first();

        if ($user && Auth::attempt([$field => $identity, 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        return back()->withErrors([
            'identity' => 'NIP, Email, atau Kata Sandi yang Anda masukkan tidak sesuai.',
        ])->onlyInput('identity');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('info', 'Anda telah berhasil keluar dari sistem SIM Kurikulum.');
    }
}


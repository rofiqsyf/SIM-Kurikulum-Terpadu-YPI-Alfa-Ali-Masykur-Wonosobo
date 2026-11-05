<?php

namespace App\Http\Controllers;

use App\Models\UnitPendidikan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $units = UnitPendidikan::with('jenjang')->get();
        return view('auth.login', compact('units'));
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


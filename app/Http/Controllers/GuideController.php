<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuideController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        return view('guide.index', compact('user'));
    }

    /**
     * Standar Prosedur (SOP) Publik - Halaman Awal Sebelum Masuk Portal
     */
    public function publicSop()
    {
        return view('sop.public');
    }
}


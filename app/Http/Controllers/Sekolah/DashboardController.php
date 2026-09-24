<?php

namespace App\Http\Controllers\Sekolah;

use App\Http\Controllers\Controller;
use App\Models\Atlit;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $sekolahId = Auth::user()->sekolah_id;
        $sekolah = Auth::user()->sekolah;

        $stats = [
            'total' => Atlit::where('sekolah_id', $sekolahId)->count(),
            'pending' => Atlit::where('sekolah_id', $sekolahId)->where('status_verifikasi', Atlit::STATUS_VERIFIKASI_PENDING)->count(),
            'verified' => Atlit::where('sekolah_id', $sekolahId)->where('status_verifikasi', Atlit::STATUS_VERIFIKASI_VERIFIED)->count(),
            'rejected' => Atlit::where('sekolah_id', $sekolahId)->where('status_verifikasi', Atlit::STATUS_VERIFIKASI_REJECTED)->count(),
        ];

        $atlitTerbaru = Atlit::where('sekolah_id', $sekolahId)
            ->with(['klub', 'cabangOlahraga'])
            ->latest()
            ->take(5)
            ->get();

        return view('sekolah.dashboard', compact('sekolah', 'stats', 'atlitTerbaru'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Redirect user to appropriate dashboard based on role
     */
    public function index()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'user':
                return redirect()->route('atlit.dashboard');
            case 'verifikator':
                return redirect()->route('verifikator.dashboard');
            default:
                // Fallback untuk role yang tidak dikenali
                return view('dashboard');
        }
    }
}

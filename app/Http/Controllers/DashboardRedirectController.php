<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardRedirectController extends Controller
{
    /**
     * Redirect user to their appropriate dashboard based on role.
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->hasRole('super_admin')) {
            return redirect()->route('super-admin.dashboard');
        }

        if ($user->hasRole('admin_sekolah')) {
            return redirect()->route('admin-sekolah.dashboard');
        }

        if ($user->hasRole('verifikator')) {
            return redirect()->route('verifikator.dashboard');
        }

        if ($user->hasRole('pendaftar')) {
            return redirect()->route('applicant.dashboard');
        }

        if ($user->hasRole('viewer')) {
            return redirect('/viewer/dashboard');
        }

        // Fallback default
        return redirect('/');
    }
}

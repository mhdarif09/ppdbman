<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;

class PublicVerificationController extends Controller
{
    /**
     * Redirect from QR code to verification page.
     * This is a public route that verifiers can access.
     */
    public function redirect($token)
    {
        // If user is not authenticated, redirect to login
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('info', 'Silakan login sebagai verifikator untuk melakukan verifikasi.');
        }

        // If user is verifikator, redirect to verification detail
        if (auth()->user()->hasRole('verifikator')) {
            $applicant = Applicant::where('verification_token', $token)->first();
            
            if (!$applicant) {
                return redirect()->route('verifikator.dashboard')
                    ->with('error', 'Token verifikasi tidak valid.');
            }

            return redirect()->route('verifikator.verification.show', $applicant->id);
        }

        // If user is applicant, redirect to their dashboard
        if (auth()->user()->hasRole('pendaftar')) {
            return redirect()->route('applicant.dashboard')
                ->with('info', 'Anda tidak memiliki akses untuk melakukan verifikasi.');
        }

        // Otherwise, redirect to home
        return redirect()->route('dashboard')
            ->with('error', 'Anda tidak memiliki akses untuk melakukan verifikasi.');
    }
}

<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class RegistrationCardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:pendaftar']);
    }

    /**
     * Show registration card preview (HTML).
     */
    public function show()
    {
        $user = Auth::user();
        $applicant = Applicant::where('user_id', $user->id)
            ->with(['pathway', 'parents', 'grades', 'education'])
            ->first();

        if (!$applicant || !$applicant->registration_completed_at) {
            return redirect()->route('applicant.dashboard')
                ->with('error', 'Anda belum menyelesaikan pendaftaran.');
        }

        return view('applicant.registration-card.show', compact('applicant'));
    }

    /**
     * Download registration card as PDF.
     */
    public function download()
    {
        $user = Auth::user();
        $applicant = Applicant::where('user_id', $user->id)
            ->with(['pathway', 'parents', 'grades', 'education'])
            ->first();

        if (!$applicant || !$applicant->registration_completed_at) {
            return redirect()->route('applicant.dashboard')
                ->with('error', 'Anda belum menyelesaikan pendaftaran.');
        }

        $pdf = Pdf::loadView('pdf.registration-card', compact('applicant'))
            ->setPaper('a4', 'portrait');

        $safeRegNum = str_replace(['/', '\\'], '-', $applicant->registration_number);
        $filename = 'Kartu-Pendaftaran-' . $safeRegNum . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Download Exam Card as PDF.
     */
    public function downloadExamCard()
    {
        $user = Auth::user();
        $applicant = Applicant::where('user_id', $user->id)
            ->with(['pathway', 'education'])
            ->first();

        if (!$applicant || $applicant->status !== 'verified') {
            return redirect()->route('applicant.dashboard')
                ->with('error', 'Kartu Ujian hanya tersedia untuk peserta yang sudah diverifikasi.');
        }

        // Check pathway eligibility (Reguler & Tahfidz only)
        $pathwayName = strtoupper($applicant->pathway->name ?? '');
        $eligible = str_contains($pathwayName, 'REGULER') || str_contains($pathwayName, 'TAHFIDZ');

        if (!$eligible) {
             return redirect()->route('applicant.dashboard')
                ->with('error', 'Kartu Ujian tidak tersedia untuk jalur ini.');
        }

        $pdf = Pdf::loadView('pdf.exam-card', compact('applicant'))
            ->setPaper('a4', 'portrait')
            ->setWarnings(false);

        $safeRegNum = str_replace(['/', '\\'], '-', $applicant->registration_number);
        $filename = 'Kartu-Ujian-' . $safeRegNum . '.pdf';
        
        return $pdf->download($filename);
    }
}

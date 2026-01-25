<?php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\PpdbPathway;
use App\Models\SystemSetting;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerificationController extends Controller
{
    protected $activityLogger;

    public function __construct(ActivityLogger $activityLogger)
    {
        $this->middleware(['auth', 'role:verifikator']);
        $this->activityLogger = $activityLogger;
    }

    /**
     * Display pending verification list.
     */
    public function index(Request $request)
    {
        $academicYear = SystemSetting::get('academic_year_active', date('Y') . '/' . (date('Y') + 1));
        
        $query = Applicant::byAcademicYear($academicYear)
            ->pending()
            ->with(['pathway']);

        // Filters
        if ($request->filled('pathway')) {
            $query->where('ppdb_pathway_id', $request->pathway);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('registration_number', 'like', "%{$search}%");
            });
        }

        // FIFO Ordering
        $applicants = $query->orderBy('created_at', 'asc')->paginate(15);
        $pathways = PpdbPathway::active()->get();

        return view('verifikator.verification.index', compact('applicants', 'pathways'));
    }

    /**
     * Display verification history.
     */
    public function history(Request $request)
    {
        $academicYear = SystemSetting::get('academic_year_active', date('Y') . '/' . (date('Y') + 1));
        
        $query = Applicant::byAcademicYear($academicYear)
            ->where('verified_by', auth()->id())
            ->with(['pathway']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applicants = $query->orderBy('verified_at', 'desc')->paginate(15);

        return view('verifikator.verification.history', compact('applicants'));
    }

    /**
     * Show detailed applicant data for verification.
     */
    public function show(Applicant $applicant)
    {
        // Policy check or simple check - verificator can view any applicant usually
        // but verify actions should be restricted if already verified.
        
        $applicant->load(['pathway', 'user', 'verifier']);

        return view('verifikator.verification.show', compact('applicant'));
    }

    /**
     * Approve verification.
     */
    public function approve(Applicant $applicant)
    {
        if ($applicant->status !== 'pending') {
            return back()->with('error', 'Status pendaftar bukan pending.');
        }

        DB::transaction(function () use ($applicant) {
            $oldValues = $applicant->getOriginal();
            
            $applicant->update([
                'status' => 'verified',
                'verified_at' => now(),
                'verified_by' => auth()->id(),
                'rejection_reason' => null // Clear reason if any previous
            ]);
            
            // Increment filled quota
            if ($applicant->pathway) {
                $applicant->pathway->increment('filled');
            }

            $this->activityLogger->logUpdated($applicant, $oldValues, 'verified');
        });

        return redirect()->route('verifikator.verification.index')
            ->with('success', "Pendaftaran {$applicant->full_name} berhasil disetujui.");
    }

    /**
     * Reject verification.
     */
    public function reject(Request $request, Applicant $applicant)
    {
        if ($applicant->status !== 'pending') {
            return back()->with('error', 'Status pendaftar bukan pending.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|min:5'
        ]);

        DB::transaction(function () use ($request, $applicant) {
            $oldValues = $applicant->getOriginal();
            
            $applicant->update([
                'status' => 'rejected',
                'verified_at' => now(),
                'verified_by' => auth()->id(),
                'rejection_reason' => $request->rejection_reason
            ]);

            $this->activityLogger->logUpdated($applicant, $oldValues, 'rejected');
        });

        return redirect()->route('verifikator.verification.index')
            ->with('success', "Pendaftaran {$applicant->full_name} ditolak.");
    }
}

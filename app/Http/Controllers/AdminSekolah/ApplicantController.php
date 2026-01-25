<?php

namespace App\Http\Controllers\AdminSekolah;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\PpdbPathway;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin_sekolah']);
    }

    /**
     * Display a listing of applicants.
     */
    public function index(Request $request)
    {
        $academicYear = SystemSetting::get('academic_year_active', date('Y') . '/' . (date('Y') + 1));
        
        $query = Applicant::with(['pathway', 'user'])
            ->byAcademicYear($academicYear);

        // Filter by pathway
        if ($request->filled('pathway')) {
            $query->where('ppdb_pathway_id', $request->pathway);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('registration_number', 'like', "%{$search}%");
            });
        }

        $applicants = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get pathways for filter
        $pathways = PpdbPathway::byAcademicYear($academicYear)->active()->get();

        return view('admin-sekolah.applicants.index', compact('applicants', 'pathways'));
    }

    /**
     * Display the specified applicant.
     */
    public function show(Applicant $applicant)
    {
        $applicant->load(['pathway', 'user', 'verifier']);

        return view('admin-sekolah.applicants.show', compact('applicant'));
    }
}

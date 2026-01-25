<?php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use App\Services\StatisticsService;
use App\Models\Applicant;
use App\Models\SystemSetting;

class DashboardController extends Controller
{
    protected $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {
        $this->middleware(['auth', 'role:verifikator']);
        $this->statisticsService = $statisticsService;
    }

    /**
     * Display Verifikator dashboard.
     */
    public function index()
    {
        $stats = $this->statisticsService->getVerifierStats(auth()->id());
        $academicYear = SystemSetting::get('academic_year_active', '2024/2025');
        
        // Get recent pending applicants
        $pendingApplicants = Applicant::byAcademicYear($academicYear)
            ->pending()
            ->with(['pathway'])
            ->orderBy('created_at', 'asc') // First in first out
            ->limit(5)
            ->get();

        return view('verifikator.dashboard', compact('stats', 'academicYear', 'pendingApplicants'));
    }
}

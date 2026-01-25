<?php

namespace App\Http\Controllers\AdminSekolah;

use App\Http\Controllers\Controller;
use App\Services\StatisticsService;
use App\Models\SystemSetting;

class DashboardController extends Controller
{
    protected $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {
        $this->middleware(['auth', 'role:admin_sekolah']);
        $this->statisticsService = $statisticsService;
    }

    /**
     * Display Admin Sekolah dashboard.
     */
    public function index()
    {
        $totalApplicants = $this->statisticsService->getTotalApplicants();
        $applicantsByStatus = $this->statisticsService->getApplicantsByStatus();
        $applicantsByPathway = $this->statisticsService->getApplicantsByPathway();
        $quotaProgress = $this->statisticsService->getQuotaProgress();
        
        $ppdbStatus = SystemSetting::get('ppdb_status', 'closed');
        $academicYear = SystemSetting::get('academic_year_active', '2024/2025');
        $schoolName = SystemSetting::get('school_name', 'Sekolah');

        return view('admin-sekolah.dashboard', compact(
            'totalApplicants',
            'applicantsByStatus',
            'applicantsByPathway',
            'quotaProgress',
            'ppdbStatus',
            'academicYear',
            'schoolName'
        ));
    }
}

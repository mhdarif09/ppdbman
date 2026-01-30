<?php

namespace App\Http\Controllers\AdminSekolah;

use App\Http\Controllers\Controller;
use App\Models\PpdbPathway;
use App\Models\SystemSetting;
use App\Services\ExportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $exportService;

    public function __construct(ExportService $exportService)
    {
        $this->middleware(['auth', 'role:admin_sekolah']);
        $this->exportService = $exportService;
    }

    /**
     * Display report index page.
     */
    public function index()
    {
        $academicYear = SystemSetting::get('academic_year_active', date('Y') . '/' . (date('Y') + 1));
        $pathways = PpdbPathway::byAcademicYear($academicYear)->active()->get();

        return view('admin-sekolah.reports.index', compact('pathways'));
    }

    /**
     * Export report to Excel.
     */
    public function exportExcel(Request $request)
    {
        return $this->exportService->downloadExcel($request->all());
    }

    /**
     * Export report to PDF.
     */
    public function exportPDF(Request $request)
    {
        return $this->exportService->downloadPDF($request->all());
    }

    /**
     * Export report to CSV.
     */
    public function exportCSV(Request $request)
    {
        return $this->exportService->downloadCSV($request->all());
    }
}

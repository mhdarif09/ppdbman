<?php

namespace App\Services;

use App\Models\Applicant;
use App\Models\SystemSetting;
use Illuminate\Database\Eloquent\Builder;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Facades\Excel;

class ExportService
{
    /**
     * Build the applicant query based on filters.
     */
    protected function buildQuery(array $filters): Builder
    {
        $academicYear = SystemSetting::get('academic_year_active', date('Y') . '/' . (date('Y') + 1));
        
        $query = Applicant::with(['pathway', 'user', 'verifier'])
            ->byAcademicYear($academicYear);

        if (!empty($filters['pathway'])) {
            $query->where('ppdb_pathway_id', $filters['pathway']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        return $query;
    }

    /**
     * Download applicants data as Excel.
     */
    public function downloadExcel(array $filters)
    {
        $query = $this->buildQuery($filters);
        
        return Excel::download(new class($query) implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize {
            protected $query;

            public function __construct($query)
            {
                $this->query = $query;
            }

            public function collection()
            {
                return $this->query->get();
            }

            public function headings(): array
            {
                return [
                    'No. Pendaftaran',
                    'NISN',
                    'Nama Lengkap',
                    'Jalur PPDB',
                    'Status',
                    'Tanggal Daftar',
                    'Total Skor',
                ];
            }

            public function map($applicant): array
            {
                return [
                    $applicant->registration_number,
                    $applicant->nisn,
                    $applicant->full_name,
                    $applicant->pathway->name ?? '-',
                    ucfirst($applicant->status),
                    $applicant->created_at->format('Y-m-d H:i:s'),
                    $applicant->total_score ?? '0',
                ];
            }
        }, 'laporan_ppdb_' . date('Y-m-d_H-i') . '.xlsx');
    }

    /**
     * Download applicants data as PDF.
     */
    public function downloadPDF(array $filters)
    {
        $applicants = $this->buildQuery($filters)->get();
        $schoolName = SystemSetting::get('school_name', 'Sekolah');
        $academicYear = SystemSetting::get('academic_year_active', date('Y') . '/' . (date('Y') + 1));
        
        $pdf = Pdf::loadView('admin-sekolah.reports.pdf', compact('applicants', 'schoolName', 'academicYear'))
            ->setPaper('a4', 'landscape');
            
        return $pdf->download('laporan_ppdb_' . date('Y-m-d_H-i') . '.pdf');
    }

    /**
     * Download applicants data as CSV.
     */
    public function downloadCSV(array $filters)
    {
        $query = $this->buildQuery($filters);
        
        return Excel::download(new class($query) implements FromCollection, WithHeadings, WithMapping {
            protected $query;

            public function __construct($query)
            {
                $this->query = $query;
            }

            public function collection()
            {
                return $this->query->get();
            }

            public function headings(): array
            {
                return [
                    'No. Pendaftaran',
                    'NISN',
                    'Nama Lengkap',
                    'Jalur PPDB',
                    'Status',
                    'Tanggal Daftar',
                    'Total Skor',
                ];
            }

            public function map($applicant): array
            {
                return [
                    $applicant->registration_number,
                    $applicant->nisn,
                    $applicant->full_name,
                    $applicant->pathway->name ?? '-',
                    ucfirst($applicant->status),
                    $applicant->created_at->format('Y-m-d H:i:s'),
                    $applicant->total_score ?? '0',
                ];
            }
        }, 'laporan_ppdb_' . date('Y-m-d_H-i') . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}

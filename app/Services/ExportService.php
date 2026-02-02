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
    /**
     * Download applicants data as Excel.
     */
    public function downloadExcel(array $filters)
    {
        $query = $this->buildQuery($filters)
            ->with(['parents', 'education', 'hobby', 'development', 'grades']);
        
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
                    'No',
                    'No. Pendaftaran',
                    'Status',
                    'Jalur Masuk',
                    'Tanggal Daftar',
                    
                    // Akun
                    'Nama Lengkap',
                    'NISN',
                    'NIK',
                    'Email',
                    'No. HP',
                    
                    // Biodata
                    'Tempat Lahir',
                    'Tanggal Lahir',
                    'Jenis Kelamin',
                    'Agama',
                    'Kewarganegaraan',
                    'Anak Ke',
                    'Jml Sdr Kandung',
                    'Status Anak',
                    'Alamat Lengkap',
                    'No. WhatsApp',
                    'Gol. Darah',
                    'Penyakit',
                    'Tinggi Badan',
                    'Berat Badan',
                    
                    // Pendidikan (Asal Sekolah)
                    'Asal Sekolah',
                    'NPSN Sekolah',
                    'Alamat Sekolah',
                    'Tahun Lulus',
                    'No. STTB/Ijazah',
                    
                    // Orang Tua (Ayah)
                    'Nama Ayah',
                    'NIK Ayah',
                    'Pekerjaan Ayah',
                    'Penghasilan Ayah',
                    'No. HP Ayah',
                    
                    // Orang Tua (Ibu)
                    'Nama Ibu',
                    'NIK Ibu',
                    'Pekerjaan Ibu',
                    'Penghasilan Ibu',
                    'No. HP Ibu',
                    
                    // Wali
                    'Nama Wali',
                    'Pekerjaan Wali',
                    'No. HP Wali',
                    
                    // Nilai/Hobi
                    'Hobi Seni',
                    'Hobi Olahraga',
                    'Organisasi',
                    'Prestasi/Beasiswa',
                ];
            }

            public function map($applicant): array
            {
                // Helpers
                $parents = $applicant->parents;
                $edu = $applicant->education;
                $hobby = $applicant->hobby;
                $dev = $applicant->development;

                return [
                    $applicant->id,
                    $applicant->registration_number,
                    ucfirst($applicant->status),
                    $applicant->pathway->name ?? '-',
                    $applicant->created_at->format('d-m-Y H:i'),
                    
                    // Akun
                    $applicant->full_name,
                    $applicant->nisn,
                    $applicant->nik,
                    $applicant->user->email ?? '-',
                    $applicant->phone,
                    
                    // Biodata
                    $applicant->birth_place,
                    $applicant->birth_date ? $applicant->birth_date->format('d-m-Y') : '-',
                    $applicant->gender == 'L' ? 'Laki-laki' : 'Perempuan',
                    $applicant->religion,
                    $applicant->nationality,
                    $applicant->child_order,
                    $applicant->siblings_count,
                    $applicant->child_status,
                    $applicant->address,
                    $applicant->whatsapp_number ?? $applicant->phone,
                    $applicant->blood_type,
                    $applicant->diseases ? implode(', ', $applicant->diseases) : '-',
                    $applicant->height,
                    $applicant->weight,
                    
                    // Pendidikan
                    $edu?->school_name,
                    $edu?->school_npsn,
                    $edu?->school_address,
                    $dev?->graduation_year,
                    $edu?->sttb_number,
                    
                    // Ayah
                    $parents?->father_name,
                    $parents?->father_nik,
                    $parents?->father_job,
                    $parents?->father_income,
                    $parents?->father_phone,
                    
                    // Ibu
                    $parents?->mother_name,
                    $parents?->mother_nik,
                    $parents?->mother_job,
                    $parents?->mother_income,
                    $parents?->mother_phone,
                    
                    // Wali
                    $parents?->guardian_name,
                    $parents?->guardian_job,
                    $parents?->guardian_phone,
                    
                    // Hobi/Lainnya
                    $hobby?->arts,
                    $hobby?->sports,
                    $hobby?->organization,
                    $dev?->scholarships,
                ];
            }
        }, 'Laporan_Lengkap_PMB_' . date('Y-m-d_H-i') . '.xlsx');
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

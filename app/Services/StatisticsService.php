<?php

namespace App\Services;

use App\Models\Applicant;
use App\Models\PpdbPathway;
use App\Models\SystemSetting;

class StatisticsService
{
    /**
     * Get total applicants count.
     */
    public function getTotalApplicants(): int
    {
        $academicYear = SystemSetting::get('academic_year_active', date('Y') . '/' . (date('Y') + 1));
        return Applicant::byAcademicYear($academicYear)->count();
    }

    /**
     * Get applicants breakdown by status.
     */
    public function getApplicantsByStatus(): array
    {
        $academicYear = SystemSetting::get('academic_year_active', date('Y') . '/' . (date('Y') + 1));
        
        return [
            'pending' => Applicant::byAcademicYear($academicYear)->pending()->count(),
            'verified' => Applicant::byAcademicYear($academicYear)->verified()->count(),
            'accepted' => Applicant::byAcademicYear($academicYear)->accepted()->count(),
            'rejected' => Applicant::byAcademicYear($academicYear)->rejected()->count(),
        ];
    }

    /**
     * Get applicants breakdown by pathway.
     */
    public function getApplicantsByPathway(): array
    {
        $academicYear = SystemSetting::get('academic_year_active', date('Y') . '/' . (date('Y') + 1));
        
        $pathways = PpdbPathway::byAcademicYear($academicYear)
            ->active()
            ->withCount('applicants')
            ->get();

        return $pathways->mapWithKeys(function ($pathway) {
            return [$pathway->name => $pathway->applicants_count];
        })->toArray();
    }

    /**
     * Get quota progress for all pathways.
     */
    public function getQuotaProgress(): array
    {
        $academicYear = SystemSetting::get('academic_year_active', date('Y') . '/' . (date('Y') + 1));
        
        return PpdbPathway::byAcademicYear($academicYear)
            ->active()
            ->get()
            ->map(function ($pathway) {
                return [
                    'name' => $pathway->name,
                    'quota' => $pathway->quota,
                    'filled' => $pathway->filled,
                    'remaining' => $pathway->remaining_quota,
                    'progress' => $pathway->quota_progress,
                ];
            })
            ->toArray();
    }

    /**
     * Get statistics for specific verifier.
     */
    public function getVerifierStats($userId): array
    {
        $academicYear = SystemSetting::get('academic_year_active', date('Y') . '/' . (date('Y') + 1));
        
        $today = now()->startOfDay();

        return [
            'pending_count' => Applicant::byAcademicYear($academicYear)
                ->pending()
                ->count(),
            
            'my_verified_count' => Applicant::byAcademicYear($academicYear)
                ->where('verified_by', $userId)
                ->where('status', 'verified')
                ->count(),
                
            'my_rejected_count' => Applicant::byAcademicYear($academicYear)
                ->where('verified_by', $userId)
                ->where('status', 'rejected')
                ->count(),

            'verified_today' => Applicant::byAcademicYear($academicYear)
                ->where('verified_by', $userId)
                ->where('verified_at', '>=', $today)
                ->count(),
        ];
    }
}

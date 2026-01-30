<?php

namespace Database\Seeders;

use App\Models\PpdbPathway;
use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class PpdbPathwaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYear = SystemSetting::get('academic_year_active', '2024/2025');

        $pathways = [
            [
                'name' => 'Reguler',
                'description' => 'Jalur reguler untuk umum',
                'quota' => 100,
                'filled' => 0,
                'is_active' => true,
                'academic_year' => $academicYear,
            ],
            [
                'name' => 'PMPA Prestasi',
                'description' => 'Jalur prestasi akademik dan non-akademik',
                'quota' => 30,
                'filled' => 0,
                'is_active' => true,
                'academic_year' => $academicYear,
            ],
            [
                'name' => 'PMPA Tahfidz',
                'description' => 'Jalur khusus penghafal Al-Qur\'an',
                'quota' => 20,
                'filled' => 0,
                'is_active' => true,
                'academic_year' => $academicYear,
            ],
        ];

        foreach ($pathways as $pathway) {
            PpdbPathway::updateOrCreate(
                [
                    'name' => $pathway['name'],
                    'academic_year' => $pathway['academic_year'],
                ],
                $pathway
            );
        }

        $this->command->info('PPDB Pathways seeded successfully.');
    }
}

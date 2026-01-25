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
                'name' => 'Zonasi',
                'description' => 'Jalur zonasi berdasarkan domisili terdekat dengan sekolah',
                'quota' => 50,
                'filled' => 0,
                'is_active' => true,
                'academic_year' => $academicYear,
            ],
            [
                'name' => 'Prestasi',
                'description' => 'Jalur prestasi akademik dan non-akademik',
                'quota' => 20,
                'filled' => 0,
                'is_active' => true,
                'academic_year' => $academicYear,
            ],
            [
                'name' => 'Afirmasi',
                'description' => 'Jalur afirmasi untuk peserta didik dari keluarga kurang mampu',
                'quota' => 10,
                'filled' => 0,
                'is_active' => true,
                'academic_year' => $academicYear,
            ],
            [
                'name' => 'Perpindahan Orang Tua',
                'description' => 'Jalur perpindahan tugas orang tua/wali',
                'quota' => 10,
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

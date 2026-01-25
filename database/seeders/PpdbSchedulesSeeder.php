<?php

namespace Database\Seeders;

use App\Models\PpdbSchedule;
use App\Models\SystemSetting;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PpdbSchedulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYear = SystemSetting::get('academic_year_active', '2024/2025');
        $ppdbStart = Carbon::parse(SystemSetting::get('ppdb_start_date', now()));
        $ppdbEnd = Carbon::parse(SystemSetting::get('ppdb_end_date', now()->addDays(30)));

        $schedules = [
            [
                'name' => 'Pendaftaran',
                'description' => 'Periode pendaftaran peserta didik baru',
                'start_date' => $ppdbStart->format('Y-m-d'),
                'end_date' => $ppdbStart->copy()->addDays(14)->format('Y-m-d'),
                'academic_year' => $academicYear,
            ],
            [
                'name' => 'Verifikasi',
                'description' => 'Periode verifikasi dokumen pendaftar',
                'start_date' => $ppdbStart->copy()->addDays(15)->format('Y-m-d'),
                'end_date' => $ppdbStart->copy()->addDays(21)->format('Y-m-d'),
                'academic_year' => $academicYear,
            ],
            [
                'name' => 'Pengumuman',
                'description' => 'Pengumuman hasil seleksi PPDB',
                'start_date' => $ppdbStart->copy()->addDays(25)->format('Y-m-d'),
                'end_date' => $ppdbEnd->format('Y-m-d'),
                'academic_year' => $academicYear,
            ],
        ];

        foreach ($schedules as $schedule) {
            PpdbSchedule::updateOrCreate(
                [
                    'name' => $schedule['name'],
                    'academic_year' => $schedule['academic_year'],
                ],
                $schedule
            );
        }

        $this->command->info('PPDB Schedules seeded successfully.');
    }
}

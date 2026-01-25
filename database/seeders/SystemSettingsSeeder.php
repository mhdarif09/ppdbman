<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'school_name',
                'value' => 'SMA Negeri 1 Jakarta',
                'type' => 'string',
                'description' => 'Nama sekolah',
            ],
            [
                'key' => 'academic_year_active',
                'value' => '2024/2025',
                'type' => 'string',
                'description' => 'Tahun ajaran yang sedang aktif',
            ],
            [
                'key' => 'ppdb_status',
                'value' => 'open',
                'type' => 'string',
                'description' => 'Status PPDB: open atau closed',
            ],
            [
                'key' => 'ppdb_start_date',
                'value' => now()->format('Y-m-d'),
                'type' => 'date',
                'description' => 'Tanggal mulai pendaftaran PPDB',
            ],
            [
                'key' => 'ppdb_end_date',
                'value' => now()->addDays(30)->format('Y-m-d'),
                'type' => 'date',
                'description' => 'Tanggal akhir pendaftaran PPDB',
            ],
            [
                'key' => 'contact_email',
                'value' => 'ppdb@smansatu.sch.id',
                'type' => 'string',
                'description' => 'Email kontak untuk PPDB',
            ],
            [
                'key' => 'contact_phone',
                'value' => '021-12345678',
                'type' => 'string',
                'description' => 'Nomor telepon kontak untuk PPDB',
            ],
        ];

        foreach ($settings as $setting) {
            SystemSetting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                    'description' => $setting['description'],
                ]
            );
        }

        $this->command->info('System settings seeded successfully.');
    }
}

<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'super_admin',
                'display_name' => 'Super Admin',
                'description' => 'Memiliki akses penuh ke seluruh sistem, mengelola role dan permission, mengatur konfigurasi global, dan mengakses semua log sistem.',
            ],
            [
                'name' => 'admin_sekolah',
                'display_name' => 'Admin Sekolah',
                'description' => 'Mengelola data pendaftar, mengatur kuota dan jalur PPDB, mengelola jadwal, mempublikasikan pengumuman, dan melihat laporan.',
            ],
            [
                'name' => 'verifikator',
                'display_name' => 'Verifikator',
                'description' => 'Memverifikasi data dan berkas pendaftar, menyetujui atau menolak pendaftaran, memberikan catatan perbaikan.',
            ],
            [
                'name' => 'pendaftar',
                'display_name' => 'Pendaftar',
                'description' => 'Siswa atau calon siswa yang mendaftar. Dapat mengisi formulir, mengunggah dokumen, dan melihat status pendaftaran.',
            ],
            [
                'name' => 'viewer',
                'display_name' => 'Viewer (Kepala Sekolah / Pengawas)',
                'description' => 'Akses read-only untuk melihat dashboard dan laporan tanpa dapat mengubah data apa pun.',
            ],
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(
                ['name' => $roleData['name']],
                [
                    'display_name' => $roleData['display_name'],
                    'description' => $roleData['description'],
                ]
            );
        }

        $this->command->info('5 roles have been seeded successfully.');
    }
}

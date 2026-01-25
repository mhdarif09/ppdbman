<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testUsers = [
            [
                'name' => 'Super Administrator',
                'email' => 'superadmin@ppdb.test',
                'password' => 'password',
                'role' => 'super_admin',
            ],
            [
                'name' => 'Admin Sekolah',
                'email' => 'adminsekolah@ppdb.test',
                'password' => 'password',
                'role' => 'admin_sekolah',
            ],
            [
                'name' => 'Verifikator',
                'email' => 'verifikator@ppdb.test',
                'password' => 'password',
                'role' => 'verifikator',
            ],
            [
                'name' => 'Pendaftar Test',
                'email' => 'pendaftar@ppdb.test',
                'password' => 'password',
                'role' => 'pendaftar',
            ],
            [
                'name' => 'Viewer (Kepala Sekolah)',
                'email' => 'viewer@ppdb.test',
                'password' => 'password',
                'role' => 'viewer',
            ],
        ];

        foreach ($testUsers as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make($userData['password']),
                ]
            );

            // Assign role
            $role = Role::where('name', $userData['role'])->first();
            if ($role) {
                $user->assignRole($role);
            }

            $this->command->info('Created user: ' . $userData['email'] . ' with role: ' . $userData['role']);
        }

        $this->command->info('All test users created successfully.');
    }
}

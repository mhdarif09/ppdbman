<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all permissions
        $allPermissions = Permission::pluck('name')->toArray();

        // Super Admin: All permissions
        $superAdmin = Role::where('name', 'super_admin')->first();
        if ($superAdmin) {
            $permissions = Permission::all();
            $superAdmin->permissions()->sync($permissions->pluck('id'));
            $this->command->info('Super Admin: ' . count($permissions) . ' permissions assigned.');
        }

        // Admin Sekolah: All except role/permission management and verification
        $adminSekolah = Role::where('name', 'admin_sekolah')->first();
        if ($adminSekolah) {
            $excludedPermissions = [
                'manage-roles',
                'manage-permissions',
                'verify-applicants',
                'reject-applicants',
                'add-verification-notes',
                'view-system-logs',
            ];

            $permissions = Permission::whereNotIn('name', $excludedPermissions)->get();
            $adminSekolah->permissions()->sync($permissions->pluck('id'));
            $this->command->info('Admin Sekolah: ' . count($permissions) . ' permissions assigned.');
        }

        // Verifikator: Verification + view permissions only
        $verifikator = Role::where('name', 'verifikator')->first();
        if ($verifikator) {
            $verifikatorPermissions = [
                'view-applicants',
                'verify-applicants',
                'reject-applicants',
                'add-verification-notes',
                'view-dashboard',
                'view-statistics',
                'view-reports',
            ];

            $permissions = Permission::whereIn('name', $verifikatorPermissions)->get();
            $verifikator->permissions()->sync($permissions->pluck('id'));
            $this->command->info('Verifikator: ' . count($permissions) . ' permissions assigned.');
        }

        // Pendaftar: Application submission and own data viewing
        $pendaftar = Role::where('name', 'pendaftar')->first();
        if ($pendaftar) {
            $pendaftarPermissions = [
                'submit-application',
                'edit-own-application',
                'upload-documents',
                'view-own-results',
                'print-registration',
            ];

            $permissions = Permission::whereIn('name', $pendaftarPermissions)->get();
            $pendaftar->permissions()->sync($permissions->pluck('id'));
            $this->command->info('Pendaftar: ' . count($permissions) . ' permissions assigned.');
        }

        // Viewer: Read-only access
        $viewer = Role::where('name', 'viewer')->first();
        if ($viewer) {
            $viewerPermissions = [
                'view-users',
                'view-applicants',
                'view-dashboard',
                'view-statistics',
                'view-reports',
            ];

            $permissions = Permission::whereIn('name', $viewerPermissions)->get();
            $viewer->permissions()->sync($permissions->pluck('id'));
            $this->command->info('Viewer: ' . count($permissions) . ' permissions assigned.');
        }

        $this->command->info('All role-permission assignments completed successfully.');
    }
}

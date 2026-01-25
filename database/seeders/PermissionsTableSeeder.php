<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // User Management
            ['name' => 'manage-users', 'display_name' => 'Manage Users', 'description' => 'Create, edit, and delete user accounts'],
            ['name' => 'view-users', 'display_name' => 'View Users', 'description' => 'View list and details of users'],

            // Role & Permission Management
            ['name' => 'manage-roles', 'display_name' => 'Manage Roles', 'description' => 'Create, edit, and delete roles'],
            ['name' => 'manage-permissions', 'display_name' => 'Manage Permissions', 'description' => 'Assign permissions to roles'],

            // Applicant Management
            ['name' => 'view-applicants', 'display_name' => 'View Applicants', 'description' => 'View list and details of applicants'],
            ['name' => 'edit-applicants', 'display_name' => 'Edit Applicants', 'description' => 'Edit applicant data'],
            ['name' => 'delete-applicants', 'display_name' => 'Delete Applicants', 'description' => 'Delete applicant records'],

            // Verification
            ['name' => 'verify-applicants', 'display_name' => 'Verify Applicants', 'description' => 'Verify applicant documents and data'],
            ['name' => 'reject-applicants', 'display_name' => 'Reject Applicants', 'description' => 'Reject applicant submissions'],
            ['name' => 'add-verification-notes', 'display_name' => 'Add Verification Notes', 'description' => 'Add notes and feedback for applicants'],

            // PPDB Configuration
            ['name' => 'manage-quotas', 'display_name' => 'Manage Quotas', 'description' => 'Set and modify admission quotas'],
            ['name' => 'manage-schedules', 'display_name' => 'Manage Schedules', 'description' => 'Set PPDB schedules and deadlines'],
            ['name' => 'manage-academic-years', 'display_name' => 'Manage Academic Years', 'description' => 'Configure academic year settings'],

            // Announcements
            ['name' => 'publish-announcements', 'display_name' => 'Publish Announcements', 'description' => 'Create and publish announcements'],
            ['name' => 'edit-announcements', 'display_name' => 'Edit Announcements', 'description' => 'Edit existing announcements'],

            // Reports
            ['name' => 'view-reports', 'display_name' => 'View Reports', 'description' => 'Access and view reports'],
            ['name' => 'export-reports', 'display_name' => 'Export Reports', 'description' => 'Export reports to various formats'],

            // Dashboard
            ['name' => 'view-dashboard', 'display_name' => 'View Dashboard', 'description' => 'Access dashboard'],
            ['name' => 'view-statistics', 'display_name' => 'View Statistics', 'description' => 'View statistical data and charts'],

            // Application Forms (Pendaftar)
            ['name' => 'submit-application', 'display_name' => 'Submit Application', 'description' => 'Submit new application'],
            ['name' => 'edit-own-application', 'display_name' => 'Edit Own Application', 'description' => 'Edit own application before verification'],
            ['name' => 'upload-documents', 'display_name' => 'Upload Documents', 'description' => 'Upload required documents'],
            ['name' => 'view-own-results', 'display_name' => 'View Own Results', 'description' => 'View own selection results'],
            ['name' => 'print-registration', 'display_name' => 'Print Registration', 'description' => 'Print registration proof'],

            // System Logs
            ['name' => 'view-system-logs', 'display_name' => 'View System Logs', 'description' => 'Access and view system logs'],
        ];

        foreach ($permissions as $permissionData) {
            Permission::firstOrCreate(
                ['name' => $permissionData['name']],
                [
                    'display_name' => $permissionData['display_name'],
                    'description' => $permissionData['description'],
                ]
            );
        }

        $this->command->info(count($permissions) . ' permissions have been seeded successfully.');
    }
}

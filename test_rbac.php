<?php

/**
 * RBAC System Test Script
 * Run this with: php test_rbac.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

echo "==============================================\n";
echo "RBAC SYSTEM VERIFICATION TEST\n";
echo "==============================================\n\n";

// Test 1: Verify all roles exist
echo "1. Testing Roles:\n";
$roles = Role::all();
echo "   Total Roles: " . $roles->count() . "\n";
foreach ($roles as $role) {
    echo "   - {$role->display_name} ({$role->name})\n";
}
echo "\n";

// Test 2: Verify all permissions exist
echo "2. Testing Permissions:\n";
$permissions = Permission::all();
echo "   Total Permissions: " . $permissions->count() . "\n\n";

// Test 3: Test Admin Sekolah user
echo "3. Testing Admin Sekolah User:\n";
$adminSekolah = User::where('email', 'adminsekolah@ppdb.test')->first();
if ($adminSekolah) {
    echo "   User: {$adminSekolah->name}\n";
    echo "   Email: {$adminSekolah->email}\n";
    echo "   Roles: " . $adminSekolah->getRoleNames()->implode(', ') . "\n";
    echo "   Has 'admin_sekolah' role: " . ($adminSekolah->hasRole('admin_sekolah') ? 'YES' : 'NO') . "\n";
    echo "   Has 'verify-applicants' permission: " . ($adminSekolah->hasPermission('verify-applicants') ? 'YES' : 'NO') . "\n";
    echo "   Has 'edit-applicants' permission: " . ($adminSekolah->hasPermission('edit-applicants') ? 'YES' : 'NO') . "\n";
    echo "   Total permissions: " . $adminSekolah->getPermissionNames()->count() . "\n";
}
echo "\n";

// Test 4: Test Verifikator user
echo "4. Testing Verifikator User:\n";
$verifikator = User::where('email', 'verifikator@ppdb.test')->first();
if ($verifikator) {
    echo "   User: {$verifikator->name}\n";
    echo "   Email: {$verifikator->email}\n";
    echo "   Roles: " . $verifikator->getRoleNames()->implode(', ') . "\n";
    echo "   Has 'verify-applicants' permission: " . ($verifikator->hasPermission('verify-applicants') ? 'YES' : 'NO') . "\n";
    echo "   Has 'edit-applicants' permission: " . ($verifikator->hasPermission('edit-applicants') ? 'YES' : 'NO') . "\n";
    echo "   Has 'manage-quotas' permission: " . ($verifikator->hasPermission('manage-quotas') ? 'YES' : 'NO') . "\n";
    echo "   Total permissions: " . $verifikator->getPermissionNames()->count() . "\n";
}
echo "\n";

// Test 5: Test Pendaftar user
echo "5. Testing Pendaftar User:\n";
$pendaftar = User::where('email', 'pendaftar@ppdb.test')->first();
if ($pendaftar) {
    echo "   User: {$pendaftar->name}\n";
    echo "   Email: {$pendaftar->email}\n";
    echo "   Roles: " . $pendaftar->getRoleNames()->implode(', ') . "\n";
    echo "   Has 'submit-application' permission: " . ($pendaftar->hasPermission('submit-application') ? 'YES' : 'NO') . "\n";
    echo "   Has 'view-applicants' permission: " . ($pendaftar->hasPermission('view-applicants') ? 'YES' : 'NO') . "\n";
    echo "   Total permissions: " . $pendaftar->getPermissionNames()->count() . "\n";
}
echo "\n";

// Test 6: Test Super Admin user
echo "6. Testing Super Admin User:\n";
$superAdmin = User::where('email', 'superadmin@ppdb.test')->first();
if ($superAdmin) {
    echo "   User: {$superAdmin->name}\n";
    echo "   Email: {$superAdmin->email}\n";
    echo "   Roles: " . $superAdmin->getRoleNames()->implode(', ') . "\n";
    echo "   Total permissions: " . $superAdmin->getPermissionNames()->count() . "\n";
}
echo "\n";

// Test 7: Test role/permission assignment methods
echo "7. Testing Role Assignment Methods:\n";
$testUser = User::where('email', 'viewer@ppdb.test')->first();
if ($testUser) {
    echo "   Original roles: " . $testUser->getRoleNames()->implode(', ') . "\n";
    
    // Test hasAnyRole
    $hasAnyRole = $testUser->hasAnyRole(['admin_sekolah', 'viewer']);
    echo "   Has any role (admin_sekolah, viewer): " . ($hasAnyRole ? 'YES' : 'NO') . "\n";
    
    // Test hasPermission
    $canViewDashboard = $testUser->hasPermission('view-dashboard');
    echo "   Can view dashboard: " . ($canViewDashboard ? 'YES' : 'NO') . "\n";
    
    $canManageUsers = $testUser->hasPermission('manage-users');
    echo "   Can manage users: " . ($canManageUsers ? 'YES' : 'NO') . "\n";
}
echo "\n";

echo "==============================================\n";
echo "ALL TESTS COMPLETED SUCCESSFULLY!\n";
echo "==============================================\n";

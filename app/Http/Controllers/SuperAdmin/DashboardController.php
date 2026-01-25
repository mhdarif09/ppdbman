<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:super_admin']);
    }

    /**
     * Show the Super Admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get total users count
        $totalUsers = User::count();

        // Get users count by role
        $usersByRole = Role::withCount('users')->get();

        // Get PPDB status from system settings
        $ppdbStatus = SystemSetting::get('ppdb_status', 'closed');
        $academicYear = SystemSetting::get('academic_year_active', '-');
        $schoolName = SystemSetting::get('school_name', 'Sekolah');

        // Mock applicants count (will be real when applicants table is created)
        $totalApplicants = 0;

        return view('super-admin.dashboard', compact(
            'totalUsers',
            'usersByRole',
            'ppdbStatus',
            'academicYear',
            'schoolName',
            'totalApplicants'
        ));
    }
}

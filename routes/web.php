<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\RoleController;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Http\Controllers\SuperAdmin\SystemConfigController;
use App\Http\Controllers\SuperAdmin\ActivityLogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Central Dashboard Redirect
Route::get('/dashboard', [App\Http\Controllers\DashboardRedirectController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/home', [App\Http\Controllers\DashboardRedirectController::class, 'index'])->name('home')->middleware('auth');

// Registration routes
Route::get('/register', [App\Http\Controllers\Auth\RegistrationController::class, 'index'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegistrationController::class, 'store'])->name('register.store');

// Applicant Dashboard
Route::middleware(['auth', 'role:pendaftar'])->prefix('pendaftar')->name('applicant.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Applicant\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard', [App\Http\Controllers\Applicant\DashboardController::class, 'update'])->name('dashboard.update');
    Route::post('/select-pathway', [App\Http\Controllers\Applicant\DashboardController::class, 'selectPathway'])->name('select-pathway');
    
    // Biodata
    Route::get('/biodata', [App\Http\Controllers\Applicant\BiodataController::class, 'edit'])->name('biodata.edit');
    Route::post('/biodata', [App\Http\Controllers\Applicant\BiodataController::class, 'update'])->name('biodata.update');
    
    // Multi-step Registration
    Route::get('/registration/step/{step}', [App\Http\Controllers\Applicant\RegistrationStepController::class, 'show'])->name('registration.step');
    Route::post('/registration/step/{step}', [App\Http\Controllers\Applicant\RegistrationStepController::class, 'save'])->name('registration.save');
    Route::post('/registration/submit', [App\Http\Controllers\Applicant\RegistrationStepController::class, 'submit'])->name('registration.submit');
    
    // Registration Card
    Route::get('/registration-card', [App\Http\Controllers\Applicant\RegistrationCardController::class, 'show'])->name('registration-card.show');
    Route::get('/registration-card/download', [App\Http\Controllers\Applicant\RegistrationCardController::class, 'download'])->name('registration-card.download');
    Route::get('/registration-card/download-exam', [App\Http\Controllers\Applicant\RegistrationCardController::class, 'downloadExamCard'])->name('registration-card.download-exam');
});

// Super Admin routes
Route::prefix('super-admin')->name('super-admin.')->middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Roles
    Route::resource('roles', RoleController::class);
    Route::get('/roles/{role}/assign-permissions', [RoleController::class, 'assignPermissions'])->name('roles.assign-permissions');
    Route::post('/roles/{role}/sync-permissions', [RoleController::class, 'syncPermissions'])->name('roles.sync-permissions');
    
    // Users
    Route::resource('users', UserController::class);
    Route::post('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
    Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    
    // System Configuration
    Route::get('/config', [SystemConfigController::class, 'index'])->name('config.index');
    Route::post('/config', [SystemConfigController::class, 'update'])->name('config.update');
    
    // Activity Logs
    Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs.index');
});

// Admin Sekolah routes
Route::prefix('admin-sekolah')->name('admin-sekolah.')
    ->middleware(['auth', 'role:admin_sekolah'])->group(function () {
    
    Route::get('/dashboard', [App\Http\Controllers\AdminSekolah\DashboardController::class, 'index'])
        ->name('dashboard');
    
    // Applicants
    Route::get('/applicants', [App\Http\Controllers\AdminSekolah\ApplicantController::class, 'index'])
        ->name('applicants.index');
    Route::get('/applicants/{applicant}', [App\Http\Controllers\AdminSekolah\ApplicantController::class, 'show'])
        ->name('applicants.show');
    
    // PPDB Pathways
    Route::resource('pathways', App\Http\Controllers\AdminSekolah\PpdbPathwayController::class);

    // Schedules
    Route::resource('schedules', App\Http\Controllers\AdminSekolah\PpdbScheduleController::class)
        ->only(['index', 'store', 'update', 'destroy']);

    // Announcements
    Route::resource('announcements', App\Http\Controllers\AdminSekolah\AnnouncementController::class)
        ->only(['index', 'create', 'store', 'destroy']);

    // Reports
    Route::get('/reports', [App\Http\Controllers\AdminSekolah\ReportController::class, 'index'])
        ->name('reports.index');
    Route::get('/reports/export-excel', [App\Http\Controllers\AdminSekolah\ReportController::class, 'exportExcel'])
        ->name('reports.export-excel');
    Route::get('/reports/export-csv', [App\Http\Controllers\AdminSekolah\ReportController::class, 'exportCSV'])
        ->name('reports.export-csv');
    Route::get('/reports/export-pdf', [App\Http\Controllers\AdminSekolah\ReportController::class, 'exportPDF'])
        ->name('reports.export-pdf');
});

// Verifikator routes
Route::prefix('verifikator')->name('verifikator.')
    ->middleware(['auth', 'role:verifikator'])->group(function () {
    
    Route::get('/dashboard', [App\Http\Controllers\Verifikator\DashboardController::class, 'index'])
        ->name('dashboard');
    
    // Verification
    Route::get('/verification', [App\Http\Controllers\Verifikator\VerificationController::class, 'index'])
        ->name('verification.index');
    Route::get('/history', [App\Http\Controllers\Verifikator\VerificationController::class, 'history'])
        ->name('verification.history');
    Route::get('/verification/{applicant}', [App\Http\Controllers\Verifikator\VerificationController::class, 'show'])
        ->name('verification.show');
    
    // Actions
    Route::post('/verification/{applicant}/approve', [App\Http\Controllers\Verifikator\VerificationController::class, 'approve'])
        ->name('verification.approve');
    Route::post('/verification/{applicant}/reject', [App\Http\Controllers\Verifikator\VerificationController::class, 'reject'])
        ->name('verification.reject');
    
    // QR Scan
    Route::get('/scan', [App\Http\Controllers\Verifikator\VerificationController::class, 'scan'])
        ->name('verification.scan');
    Route::get('/verify/{token}', [App\Http\Controllers\Verifikator\VerificationController::class, 'verifyByToken'])
        ->name('verification.by-token');
});

// Public Verification Route (from QR Code)
Route::get('/verifikasi/{token}', [App\Http\Controllers\PublicVerificationController::class, 'redirect'])
    ->name('public.verify');    
    Route::get('/viewer/dashboard', function () {
        return 'Viewer Dashboard - Coming Soon';
    });
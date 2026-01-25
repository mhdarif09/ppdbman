<?php

/**
 * RBAC Usage Examples for PPDB Laravel
 * 
 * These example routes demonstrate how to use the role and permission
 * middleware to protect your routes. You can copy these patterns into
 * your actual routes files (web.php or api.php).
 * 
 * DO NOT include this file directly in your application.
 * This is for reference purposes only.
 */

use Illuminate\Support\Facades\Route;

// ============================================================================
// SUPER ADMIN ROUTES
// ============================================================================

Route::middleware(['auth', 'role:super_admin'])->prefix('admin')->group(function () {
    // User Management
    Route::get('/users', function () {
        return 'Manage all users';
    })->name('admin.users.index');

    // Role & Permission Management
    Route::get('/roles', function () {
        return 'Manage roles';
    })->name('admin.roles.index');
    
    Route::get('/permissions', function () {
        return 'Manage permissions';
    })->name('admin.permissions.index');

    // System Logs
    Route::get('/logs', function () {
        return 'View system logs';
    })->name('admin.logs.index');
});

// ============================================================================
// ADMIN SEKOLAH ROUTES
// ============================================================================

Route::middleware(['auth', 'role:admin_sekolah,super_admin'])->prefix('sekolah')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return 'School admin dashboard';
    })->name('sekolah.dashboard');

    // Applicant Management
    Route::middleware('permission:view-applicants')->group(function () {
        Route::get('/applicants', function () {
            return 'View all applicants';
        })->name('sekolah.applicants.index');
    });

    Route::middleware('permission:edit-applicants')->group(function () {
        Route::get('/applicants/{id}/edit', function ($id) {
            return 'Edit applicant ' . $id;
        })->name('sekolah.applicants.edit');
    });

    // PPDB Configuration
    Route::middleware('permission:manage-quotas')->group(function () {
        Route::get('/quotas', function () {
            return 'Manage quotas';
        })->name('sekolah.quotas.index');
    });

    Route::middleware('permission:manage-schedules')->group(function () {
        Route::get('/schedules', function () {
            return 'Manage PPDB schedules';
        })->name('sekolah.schedules.index');
    });

    // Announcements
    Route::middleware('permission:publish-announcements')->group(function () {
        Route::get('/announcements/create', function () {
            return 'Create announcement';
        })->name('sekolah.announcements.create');
    });

    // Reports
    Route::middleware('permission:export-reports')->group(function () {
        Route::get('/reports/export', function () {
            return 'Export reports';
        })->name('sekolah.reports.export');
    });
});

// ============================================================================
// VERIFIKATOR ROUTES
// ============================================================================

Route::middleware(['auth', 'role:verifikator'])->prefix('verifikasi')->group(function () {
    // View applicants
    Route::middleware('permission:view-applicants')->group(function () {
        Route::get('/applicants', function () {
            return 'Applicants list for verification';
        })->name('verifikasi.applicants.index');
    });

    // Verification actions
    Route::middleware('permission:verify-applicants')->group(function () {
        Route::post('/applicants/{id}/verify', function ($id) {
            return 'Verify applicant ' . $id;
        })->name('verifikasi.applicants.verify');
    });

    Route::middleware('permission:reject-applicants')->group(function () {
        Route::post('/applicants/{id}/reject', function ($id) {
            return 'Reject applicant ' . $id;
        })->name('verifikasi.applicants.reject');
    });

    Route::middleware('permission:add-verification-notes')->group(function () {
        Route::post('/applicants/{id}/notes', function ($id) {
            return 'Add notes to applicant ' . $id;
        })->name('verifikasi.applicants.notes');
    });
});

// ============================================================================
// PENDAFTAR (APPLICANT) ROUTES
// ============================================================================

Route::middleware(['auth', 'role:pendaftar'])->prefix('pendaftaran')->group(function () {
    // Application submission
    Route::middleware('permission:submit-application')->group(function () {
        Route::get('/apply', function () {
            return 'Application form';
        })->name('pendaftaran.apply');
        
        Route::post('/apply', function () {
            return 'Submit application';
        })->name('pendaftaran.apply.submit');
    });

    // Edit own application
    Route::middleware('permission:edit-own-application')->group(function () {
        Route::get('/application/edit', function () {
            return 'Edit my application';
        })->name('pendaftaran.application.edit');
    });

    // Upload documents
    Route::middleware('permission:upload-documents')->group(function () {
        Route::post('/documents/upload', function () {
            return 'Upload documents';
        })->name('pendaftaran.documents.upload');
    });

    // View results
    Route::middleware('permission:view-own-results')->group(function () {
        Route::get('/results', function () {
            return 'View my selection results';
        })->name('pendaftaran.results');
    });

    // Print registration
    Route::middleware('permission:print-registration')->group(function () {
        Route::get('/registration/print', function () {
            return 'Print registration proof';
        })->name('pendaftaran.registration.print');
    });
});

// ============================================================================
// VIEWER ROUTES (Read-only)
// ============================================================================

Route::middleware(['auth', 'role:viewer'])->prefix('viewer')->group(function () {
    // Dashboard (read-only)
    Route::middleware('permission:view-dashboard')->group(function () {
        Route::get('/dashboard', function () {
            return 'Viewer dashboard';
        })->name('viewer.dashboard');
    });

    // Statistics
    Route::middleware('permission:view-statistics')->group(function () {
        Route::get('/statistics', function () {
            return 'View statistics';
        })->name('viewer.statistics');
    });

    // Reports (view only)
    Route::middleware('permission:view-reports')->group(function () {
        Route::get('/reports', function () {
            return 'View reports';
        })->name('viewer.reports');
    });
});

// ============================================================================
// ALTERNATIVE: Using multiple roles (OR logic)
// ============================================================================

// Allow both admin_sekolah AND super_admin to access
Route::middleware(['auth', 'role:admin_sekolah,super_admin'])->group(function () {
    Route::get('/shared-admin-route', function () {
        return 'Available to both admin_sekolah and super_admin';
    });
});

// ============================================================================
// ALTERNATIVE: Using permissions instead of roles (more flexible)
// ============================================================================

// Anyone with the permission can access, regardless of role
Route::middleware(['auth', 'permission:view-applicants'])->group(function () {
    Route::get('/applicants/all', function () {
        return 'View applicants (permission-based)';
    });
});

// Multiple permissions (user needs ANY of them)
Route::middleware(['auth', 'permission:verify-applicants,reject-applicants'])->group(function () {
    Route::get('/verification-panel', function () {
        return 'Verification panel';
    });
});

// ============================================================================
// BLADE TEMPLATE USAGE EXAMPLES
// ============================================================================

/*
In your Blade templates, you can use:

1. Check if user has specific role:
   @role('admin_sekolah')
       <p>This is only visible to Admin Sekolah</p>
   @endrole

2. Check if user has any role:
   @if(auth()->user()->hasAnyRole(['admin_sekolah', 'super_admin']))
       <p>Admin area</p>
   @endif

3. Check if user has permission:
   @can('verify-applicants')
       <button>Verify</button>
   @endcan

   Or:
   @if(auth()->user()->hasPermission('verify-applicants'))
       <button>Verify</button>
   @endif

4. Multiple permissions:
   @if(auth()->user()->hasAnyPermission(['verify-applicants', 'reject-applicants']))
       <div>Verification tools</div>
   @endif
*/

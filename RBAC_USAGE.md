# RBAC Usage Guide - PPDB Laravel

Panduan lengkap penggunaan sistem Role-Based Access Control (RBAC) untuk aplikasi PPDB Laravel.

## Daftar Isi
- [Arsitektur Sistem](#arsitektur-sistem)
- [Penjelasan Role](#penjelasan-role)
- [Cara Menggunakan di Kode](#cara-menggunakan-di-kode)
- [Blade Template Directives](#blade-template-directives)
- [Best Practices](#best-practices)
- [Multi-Year Academic Period](#multi-year-academic-period)

---

## Arsitektur Sistem

### Database Schema

```
users
  ├─ roles (many-to-many via role_user)
  │
roles
  ├─ permissions (many-to-many via permission_role)
  │
permissions
```

**Tabel Utama:**
- `users`: Data pengguna sistem
- `roles`: Definisi peran (super_admin, admin_sekolah, dll)
- `permissions`: Hak akses granular (verify-applicants, manage-users, dll)
- `role_user`: Pivot table untuk relasi user-role
- `permission_role`: Pivot table untuk relasi role-permission

---

## Penjelasan Role

### 1. Super Admin
**Slug:** `super_admin`

**Tanggung Jawab:**
- Mengelola seluruh sistem
- CRUD role dan permission
- Mengelola akun Admin Sekolah dan Verifikator
- Konfigurasi tahun ajaran dan setting global
- Akses penuh ke semua fitur dan log sistem

**Permissions:** Semua permission (26 permissions)

---

### 2. Admin Sekolah
**Slug:** `admin_sekolah`

**Tanggung Jawab:**
- Mengelola data pendaftar
- Mengatur kuota dan jalur PPDB
- Mengelola jadwal PPDB
- Mempublikasikan pengumuman
- Melihat dan mengekspor laporan
- Mengakses dashboard statistik

**Permissions:**
- `manage-users`, `view-users`
- `view-applicants`, `edit-applicants`, `delete-applicants`
- `manage-quotas`, `manage-schedules`, `manage-academic-years`
- `publish-announcements`, `edit-announcements`
- `view-reports`, `export-reports`
- `view-dashboard`, `view-statistics`
- `submit-application`, `edit-own-application`, `upload-documents`
- `view-own-results`, `print-registration`

**Tidak memiliki:** `manage-roles`, `manage-permissions`, `verify-applicants`, `reject-applicants`, `add-verification-notes`, `view-system-logs`

---

### 3. Verifikator
**Slug:** `verifikator`

**Tanggung Jawab:**
- Memverifikasi data dan berkas pendaftar
- Menyetujui atau menolak pendaftaran
- Memberikan catatan perbaikan
- Tidak dapat mengatur kuota, jadwal, atau pengumuman

**Permissions:**
- `view-applicants`
- `verify-applicants`
- `reject-applicants`
- `add-verification-notes`
- `view-dashboard`
- `view-statistics`
- `view-reports`

---

### 4. Pendaftar
**Slug:** `pendaftar`

**Tanggung Jawab:**
- Registrasi akun
- Mengisi dan mengirim formulir PPDB
- Mengunggah dokumen
- Melihat status verifikasi dan hasil seleksi
- Mencetak bukti pendaftaran

**Permissions:**
- `submit-application`
- `edit-own-application`
- `upload-documents`
- `view-own-results`
- `print-registration`

---

### 5. Viewer (Kepala Sekolah / Pengawas)
**Slug:** `viewer`

**Tanggung Jawab:**
- Melihat dashboard dan laporan
- Akses read-only
- Tidak dapat mengubah data apa pun

**Permissions:**
- `view-users`
- `view-applicants`
- `view-dashboard`
- `view-statistics`
- `view-reports`

---

## Cara Menggunakan di Kode

### 1. Assign Role ke User

```php
use App\Models\User;
use App\Models\Role;

// Cara 1: Menggunakan string role name
$user = User::find(1);
$user->assignRole('admin_sekolah');

// Cara 2: Menggunakan model Role
$role = Role::where('name', 'verifikator')->first();
$user->assignRole($role);

// Cara 3: Assign multiple roles sekaligus
$user->assignRole(['pendaftar', 'viewer']);
```

### 2. Remove Role dari User

```php
$user = User::find(1);
$user->removeRole('pendaftar');
```

### 3. Sync Roles (Replace all roles)

```php
$user = User::find(1);
// Hapus semua role lama, assign yang baru
$user->syncRoles(['admin_sekolah']);
```

### 4. Check User Role

```php
$user = auth()->user();

// Check single role
if ($user->hasRole('admin_sekolah')) {
    // User adalah admin sekolah
}

// Check any role (OR logic)
if ($user->hasAnyRole(['admin_sekolah', 'super_admin'])) {
    // User adalah admin sekolah ATAU super admin
}

// Check all roles (AND logic)
if ($user->hasAllRoles(['pendaftar', 'viewer'])) {
    // User memiliki KEDUA role
}
```

### 5. Check User Permission

```php
$user = auth()->user();

// Check single permission
if ($user->hasPermission('verify-applicants')) {
    // User boleh verify applicants
}

// Check any permission (OR logic)
if ($user->hasAnyPermission(['verify-applicants', 'reject-applicants'])) {
    // User punya salah satu permission
}

// Check all permissions (AND logic)
if ($user->hasAllPermissions(['view-applicants', 'verify-applicants'])) {
    // User punya semua permission
}
```

### 6. Get User Roles & Permissions

```php
$user = auth()->user();

// Get collection of role names
$roleNames = $user->getRoleNames();
// Output: Collection(['admin_sekolah'])

// Get collection of permission names
$permissionNames = $user->getPermissionNames();
// Output: Collection(['view-applicants', 'edit-applicants', ...])
```

---

## Route Protection

### A. Menggunakan Role Middleware

```php
// routes/web.php

// Single role
Route::middleware(['auth', 'role:admin_sekolah'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});

// Multiple roles (OR logic - user hanya perlu salah satu)
Route::middleware(['auth', 'role:admin_sekolah,super_admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index']);
});
```

### B. Menggunakan Permission Middleware

```php
// routes/web.php

// Single permission
Route::middleware(['auth', 'permission:verify-applicants'])->group(function () {
    Route::post('/applicants/{id}/verify', [ApplicantController::class, 'verify']);
});

// Multiple permissions (OR logic)
Route::middleware(['auth', 'permission:verify-applicants,reject-applicants'])->group(function () {
    Route::get('/verification', [VerificationController::class, 'index']);
});
```

### C. Kombinasi Middleware

```php
Route::middleware(['auth', 'role:verifikator', 'permission:verify-applicants'])->group(function () {
    // User harus punya role 'verifikator' DAN permission 'verify-applicants'
    Route::post('/verify/{id}', [VerificationController::class, 'verify']);
});
```

---

## Controller Usage

### A. Manual Permission Check

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function verify($id)
    {
        // Check permission
        if (!auth()->user()->hasPermission('verify-applicants')) {
            abort(403, 'Unauthorized action.');
        }

        // Proceed with verification
        // ...
    }
}
```

### B. Using Policies (Recommended)

```php
namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function verify($id)
    {
        $applicant = Applicant::findOrFail($id);
        
        // Using authorize() method
        $this->authorize('verify', $applicant);

        // Or using Gate facade
        if (Gate::denies('verify', $applicant)) {
            abort(403);
        }

        // Verification logic
        // ...
    }
}
```

**Note:** Pastikan policy sudah terdaftar di `AuthServiceProvider`.

---

## Blade Template Directives

### 1. Check Role

```blade
@if(auth()->check() && auth()->user()->hasRole('admin_sekolah'))
    <a href="/admin/users">Manage Users</a>
@endif

{{-- Multiple roles --}}
@if(auth()->check() && auth()->user()->hasAnyRole(['admin_sekolah', 'super_admin']))
    <div class="admin-panel">Admin Area</div>
@endif
```

### 2. Check Permission

```blade
@if(auth()->check() && auth()->user()->hasPermission('verify-applicants'))
    <button class="btn-verify">Verify</button>
@endif

{{-- Using @can directive (requires policy) --}}
@can('verify', $applicant)
    <button class="btn-verify">Verify</button>
@endcan
```

### 3. Custom Blade Directives (Optional Enhancement)

Anda dapat membuat custom directive untuk kemudahan:

```php
// app/Providers/AppServiceProvider.php

use Illuminate\Support\Facades\Blade;

public function boot()
{
    // @role directive
    Blade::if('role', function ($role) {
        return auth()->check() && auth()->user()->hasRole($role);
    });

    // @permission directive
    Blade::if('permission', function ($permission) {
        return auth()->check() && auth()->user()->hasPermission($permission);
    });
}
```

Lalu gunakan di template:

```blade
@role('admin_sekolah')
    <p>Hello Admin Sekolah</p>
@endrole

@permission('verify-applicants')
    <button>Verify</button>
@endpermission
```

---

## Best Practices

### 1. Gunakan Permission, Bukan Role di Logic Bisnis

❌ **Buruk:**
```php
if ($user->hasRole('admin_sekolah')) {
    // Logic
}
```

✅ **Baik:**
```php
if ($user->hasPermission('edit-applicants')) {
    // Logic
}
```

**Alasan:** Permission lebih fleksibel. Jika suatu hari ada role baru yang juga boleh edit applicants, Anda tidak perlu ubah kode.

### 2. Middleware di Route, Bukan di Controller

❌ **Buruk:**
```php
public function index()
{
    if (!auth()->user()->hasRole('admin')) {
        abort(403);
    }
    // ...
}
```

✅ **Baik:**
```php
// routes/web.php
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
});
```

### 3. Gunakan Policy untuk Authorization Logic yang Kompleks

Jika authorization logic melibatkan model tertentu (contoh: user hanya bisa edit aplikasinya sendiri), gunakan Policy:

```php
// app/Policies/ApplicantPolicy.php
public function update(User $user, Applicant $applicant)
{
    // Admin sekolah bisa edit semua applicant
    if ($user->hasPermission('edit-applicants')) {
        return true;
    }

    // Pendaftar hanya bisa edit aplikasinya sendiri
    if ($user->hasPermission('edit-own-application')) {
        return $applicant->user_id === $user->id && !$applicant->is_verified;
    }

    return false;
}
```

### 4. Seed Data untuk Development & Production

Gunakan seeder dengan environment check:

```php
public function run()
{
    // Roles dan permissions: selalu seed
    $this->call([
        RolesTableSeeder::class,
        PermissionsTableSeeder::class,
        RolePermissionSeeder::class,
    ]);

    // Test users: hanya di development
    if (app()->environment('local')) {
        $this->call(TestUsersSeeder::class);
    }
}
```

### 5. Jangan Hardcode Role ID

❌ **Buruk:**
```php
$user->roles()->attach(1); // Hardcoded ID
```

✅ **Baik:**
```php
$user->assignRole('admin_sekolah'); // Menggunakan slug
```

---

## Multi-Year Academic Period

Untuk mendukung multi tahun ajaran, tambahkan foreign key `academic_year_id` pada tabel yang relevan:

### 1. Tambahkan Tabel Academic Years

```php
// Migration
Schema::create('academic_years', function (Blueprint $table) {
    $table->id();
    $table->string('name'); // "2024/2025"
    $table->date('start_date');
    $table->date('end_date');
    $table->boolean('is_active')->default(false);
    $table->timestamps();
});
```

### 2. Tambahkan Relasi di Model User

```php
// app/Models/User.php
public function academicYear()
{
    return $this->belongsTo(AcademicYear::class);
}
```

### 3. Filter Data Berdasarkan Academic Year

```php
// Get only applicants for active academic year
$activeYear = AcademicYear::where('is_active', true)->first();
$applicants = Applicant::where('academic_year_id', $activeYear->id)->get();
```

### 4. Middleware untuk Auto-Filter Academic Year (Optional)

```php
// app/Http/Middleware/SetActiveAcademicYear.php
public function handle($request, Closure $next)
{
    $activeYear = AcademicYear::where('is_active', true)->first();
    
    if ($activeYear) {
        $request->merge(['academic_year_id' => $activeYear->id]);
        view()->share('activeAcademicYear', $activeYear);
    }
    
    return $next($request);
}
```

---

## Troubleshooting

### Error: "Call to undefined method hasRole()"

**Penyebab:** Trait `HasRoles` belum ditambahkan ke User model.

**Solusi:**
```php
// app/Models/User.php
use App\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
}
```

### Error: "SQLSTATE[42S02]: Base table or file not found: roles"

**Penyebab:** Migration belum dijalankan.

**Solusi:**
```bash
php artisan migrate
php artisan db:seed
```

### Permissions Tidak Berfungsi

**Penyebab:** Role-permission assignment belum di-seed.

**Solusi:**
```bash
php artisan db:seed --class=RolePermissionSeeder
```

### User Login Tapi Tetap Redirect ke Login Page

**Penyebab:** Middleware 'auth' mungkin tidak terpasang atau session tidak bekerja.

**Solusi:**
1. Pastikan middleware 'auth' ada di route
2. Check session configuration di `.env`
3. Clear cache: `php artisan cache:clear && php artisan config:clear`

---

## Testing Commands

### Run Migrations & Seeders

```bash
cd c:\Users\10\Documents\ppdb
php artisan migrate:fresh --seed
```

### Test via Tinker

```bash
php artisan tinker
```

```php
// Get test user
$user = User::where('email', 'adminsekolah@ppdb.test')->first();

// Check roles
$user->getRoleNames(); // Collection(['admin_sekolah'])

// Check permissions
$user->hasPermission('verify-applicants'); // false
$user->hasPermission('edit-applicants'); // true

// Get all permissions
$user->getPermissionNames();
```

---

## Summary

Sistem RBAC ini menggunakan pendekatan:
- ✅ **Database-based**: Roles dan permissions disimpan di database
- ✅ **Scalable**: Mudah tambah role atau permission baru
- ✅ **Flexible**: Middleware, policy, dan manual check tersedia
- ✅ **Professional**: Tidak ada hardcoded role di business logic
- ✅ **Secure**: Least privilege principle diterapkan
- ✅ **Clean**: Separation of concerns antara role, permission, dan user

File referensi lengkap ada di `routes/rbac_examples.php`.

<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    protected $activityLogger;

    public function __construct(ActivityLogger $activityLogger)
    {
        $this->middleware(['auth', 'role:super_admin']);
        $this->activityLogger = $activityLogger;
    }

    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $query = User::with('roles');

        // Filter by role
        if ($request->filled('role')) {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(15);
        
        // Get roles for filter dropdown (only admin_sekolah and verifikator)
        $roles = Role::whereIn('name', ['admin_sekolah', 'verifikator'])->get();

        return view('super-admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::whereIn('name', ['admin_sekolah', 'verifikator'])->get();
        return view('super-admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'exists:roles,name', Rule::in(['admin_sekolah', 'verifikator'])],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_active' => true,
        ]);

        $user->assignRole($validated['role']);

        $this->activityLogger->logCreated($user);

        return redirect()
            ->route('super-admin.users.index')
            ->with('success', 'User berhasil dibuat.');
    }

    /**
     * Show the form for editing the user.
     */
    public function edit(User $user)
    {
        $roles = Role::whereIn('name', ['admin_sekolah', 'verifikator'])->get();
        $userRole = $user->roles->first();
        
        return view('super-admin.users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'exists:roles,name', Rule::in(['admin_sekolah', 'verifikator'])],
        ]);

        $oldValues = $user->getOriginal();
        
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Update role
        $user->syncRoles([$validated['role']]);

        $this->activityLogger->logUpdated($user, $oldValues);

        return redirect()
            ->route('super-admin.users.index')
            ->with('success', 'User berhasil diupdate.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        // Prevent deleting super_admin
        if ($user->hasRole('super_admin')) {
            return back()->with('error', 'Super Admin tidak bisa dihapus.');
        }

        $this->activityLogger->logDeleted($user);
        $user->delete();

        return redirect()
            ->route('super-admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    /**
     * Toggle user active status.
     */
    public function toggleActive(User $user)
    {
        // Prevent deactivating super_admin
        if ($user->hasRole('super_admin')) {
            return back()->with('error', 'Super Admin tidak bisa dinonaktifkan.');
        }

        $oldStatus = $user->is_active;
        $user->update(['is_active' => !$user->is_active]);

        $action = $user->is_active ? 'activated' : 'deactivated';
        $this->activityLogger->log($action, $user);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "User berhasil {$status}.");
    }

    /**
     * Reset user password.
     */
    public function resetPassword(User $user)
    {
        // Prevent resetting super_admin password
        if ($user->hasRole('super_admin')) {
            return back()->with('error', 'Password Super Admin tidak bisa direset.');
        }

        $newPassword = 'password'; // Default password
        $user->update(['password' => Hash::make($newPassword)]);

        $this->activityLogger->log('password_reset', $user);

        return back()->with('success', "Password user berhasil direset ke: {$newPassword}");
    }
}

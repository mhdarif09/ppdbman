<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    protected $activityLogger;

    public function __construct(ActivityLogger $activityLogger)
    {
        $this->middleware(['auth', 'role:super_admin']);
        $this->activityLogger = $activityLogger;
    }

    /**
     * Display a listing of roles.
     */
    public function index(Request $request)
    {
        $query = Role::withCount('users');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('display_name', 'like', "%{$search}%");
            });
        }

        $roles = $query->paginate(10);

        return view('super-admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        return view('super-admin.roles.create');
    }

    /**
     * Store a newly created role.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name', 'regex:/^[a-z_]+$/'],
            'display_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ], [
            'name.regex' => 'Name harus lowercase dan hanya boleh mengandung huruf dan underscore (_)',
        ]);

        $role = Role::create($validated);

        $this->activityLogger->logCreated($role);

        return redirect()
            ->route('super-admin.roles.index')
            ->with('success', 'Role berhasil dibuat.');
    }

    /**
     * Show the form for editing the role.
     */
    public function edit(Role $role)
    {
        return view('super-admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified role.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($role->id), 'regex:/^[a-z_]+$/'],
            'display_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ], [
            'name.regex' => 'Name harus lowercase dan hanya boleh mengandung huruf dan underscore (_)',
        ]);

        $oldValues = $role->getOriginal();
        $role->update($validated);

        $this->activityLogger->logUpdated($role, $oldValues);

        return redirect()
            ->route('super-admin.roles.index')
            ->with('success', 'Role berhasil diupdate.');
    }

    /**
     * Remove the specified role.
     */
    public function destroy(Role $role)
    {
        // Prevent deleting if role has users
        if ($role->users()->count() > 0) {
            return back()->with('error', 'Role tidak bisa dihapus karena masih memiliki user.');
        }

        $this->activityLogger->logDeleted($role);
        $role->delete();

        return redirect()
            ->route('super-admin.roles.index')
            ->with('success', 'Role berhasil dihapus.');
    }

    /**
     * Show the form for assigning permissions to role.
     */
    public function assignPermissions(Role $role)
    {
        $permissions = Permission::all()->groupBy(function($permission) {
            // Group permissions by first word (e.g., "manage", "view", "edit")
            $words = explode('-', $permission->name);
            return $words[0] ?? 'other';
        });

        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('super-admin.roles.assign-permissions', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Sync permissions to role.
     */
    public function syncPermissions(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $permissionIds = $validated['permissions'] ?? [];
        
        $oldPermissions = $role->permissions->pluck('name')->toArray();
        $role->permissions()->sync($permissionIds);
        $newPermissions = $role->fresh()->permissions->pluck('name')->toArray();

        $this->activityLogger->log(
            'assigned_permission',
            $role,
            ['permissions' => $oldPermissions],
            ['permissions' => $newPermissions]
        );

        return redirect()
            ->route('super-admin.roles.index')
            ->with('success', 'Permission berhasil disinkronkan.');
    }
}

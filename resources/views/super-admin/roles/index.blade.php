@extends('layouts.admin')

@section('title', 'Manajemen Role')
@section('page-title', 'Manajemen Role')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Daftar Role</h2>
            <p class="text-gray-600 mt-1">Kelola role dan permission sistem</p>
        </div>
        <a href="{{ route('super-admin.roles.create') }}" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Tambah Role
        </a>
    </div>

    <!-- Search -->
    <div class="card">
        <form method="GET" action="{{ route('super-admin.roles.index') }}" class="flex gap-4">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}"
                placeholder="Cari role..."
                class="form-input flex-1"
            >
            <button type="submit" class="btn btn-secondary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('super-admin.roles.index') }}" class="btn btn-secondary">Reset</a>
            @endif
        </form>
    </div>

    <!-- Roles Table -->
    <div class="card overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Display Name</th>
                        <th>Users</th>
                        <th>Deskripsi</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td>
                                <code class="px-2 py-1 bg-gray-100 rounded text-sm">{{ $role->name }}</code>
                            </td>
                            <td class="font-medium">{{ $role->display_name }}</td>
                            <td>
                                <span class="badge badge-info">{{ $role->users_count }} users</span>
                            </td>
                            <td class="text-sm text-gray-600">{{ Str::limit($role->description, 50) }}</td>
                            <td>
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('super-admin.roles.assign-permissions', $role) }}" 
                                       class="btn btn-sm btn-secondary"
                                       title="Assign Permissions">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('super-admin.roles.edit', $role) }}" 
                                       class="btn btn-sm btn-secondary">
                                        Edit
                                    </a>
                                    <form action="{{ route('super-admin.roles.destroy', $role) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Yakin ingin menghapus role ini?')"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-500">
                                Tidak ada data role
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($roles->hasPages())
        <div class="flex justify-center">
            {{ $roles->links() }}
        </div>
    @endif
</div>
@endsection

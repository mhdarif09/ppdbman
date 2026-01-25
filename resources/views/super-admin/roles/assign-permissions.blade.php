@extends('layouts.admin')

@section('title', 'Assign Permissions')
@section('page-title', 'Assign Permissions ke Role')

@section('content')
<div class="max-w-4xl">
    <div class="card mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">{{ $role->display_name }}</h3>
                <p class="text-sm text-gray-600">{{ $role->description }}</p>
            </div>
            <code class="px-3 py-1 bg-gray-100 rounded text-sm">{{ $role->name }}</code>
        </div>
    </div>

    <div class="card">
        <form action="{{ route('super-admin.roles.sync-permissions', $role) }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- Select All -->
                <div class="flex items-center justify-between pb-4 border-b">
                    <h4 class="font-medium text-gray-900">Pilih Permissions</h4>
                    <div class="flex gap-2">
                        <button type="button" onclick="selectAll()" class="btn btn-sm btn-secondary">
                            Select All
                        </button>
                        <button type="button" onclick="deselectAll()" class="btn btn-sm btn-secondary">
                            Deselect All
                        </button>
                    </div>
                </div>

                <!-- Permissions by Group -->
                @foreach($permissions as $group => $groupPermissions)
                    <div>
                        <h5 class="font-medium text-gray-700 mb-3 capitalize">{{ str_replace('-', ' ', $group) }}</h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($groupPermissions as $permission)
                                <label class="flex items-start space-x-3 p-3 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer">
                                    <input 
                                        type="checkbox" 
                                        name="permissions[]" 
                                        value="{{ $permission->id }}"
                                        {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                                        class="permission-checkbox mt-1 w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                                    >
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">{{ $permission->display_name }}</p>
                                        <p class="text-xs text-gray-500">{{ $permission->name }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <!-- Actions -->
                <div class="flex gap-3 pt-4 border-t">
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Permissions
                    </button>
                    <a href="{{ route('super-admin.roles.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function selectAll() {
        document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = true);
    }
    
    function deselectAll() {
        document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = false);
    }
</script>
@endsection

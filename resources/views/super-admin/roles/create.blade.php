@extends('layouts.admin')

@section('title', 'Tambah Role')
@section('page-title', 'Tambah Role Baru')

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <form action="{{ route('super-admin.roles.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- Name -->
                <div>
                    <label for="name" class="form-label">
                        Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        class="form-input @error('name') border-red-500 @enderror"
                        placeholder="admin_sekolah"
                        required
                    >
                    <p class="text-sm text-gray-500 mt-1">Format: lowercase, gunakan underscore (_)</p>
                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Display Name -->
                <div>
                    <label for="display_name" class="form-label">
                        Display Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="display_name" 
                        name="display_name" 
                        value="{{ old('display_name') }}"
                        class="form-input @error('display_name') border-red-500 @enderror"
                        placeholder="Admin Sekolah"
                        required
                    >
                    @error('display_name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="form-label">
                        Deskripsi
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="4"
                        class="form-input @error('description') border-red-500 @enderror"
                        placeholder="Deskripsi role..."
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex gap-3 pt-4">
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan
                    </button>
                    <a href="{{ route('super-admin.roles.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.admin-sekolah')

@section('title', 'Tambah Jalur')
@section('page-title', 'Tambah Jalur PPDB')

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <form action="{{ route('admin-sekolah.pathways.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- Name -->
                <div>
                    <label for="name" class="form-label">
                        Nama Jalur <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        class="form-input @error('name') border-red-500 @enderror"
                        placeholder="Contoh: Zonasi, Prestasi, dll"
                        required
                    >
                    @error('name')
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
                        rows="3"
                        class="form-input @error('description') border-red-500 @enderror"
                        placeholder="Keterangan singkat mengenai jalur ini"
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quota -->
                <div>
                    <label for="quota" class="form-label">
                        Kuota Penerimaan <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="quota" 
                        name="quota" 
                        value="{{ old('quota', 0) }}"
                        min="1"
                        class="form-input @error('quota') border-red-500 @enderror"
                        required
                    >
                    <p class="text-sm text-gray-500 mt-1">Jumlah maksimal siswa yang diterima di jalur ini</p>
                    @error('quota')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        id="is_active" 
                        name="is_active" 
                        value="1"
                        class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                        {{ old('is_active', true) ? 'checked' : '' }}
                    >
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Aktifkan Jalur ini
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex gap-3 pt-4 border-t">
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Jalur
                    </button>
                    <a href="{{ route('admin-sekolah.pathways.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

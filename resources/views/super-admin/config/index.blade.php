@extends('layouts.admin')

@section('title', 'Konfigurasi Sistem')
@section('page-title', 'Konfigurasi Sistem')

@section('content')
<div class="max-w-3xl">
    <div class="card">
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Pengaturan PPDB</h3>
            <p class="text-sm text-gray-600 mt-1">Kelola konfigurasi global sistem PPDB</p>
        </div>

        <form action="{{ route('super-admin.config.update') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- School Name -->
                <div>
                    <label for="school_name" class="form-label">
                        Nama Sekolah <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="school_name" 
                        name="school_name" 
                        value="{{ old('school_name', $settings['school_name']) }}"
                        class="form-input @error('school_name') border-red-500 @enderror"
                        required
                    >
                    @error('school_name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Academic Year -->
                <div>
                    <label for="academic_year_active" class="form-label">
                        Tahun Ajaran Aktif <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="academic_year_active" 
                        name="academic_year_active" 
                        value="{{ old('academic_year_active', $settings['academic_year_active']) }}"
                        class="form-input @error('academic_year_active') border-red-500 @enderror"
                        placeholder="2024/2025"
                        required
                    >
                    @error('academic_year_active')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PPDB Status -->
                <div>
                    <label for="ppdb_status" class="form-label">
                        Status PPDB <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="ppdb_status" 
                        name="ppdb_status"
                        class="form-input @error('ppdb_status') border-red-500 @enderror"
                        required
                    >
                        <option value="open" {{ old('ppdb_status', $settings['ppdb_status']) == 'open' ? 'selected' : '' }}>
                            Dibuka
                        </option>
                        <option value="closed" {{ old('ppdb_status', $settings['ppdb_status']) == 'closed' ? 'selected' : '' }}>
                            Ditutup
                        </option>
                    </select>
                    @error('ppdb_status')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PPDB Dates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="ppdb_start_date" class="form-label">
                            Tanggal Mulai PPDB <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="date" 
                            id="ppdb_start_date" 
                            name="ppdb_start_date" 
                            value="{{ old('ppdb_start_date', $settings['ppdb_start_date']) }}"
                            class="form-input @error('ppdb_start_date') border-red-500 @enderror"
                            required
                        >
                        @error('ppdb_start_date')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="ppdb_end_date" class="form-label">
                            Tanggal Akhir PPDB <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="date" 
                            id="ppdb_end_date" 
                            name="ppdb_end_date" 
                            value="{{ old('ppdb_end_date', $settings['ppdb_end_date']) }}"
                            class="form-input @error('ppdb_end_date') border-red-500 @enderror"
                            required
                        >
                        @error('ppdb_end_date')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="border-t pt-6">
                    <h4 class="font-medium text-gray-900 mb-4">Informasi Kontak</h4>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="contact_email" class="form-label">
                                Email Kontak <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="contact_email" 
                                name="contact_email" 
                                value="{{ old('contact_email', $settings['contact_email']) }}"
                                class="form-input @error('contact_email') border-red-500 @enderror"
                                placeholder="ppdb@sekolah.sch.id"
                                required
                            >
                            @error('contact_email')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="contact_phone" class="form-label">
                                Nomor Telepon <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="contact_phone" 
                                name="contact_phone" 
                                value="{{ old('contact_phone', $settings['contact_phone']) }}"
                                class="form-input @error('contact_phone') border-red-500 @enderror"
                                placeholder="021-12345678"
                                required
                            >
                            @error('contact_phone')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end gap-3 pt-6 border-t">
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Info Box -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <div class="text-sm text-blue-800">
                <p class="font-medium mb-1">Informasi</p>
                <p>Perubahan konfigurasi akan langsung berlaku di seluruh sistem. Pastikan data yang diinput sudah benar sebelum menyimpan.</p>
            </div>
        </div>
    </div>
</div>
@endsection

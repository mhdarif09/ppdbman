@extends('layouts.admin-sekolah')

@section('title', 'Buat Pengumuman')
@section('page-title', 'Buat Pengumuman Baru')

@section('content')
<div class="max-w-4xl">
    <div class="card">
        <form action="{{ route('admin-sekolah.announcements.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="form-label">
                        Judul Pengumuman <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        value="{{ old('title') }}"
                        class="form-input @error('title') border-red-500 @enderror"
                        placeholder="Contoh: Pengumuman Hasil Seleksi Jalur Zonasi"
                        required
                    >
                    @error('title')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="form-label">
                        Isi Pengumuman <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="content" 
                        name="content" 
                        rows="6"
                        class="form-input @error('content') border-red-500 @enderror"
                        placeholder="Tulis detail pengumuman di sini..."
                        required
                    >{{ old('content') }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">Anda bisa menggunakan basic HTML tags.</p>
                    @error('content')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Excel Import -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="font-medium text-gray-900 mb-2">Lampirkan Hasil Seleksi (Excel)</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <input 
                                type="file" 
                                id="results_file" 
                                name="results_file"
                                accept=".xlsx, .xls, .csv"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100"
                            >
                            <p class="text-xs text-gray-500 mt-1">Format: NISN/No.Pendaftaran, Status (Accepted/Rejected/Waiting_List), Ranking</p>
                            @error('results_file')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="text-xs text-gray-500">
                            <strong>Template Kolom Excel:</strong>
                            <ul class="list-disc ml-5 mt-1 space-y-1">
                                <li><code>nisn</code> (Wajib jika tidak ada no_pendaftaran)</li>
                                <li><code>no_pendaftaran</code> (Wajib jika tidak ada nisn)</li>
                                <li><code>status</code> (accepted, rejected, waiting_list)</li>
                                <li><code>ranking</code> (Opsional)</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Publish Option -->
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        id="publish_now" 
                        name="publish_now" 
                        value="1"
                        class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                        {{ old('publish_now') ? 'checked' : '' }}
                    >
                    <label for="publish_now" class="ml-2 block text-sm text-gray-900">
                        Langsung Terbitkan Pengumuman
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex gap-3 pt-4 border-t">
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Simpan Pengumuman
                    </button>
                    <a href="{{ route('admin-sekolah.announcements.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

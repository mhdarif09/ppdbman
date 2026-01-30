@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <!-- Header -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Biodata Peserta Didik</h1>
                <p class="mt-1 text-sm text-gray-600">Lengkapi data diri Anda untuk melanjutkan proses pendaftaran</p>
            </div>
            <a href="{{ route('applicant.dashboard') }}" class="text-green-600 hover:text-green-700 text-sm font-medium">
                ← Kembali ke Dashboard
            </a>
        </div>
    </div>

    <form action="{{ route('applicant.biodata.update') }}" method="POST" class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        @csrf
        
        <!-- Personal Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <h2 class="text-lg font-bold text-white">Data Pribadi</h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Lengkap (Readonly) -->
                <div class="md:col-span-2">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" value="{{ $applicant->full_name }}" readonly class="form-input bg-gray-50 text-gray-500 cursor-not-allowed">
                </div>

                <!-- Nama Panggilan -->
                <div>
                    <label class="form-label required">Nama Panggilan</label>
                    <input type="text" name="nickname" value="{{ old('nickname', $applicant->nickname) }}" {{ $isReadonly ? 'readonly' : '' }} class="form-input {{ $isReadonly ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}" required>
                    @error('nickname')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <!-- NIS -->
                <div>
                    <label class="form-label required">Nomor Induk Siswa (NIS)</label>
                    <input type="text" name="nis" value="{{ old('nis', $applicant->nis) }}" {{ $isReadonly ? 'readonly' : '' }} class="form-input {{ $isReadonly ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}" required>
                    @error('nis')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <!-- NISN (Readonly) -->
                <div>
                    <label class="form-label">NISN</label>
                    <input type="text" value="{{ $applicant->nisn }}" readonly class="form-input bg-gray-50 text-gray-500 cursor-not-allowed">
                </div>

                <!-- Jenis Kelamin (Readonly) -->
                <div>
                    <label class="form-label">Jenis Kelamin</label>
                    <input type="text" value="{{ $applicant->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}" readonly class="form-input bg-gray-50 text-gray-500 cursor-not-allowed">
                </div>

                <!-- Tempat Lahir (Readonly) -->
                <div>
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text" value="{{ $applicant->birth_place }}" readonly class="form-input bg-gray-50 text-gray-500 cursor-not-allowed">
                </div>

                <!-- Tanggal Lahir (Readonly) -->
                <div>
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="text" value="{{ $applicant->birth_date->format('d F Y') }}" readonly class="form-input bg-gray-50 text-gray-500 cursor-not-allowed">
                </div>

                <!-- Agama -->
                <div>
                    <label class="form-label required">Agama</label>
                    <select name="religion" {{ $isReadonly ? 'disabled' : '' }} class="form-input {{ $isReadonly ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}" required>
                        <option value="">Pilih Agama</option>
                        @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $religion)
                            <option value="{{ $religion }}" {{ old('religion', $applicant->religion) == $religion ? 'selected' : '' }}>{{ $religion }}</option>
                        @endforeach
                    </select>
                    @error('religion')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <!-- Kewarganegaraan -->
                <div>
                    <label class="form-label required">Kewarganegaraan</label>
                    <input type="text" name="nationality" value="{{ old('nationality', $applicant->nationality ?? 'Indonesia') }}" {{ $isReadonly ? 'readonly' : '' }} class="form-input {{ $isReadonly ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}" required>
                    @error('nationality')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <!-- Bahasa Sehari-hari -->
                <div>
                    <label class="form-label">Bahasa Sehari-hari</label>
                    <input type="text" name="language" value="{{ old('language', $applicant->language) }}" {{ $isReadonly ? 'readonly' : '' }} class="form-input {{ $isReadonly ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}" placeholder="contoh: Bahasa Indonesia">
                    @error('language')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <!-- Golongan Darah -->
                <div>
                    <label class="form-label required">Golongan Darah</label>
                    <select name="blood_type" {{ $isReadonly ? 'disabled' : '' }} class="form-input {{ $isReadonly ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}" required>
                        <option value="">Pilih Golongan Darah</option>
                        @foreach(['A', 'B', 'AB', 'O'] as $type)
                            <option value="{{ $type }}" {{ old('blood_type', $applicant->blood_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('blood_type')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <!-- Tinggi Badan -->
                <div>
                    <label class="form-label required">Tinggi Badan (cm)</label>
                    <input type="number" name="height" value="{{ old('height', $applicant->height) }}" {{ $isReadonly ? 'readonly' : '' }} class="form-input {{ $isReadonly ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}" min="50" max="250" required>
                    @error('height')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <!-- Berat Badan -->
                <div>
                    <label class="form-label required">Berat Badan (kg)</label>
                    <input type="number" name="weight" value="{{ old('weight', $applicant->weight) }}" {{ $isReadonly ? 'readonly' : '' }} class="form-input {{ $isReadonly ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}" min="10" max="200" required>
                    @error('weight')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <!-- Family Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <h2 class="text-lg font-bold text-white">Data Keluarga</h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Anak ke -->
                <div>
                    <label class="form-label required">Anak ke-</label>
                    <input type="number" name="child_order" value="{{ old('child_order', $applicant->child_order) }}" {{ $isReadonly ? 'readonly' : '' }} class="form-input {{ $isReadonly ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}" min="1" required>
                    @error('child_order')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <!-- Jumlah Saudara Kandung -->
                <div>
                    <label class="form-label">Jumlah Saudara Kandung</label>
                    <input type="number" name="siblings_count" value="{{ old('siblings_count', $applicant->siblings_count) }}" {{ $isReadonly ? 'readonly' : '' }} class="form-input {{ $isReadonly ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}" min="0">
                    @error('siblings_count')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <!-- Jumlah Saudara Tiri -->
                <div>
                    <label class="form-label">Jumlah Saudara Tiri</label>
                    <input type="number" name="half_siblings_count" value="{{ old('half_siblings_count', $applicant->half_siblings_count) }}" {{ $isReadonly ? 'readonly' : '' }} class="form-input {{ $isReadonly ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}" min="0">
                    @error('half_siblings_count')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <!-- Jumlah Saudara Angkat -->
                <div>
                    <label class="form-label">Jumlah Saudara Angkat</label>
                    <input type="number" name="adopted_siblings_count" value="{{ old('adopted_siblings_count', $applicant->adopted_siblings_count) }}" {{ $isReadonly ? 'readonly' : '' }} class="form-input {{ $isReadonly ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}" min="0">
                    @error('adopted_siblings_count')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <!-- Status Anak -->
                <div class="md:col-span-2">
                    <label class="form-label">Status Anak</label>
                    <select name="child_status" {{ $isReadonly ? 'disabled' : '' }} class="form-input {{ $isReadonly ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}">
                        <option value="">Pilih Status</option>
                        <option value="lengkap" {{ old('child_status', $applicant->child_status) == 'lengkap' ? 'selected' : '' }}>Lengkap (Ayah & Ibu)</option>
                        <option value="yatim" {{ old('child_status', $applicant->child_status) == 'yatim' ? 'selected' : '' }}>Yatim</option>
                        <option value="piatu" {{ old('child_status', $applicant->child_status) == 'piatu' ? 'selected' : '' }}>Piatu</option>
                        <option value="yatim_piatu" {{ old('child_status', $applicant->child_status) == 'yatim_piatu' ? 'selected' : '' }}>Yatim Piatu</option>
                    </select>
                    @error('child_status')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <h2 class="text-lg font-bold text-white">Kontak & Alamat</h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Alamat Tempat Tinggal -->
                <div class="md:col-span-2">
                    <label class="form-label">Alamat Tempat Tinggal</label>
                    <textarea class="form-input bg-gray-50 text-gray-500 cursor-not-allowed" readonly rows="2">{{ $applicant->address }}</textarea>
                </div>

                <!-- Tempat Tinggal Sekarang -->
                <div class="md:col-span-2">
                    <label class="form-label required">Tempat Tinggal Sekarang / Domisili</label>
                    <textarea name="current_address" {{ $isReadonly ? 'readonly' : '' }} class="form-input {{ $isReadonly ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}" rows="2" required>{{ old('current_address', $applicant->current_address) }}</textarea>
                    @error('current_address')<p class="form-error">{{ $message }}</p>@enderror
                    <p class="text-xs text-gray-500 mt-1">Isi dengan alamat yang sama jika masih sama dengan alamat tempat tinggal</p>
                </div>

                <!-- Email -->
                <div>
                    <label class="form-label">Email</label>
                    <input type="text" value="{{ Auth::user()->email }}" readonly class="form-input bg-gray-50 text-gray-500 cursor-not-allowed">
                </div>

                <!-- Nomor HP -->
                <div>
                    <label class="form-label">Nomor HP</label>
                    <input type="text" value="{{ $applicant->phone }}" readonly class="form-input bg-gray-50 text-gray-500 cursor-not-allowed">
                </div>

                <!-- Nomor WhatsApp -->
                <div class="md:col-span-2">
                    <label class="form-label">Nomor WhatsApp</label>
                    <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $applicant->whatsapp_number) }}" {{ $isReadonly ? 'readonly' : '' }} class="form-input {{ $isReadonly ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}" placeholder="Isi jika berbeda dengan nomor HP">
                    @error('whatsapp_number')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <!-- Health Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <h2 class="text-lg font-bold text-white">Data Kesehatan</h2>
            </div>
            <div class="p-6 space-y-6">
                <!-- Riwayat Penyakit -->
                <div>
                    <label class="form-label">Riwayat Penyakit</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-2">
                        @foreach(['TBC', 'Cacar', 'Lever', 'Malaria'] as $disease)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="diseases[]" value="{{ $disease }}" {{ $isReadonly ? 'disabled' : '' }} class="text-green-600 focus:ring-green-500" {{ in_array($disease, old('diseases', $applicant->diseases ?? [])) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm">{{ $disease }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('diseases')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <!-- Alergi yang diderita -->
                <div>
                    <label class="form-label">Alergi yang Diderita</label>
                    <textarea name="allergies" {{ $isReadonly ? 'readonly' : '' }} class="form-input {{ $isReadonly ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}" rows="2" placeholder="contoh: Debu, Seafood, dll">{{ old('allergies', $applicant->allergies) }}</textarea>
                    @error('allergies')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <!-- Kelainan Jasmani -->
                <div>
                    <label class="form-label">Kelainan Jasmani</label>
                    <textarea name="physical_defects" {{ $isReadonly ? 'readonly' : '' }} class="form-input {{ $isReadonly ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}" rows="2" placeholder="Kosongkan jika tidak ada">{{ old('physical_defects', $applicant->physical_defects) }}</textarea>
                    @error('physical_defects')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        @if(!$isReadonly)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600">
                    <span class="font-medium text-red-600">*</span> Setelah biodata disimpan, data tidak dapat diubah lagi.
                </p>
                <button type="submit" class="btn btn-primary px-8 py-3">
                    Simpan Biodata
                </button>
            </div>
        </div>
        @else
        <div class="bg-green-50 border border-green-200 rounded-xl p-6 text-center">
            <svg class="w-12 h-12 text-green-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="text-lg font-bold text-green-900 mb-1">Biodata Sudah Lengkap</h3>
            <p class="text-sm text-green-700">Data biodata Anda telah tersimpan dan tidak dapat diubah.</p>
        </div>
        @endif
    </form>
</div>
@endsection

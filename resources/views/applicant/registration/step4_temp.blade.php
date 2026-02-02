@extends('applicant.registration.layout')

@section('form')
<form action="{{ route('applicant.registration.save', 3) }}" method="POST" x-data="{ hasGuardian: {{ old('has_guardian', (isset($data->guardian_name) && $data->guardian_name) ? 'true' : 'false') }} }" class="animate-fadeIn">
    @csrf

    <!-- Section 1: Data Ayah -->
    <div class="mb-10">
        <div class="section-header">
            <div class="section-number">1</div>
            <h3 class="section-title">Data Ayah Kandung</h3>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
            <div class="lg:col-span-2 form-group">
                <label class="input-label">Nama Lengkap Ayah</label>
                <input type="text" name="father_name" value="{{ old('father_name', $data->father_name ?? '') }}" required placeholder="Nama sesuai KTP">
            </div>
            
            <div class="form-group">
                <label class="input-label">NIK Ayah (16 Digit)</label>
                <input type="text" name="father_nik" value="{{ old('father_nik', $data->father_nik ?? '') }}" required maxlength="16" placeholder="16 digit NIK">
            </div>

            <div class="form-group">
                <label class="input-label">Tempat Lahir</label>
                <input type="text" name="father_birth_place" value="{{ old('father_birth_place', $data->father_birth_place ?? '') }}" placeholder="Kota Lahir">
            </div>

            <div class="form-group">
                <label class="input-label">Tanggal Lahir</label>
                <input type="date" name="father_birth_date" value="{{ old('father_birth_date', isset($data->father_birth_date) ? $data->father_birth_date->format('Y-m-d') : '') }}">
            </div>

            <div class="form-group">
                <label class="input-label">Agama</label>
                <select name="father_religion" required>
                    <option value="">Pilih Agama...</option>
                    @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $religion)
                        <option value="{{ $religion }}" {{ old('father_religion', $data->father_religion ?? '') == $religion ? 'selected' : '' }}>{{ $religion }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="input-label">Kewarganegaraan</label>
                <input type="text" name="father_nationality" value="{{ old('father_nationality', $data->father_nationality ?? 'Indonesia') }}" required placeholder="Contoh: Indonesia">
            </div>

            <div class="form-group">
                <label class="input-label">Alamat Ayah</label>
                <input type="text" name="father_address" value="{{ old('father_address', $data->father_address ?? '') }}" placeholder="Alamat Lengkap">
            </div>
            
            <div class="form-group">
                <label class="input-label">Status Keberadaan</label>
                <div class="grid grid-cols-2 gap-3">
                    @foreach(['hidup' => 'Hidup', 'meninggal' => 'Meninggal'] as $val => $label)
                        <label class="cursor-pointer">
                            <input type="radio" name="father_status" value="{{ $val }}" class="peer hidden" {{ old('father_status', $data->father_status ?? 'hidup') == $val ? 'checked' : '' }} required>
                            <div class="card-radio">{{ $label }}</div>
                        </label>
                    @endforeach
                </div>
            </div>
            
            <div class="form-group">
                <label class="input-label">Pendidikan Tertinggi</label>
                <select name="father_education" required>
                    <option value="">Pilih Pendidikan...</option>
                    @foreach(['SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3', 'Tidak Sekolah'] as $edu)
                        <option value="{{ $edu }}" {{ old('father_education', $data->father_education ?? '') == $edu ? 'selected' : '' }}>{{ $edu }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label class="input-label">Pekerjaan</label>
                <input type="text" name="father_job" value="{{ old('father_job', $data->father_job ?? '') }}" required placeholder="Contoh: Karyawan Swasta">
            </div>
            
            <div class="form-group">
                <label class="input-label">Penghasilan Per Bulan</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-medium">Rp</span>
                    <input type="number" name="father_income" value="{{ old('father_income', $data->father_income ?? '') }}" class="!pl-12" placeholder="0">
                </div>
            </div>
            
            <div class="form-group">
                <label class="input-label">Nomor HP / WhatsApp</label>
                <input type="text" name="father_phone" value="{{ old('father_phone', $data->father_phone ?? '') }}" placeholder="08xxx...">
            </div>
        </div>
    </div>

    <!-- Section 2: Data Ibu -->
    <div class="mb-10">
        <div class="section-header">
            <div class="section-number">2</div>
            <h3 class="section-title">Data Ibu Kandung</h3>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
            <div class="lg:col-span-2 form-group">
                <label class="input-label">Nama Lengkap Ibu</label>
                <input type="text" name="mother_name" value="{{ old('mother_name', $data->mother_name ?? '') }}" required placeholder="Nama sesuai KTP">
            </div>
            
            <div class="form-group">
                <label class="input-label">NIK Ibu (16 Digit)</label>
                <input type="text" name="mother_nik" value="{{ old('mother_nik', $data->mother_nik ?? '') }}" required maxlength="16" placeholder="16 digit NIK">
            </div>

            <div class="form-group">
                <label class="input-label">Tempat Lahir</label>
                <input type="text" name="mother_birth_place" value="{{ old('mother_birth_place', $data->mother_birth_place ?? '') }}" placeholder="Kota Lahir">
            </div>

            <div class="form-group">
                <label class="input-label">Tanggal Lahir</label>
                <input type="date" name="mother_birth_date" value="{{ old('mother_birth_date', isset($data->mother_birth_date) ? $data->mother_birth_date->format('Y-m-d') : '') }}">
            </div>

            <div class="form-group">
                <label class="input-label">Agama</label>
                <select name="mother_religion" required>
                    <option value="">Pilih Agama...</option>
                    @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $religion)
                        <option value="{{ $religion }}" {{ old('mother_religion', $data->mother_religion ?? '') == $religion ? 'selected' : '' }}>{{ $religion }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="input-label">Kewarganegaraan</label>
                <input type="text" name="mother_nationality" value="{{ old('mother_nationality', $data->mother_nationality ?? 'Indonesia') }}" required placeholder="Contoh: Indonesia">
            </div>

            <div class="form-group">
                <label class="input-label">Alamat Ibu</label>
                <input type="text" name="mother_address" value="{{ old('mother_address', $data->mother_address ?? '') }}" placeholder="Alamat Lengkap">
            </div>
            
            <div class="form-group">
                <label class="input-label">Status Keberadaan</label>
                <div class="grid grid-cols-2 gap-3">
                    @foreach(['hidup' => 'Hidup', 'meninggal' => 'Meninggal'] as $val => $label)
                        <label class="cursor-pointer">
                            <input type="radio" name="mother_status" value="{{ $val }}" class="peer hidden" {{ old('mother_status', $data->mother_status ?? 'hidup') == $val ? 'checked' : '' }} required>
                            <div class="card-radio">{{ $label }}</div>
                        </label>
                    @endforeach
                </div>
            </div>
            
            <div class="form-group">
                <label class="input-label">Pendidikan Terakhir</label>
                <select name="mother_education" required>
                    <option value="">Pilih Pendidikan...</option>
                    @foreach(['SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3', 'Tidak Sekolah'] as $edu)
                        <option value="{{ $edu }}" {{ old('mother_education', $data->mother_education ?? '') == $edu ? 'selected' : '' }}>{{ $edu }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label class="input-label">Pekerjaan Utama</label>
                <input type="text" name="mother_job" value="{{ old('mother_job', $data->mother_job ?? '') }}" required placeholder="Contoh: Ibu Rumah Tangga">
            </div>
            
            <div class="form-group">
                <label class="input-label">Penghasilan Per Bulan</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-medium">Rp</span>
                    <input type="number" name="mother_income" value="{{ old('mother_income', $data->mother_income ?? '') }}" class="!pl-12" placeholder="0">
                </div>
            </div>
            
            <div class="form-group">
                <label class="input-label">Nomor HP / WhatsApp</label>
                <input type="text" name="mother_phone" value="{{ old('mother_phone', $data->mother_phone ?? '') }}" placeholder="08xxx...">
            </div>
        </div>
    </div>

    <!-- Toggle Wali -->
    <div class="mb-6">
        <div class="p-5 bg-slate-50 rounded-2xl border border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <h4 class="font-semibold text-slate-900">Gunakan Data Wali?</h4>
                <p class="text-sm text-slate-500">Aktifkan jika tidak tinggal bersama orang tua kandung</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="has_guardian" value="1" class="sr-only peer" x-model="hasGuardian">
                <div class="w-14 h-8 bg-slate-300 rounded-full peer peer-checked:bg-emerald-500 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all after:shadow-sm"></div>
            </label>
        </div>
    </div>

    <!-- Section 3: Data Wali (Conditional) -->
    <div x-show="hasGuardian" x-collapse x-cloak class="mb-10">
        <div class="p-6 bg-emerald-50 rounded-2xl border border-emerald-200">
            <div class="section-header border-emerald-200">
                <div class="section-number">3</div>
                <h3 class="section-title">Informasi Wali</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <div class="lg:col-span-2 form-group">
                    <label class="input-label">Nama Lengkap Wali</label>
                    <input type="text" name="guardian_name" value="{{ old('guardian_name', $data->guardian_name ?? '') }}" placeholder="Nama wali">
                </div>
                <div class="form-group">
                    <label class="input-label">Pekerjaan Wali</label>
                    <input type="text" name="guardian_job" value="{{ old('guardian_job', $data->guardian_job ?? '') }}" placeholder="Contoh: Wiraswasta">
                </div>
                <div class="form-group">
                    <label class="input-label">Nomor HP / WhatsApp Wali</label>
                    <input type="text" name="guardian_phone" value="{{ old('guardian_phone', $data->guardian_phone ?? '') }}" placeholder="08xxx...">
                </div>
                <div class="lg:col-span-2 form-group">
                    <label class="input-label">Alamat Lengkap Wali</label>
                    <textarea name="guardian_address" rows="3" placeholder="Alamat lengkap wali...">{{ old('guardian_address', $data->guardian_address ?? '') }}</textarea>
                </div>
                <div class="form-group">
                    <label class="input-label">Tempat Lahir</label>
                    <input type="text" name="guardian_birth_place" value="{{ old('guardian_birth_place', $data->guardian_birth_place ?? '') }}">
                </div>
                <div class="form-group">
                    <label class="input-label">Tanggal Lahir</label>
                    <input type="date" name="guardian_birth_date" value="{{ old('guardian_birth_date', isset($data->guardian_birth_date) ? $data->guardian_birth_date->format('Y-m-d') : '') }}">
                </div>
                <div class="form-group">
                    <label class="input-label">Agama</label>
                    <select name="guardian_religion">
                        <option value="">Pilih Agama...</option>
                        @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $religion)
                            <option value="{{ $religion }}" {{ old('guardian_religion', $data->guardian_religion ?? '') == $religion ? 'selected' : '' }}>{{ $religion }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="input-label">Kewarganegaraan</label>
                    <input type="text" name="guardian_nationality" value="{{ old('guardian_nationality', $data->guardian_nationality ?? 'Indonesia') }}" placeholder="Contoh: Indonesia">
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="form-navigation">
        <a href="{{ route('applicant.registration.step', 2) }}" class="btn-secondary w-full sm:w-auto">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali</span>
        </a>
        <button type="submit" class="btn-primary w-full sm:w-auto">
            <span>Simpan & Lanjutkan</span>
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
        </button>
    </div>
</form>
@endsection

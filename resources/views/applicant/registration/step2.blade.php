@extends('applicant.registration.layout')

@section('form')
<form action="{{ route('applicant.registration.save', 2) }}" method="POST" x-data="{ isTransfer: {{ old('is_transfer', $data->is_transfer ?? 0) }} }" class="animate-fadeIn">
    @csrf

    <!-- Section 1: Sekolah Asal -->
    <div class="mb-10">
        <div class="section-header">
            <div class="section-number">1</div>
            <h3 class="section-title">Data Sekolah Asal (SMP/MTs)</h3>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
            <div class="lg:col-span-2 form-group">
                <label class="input-label">Asal Sekolah (SMP / MTs)</label>
                <input type="text" name="previous_school_name" value="{{ old('previous_school_name', $data->previous_school_name ?? '') }}" required placeholder="Contoh: SMP Negeri 1 Palembang">
                @error('previous_school_name')<p class="mt-2 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>
            
            <div class="form-group">
                <label class="input-label">Nomor STTB</label>
                <input type="text" name="sttb_number" value="{{ old('sttb_number', $data->sttb_number ?? '') }}" placeholder="Nomor Ijazah SMP">
            </div>

            <div class="form-group">
                <label class="input-label">Tanggal STTB / Ijazah</label>
                <input type="date" name="sttb_date" value="{{ old('sttb_date', $data->sttb_date ?? '') }}">
            </div>

            <div class="form-group">
                <label class="input-label">Lama Belajar (Tahun)</label>
                <input type="number" name="study_duration" value="{{ old('study_duration', $data->study_duration ?? 3) }}" min="1" max="10" required>
            </div>



            <div class="form-group">
                <label class="input-label">Status Siswa</label>
                <div class="grid grid-cols-2 gap-3">
                    @foreach([0 => 'Siswa Baru', 1 => 'Pindahan'] as $val => $label)
                        <label class="cursor-pointer">
                            <input type="radio" name="is_transfer" value="{{ $val }}" class="peer hidden" x-model="isTransfer" required>
                            <div class="card-radio">{{ $label }}</div>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Informasi Pindahan (Conditional) -->
    <div x-show="isTransfer == 1" x-collapse x-cloak class="mb-10">
        <div class="p-6 bg-amber-50 rounded-2xl border border-amber-200">
            <div class="section-header border-amber-200">
                <div class="section-number bg-amber-100 text-amber-600">!</div>
                <h3 class="section-title">Informasi Kepindahan</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <div class="form-group">
                    <label class="input-label">Alasan Pindah</label>
                    <input type="text" name="transfer_reason" value="{{ old('transfer_reason', $data->transfer_reason ?? '') }}" :required="isTransfer == 1" placeholder="Contoh: Ikut orang tua">
                </div>
                <div class="form-group">
                    <label class="input-label">Pindah Dari Tingkat</label>
                    <input type="text" name="transfer_from_grade" value="{{ old('transfer_from_grade', $data->transfer_from_grade ?? '') }}" placeholder="Contoh: Kelas 8">
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="form-navigation">
        <a href="{{ route('applicant.registration.step', 1) }}" class="btn-secondary w-full sm:w-auto">
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

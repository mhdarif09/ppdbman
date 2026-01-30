@extends('applicant.registration.layout')

@section('form')
<form action="{{ route('applicant.registration.save', 5) }}" method="POST" class="animate-fadeIn">
    @csrf

    <!-- Section 1: Riwayat Pendidikan -->
    <div class="mb-10">
        <div class="section-header">
            <div class="section-number">1</div>
            <h3 class="section-title">Riwayat Pendidikan Tambahan</h3>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
            <div class="form-group">
                <label class="input-label">Tahun Masuk SMP/MTs</label>
                <input type="number" name="enrollment_year" value="{{ old('enrollment_year', $data->enrollment_year ?? date('Y')-3) }}" required min="2000" max="{{ date('Y') }}">
                @error('enrollment_year')<p class="mt-2 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>
            
            <div class="form-group">
                <label class="input-label">Beasiswa yang Pernah Diterima</label>
                <input type="text" name="scholarships" value="{{ old('scholarships', $data->scholarships ?? '') }}" placeholder="Nama beasiswa (jika ada)">
            </div>
            
            <div class="form-group">
                <label class="input-label">Tahun Meninggalkan Sekolah (Jika ada)</label>
                <input type="number" name="leave_year" value="{{ old('leave_year', $data->leave_year ?? '') }}" placeholder="Tahun" min="2000">
            </div>

            <div class="form-group">
                <label class="input-label">Alasan Meninggalkan Sekolah</label>
                <input type="text" name="leave_reason" value="{{ old('leave_reason', $data->leave_reason ?? '') }}" placeholder="Alasan (jika ada)">
            </div>
        </div>
    </div>

    <!-- Section 2: Kelulusan -->
    <div class="mb-10">
        <div class="section-header">
            <div class="section-number">2</div>
            <h3 class="section-title">Data Kelulusan SMP/MTs</h3>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
            <div class="form-group">
                <label class="input-label">Tahun Lulus</label>
                <input type="number" name="graduation_year" value="{{ old('graduation_year', $data->graduation_year ?? date('Y')) }}" required>
            </div>
            <div class="form-group">
                <label class="input-label">Nomor STTB / Ijazah</label>
                <input type="text" name="graduation_sttb_number" value="{{ old('graduation_sttb_number', $data->graduation_sttb_number ?? '') }}" placeholder="DN-XX/XXXX/XXXX">
            </div>
            <div class="form-group">
                <label class="input-label">Tanggal Ijazah</label>
                <input type="date" name="graduation_sttb_date" value="{{ old('graduation_sttb_date', isset($data->graduation_sttb_date) ? $data->graduation_sttb_date->format('Y-m-d') : '') }}">
            </div>
        </div>
    </div>

    <!-- Section 3: Rencana -->
    <div class="mb-10">
        <div class="section-header">
            <div class="section-number">3</div>
            <h3 class="section-title">Rencana Setelah Lulus MAN</h3>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6" x-data="{ status: '{{ old('after_graduation_status', $data->after_graduation_status ?? '') }}' }">
            <div class="form-group">
                <label class="input-label">Tujuan Utama</label>
                <select name="after_graduation_status" required x-model="status">
                    <option value="">Pilih Rencana...</option>
                    <option value="melanjutkan">Melanjutkan Kuliah</option>
                    <option value="bekerja">Bekerja / Wirausaha</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>
            
            <div class="form-group" x-show="status == 'melanjutkan'">
                <label class="input-label">Instansi / Kampus Impian</label>
                <input type="text" name="continued_to" value="{{ old('continued_to', $data->continued_to ?? '') }}" placeholder="Contoh: UI, UGM, ITB">
            </div>

            <div class="form-group" x-show="status == 'bekerja'" x-cloak>
                <label class="input-label">Rencana Tempat Kerja</label>
                <input type="text" name="working_at" value="{{ old('working_at', $data->working_at ?? '') }}" placeholder="Contoh: PT. Maju Jaya">
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="form-navigation">
        <a href="{{ route('applicant.registration.step', 4) }}" class="btn-secondary w-full sm:w-auto">
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

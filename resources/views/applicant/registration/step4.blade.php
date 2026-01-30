@extends('applicant.registration.layout')

@section('form')
<form action="{{ route('applicant.registration.save', 4) }}" method="POST" class="animate-fadeIn">
    @csrf

    <!-- Info Box -->
    <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start gap-3">
        <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold text-emerald-800 text-sm">Informasi</p>
            <p class="text-sm text-emerald-700">Data ini membantu pemetaan potensi ekstrakurikuler. Bersifat <strong>opsional</strong> jika tidak ada.</p>
        </div>
    </div>

    <!-- Section: Minat & Bakat -->
    <div class="mb-10">
        <div class="section-header">
            <div class="section-number">1</div>
            <h3 class="section-title">Minat dan Bakat</h3>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
            <div class="form-group">
                <label class="input-label">Bidang Seni</label>
                <input type="text" name="hobby_art" value="{{ old('hobby_art', $data->hobby_art ?? '') }}" placeholder="Contoh: Lukis, Musik, Tari">
            </div>
            
            <div class="form-group">
                <label class="input-label">Bidang Olahraga</label>
                <input type="text" name="hobby_sports" value="{{ old('hobby_sports', $data->hobby_sports ?? '') }}" placeholder="Contoh: Futsal, Basket, Renang">
            </div>
            
            <div class="form-group">
                <label class="input-label">Kegiatan Sosial / Organisasi</label>
                <input type="text" name="hobby_social" value="{{ old('hobby_social', $data->hobby_social ?? '') }}" placeholder="Contoh: PMR, Pramuka, OSIS">
            </div>
            
            <div class="form-group">
                <label class="input-label">Hobi Lainnya</label>
                <input type="text" name="hobby_other" value="{{ old('hobby_other', $data->hobby_other ?? '') }}" placeholder="Contoh: Membaca, Coding, Gaming">
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="form-navigation">
        <a href="{{ route('applicant.registration.step', 3) }}" class="btn-secondary w-full sm:w-auto">
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

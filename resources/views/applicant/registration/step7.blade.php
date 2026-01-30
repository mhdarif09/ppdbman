@extends('applicant.registration.layout')

@section('form')
<form action="{{ route('applicant.registration.save', 7) }}" method="POST" x-data="{ confirmed: false }" class="animate-fadeIn">
    @csrf

    <!-- Section: Checklist Dokumen -->
    <div class="mb-10">
        <div class="section-header">
            <div class="section-number">1</div>
            <h3 class="section-title">Checklist Kelengkapan Dokumen</h3>
        </div>
        
        <p class="text-sm text-slate-500 mb-6">Pastikan dokumen berikut sudah siap untuk verifikasi:</p>
        
        @php
            $checklists = [
                'kk' => ['label' => 'Foto Copy Kartu Keluarga', 'desc' => '1 lembar'],
                'photos_3x4' => ['label' => 'Pas Foto 3x4', 'desc' => '3 lembar'],
                'photos_2x3' => ['label' => 'Pas Foto 2x3', 'desc' => '3 lembar'],
                'raport' => ['label' => 'Foto Raport Semester 1-6', 'desc' => 'Legalisir'],
                'akte' => ['label' => 'Foto Akta Kelahiran', 'desc' => 'Fotokopi'],
                'proof' => ['label' => 'Mencetak Kartu Bukti Daftar', 'desc' => '2 Rangkap']
            ];
        @endphp
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($checklists as $id => $info)
                <label class="cursor-pointer group relative">
                    <input type="checkbox" name="checklist[{{ $id }}]" required class="peer hidden">
                    <div class="p-4 bg-slate-50 border-2 border-slate-200 rounded-xl transition-all duration-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 hover:border-slate-300 h-full">
                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full border-2 border-slate-300 flex items-center justify-center peer-checked:border-emerald-500 peer-checked:bg-emerald-500 transition-all shrink-0">
                                <svg class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-slate-900 text-sm">{{ $info['label'] }}</h4>
                                <p class="text-xs text-slate-500 mt-1">{{ $info['desc'] }}</p>
                            </div>
                        </div>
                    </div>
                </label>
            @endforeach
        </div>
    </div>

    <!-- Warning Box -->
    <div class="mb-10 p-6 bg-amber-50 border-2 border-dashed border-amber-300 rounded-2xl">
        <div class="flex flex-col sm:flex-row items-center gap-4">
            <div class="w-14 h-14 bg-amber-500 text-white rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <div class="text-center sm:text-left">
                <h3 class="text-lg font-bold text-amber-800">Peringatan</h3>
                <p class="text-sm text-amber-700">Setelah menekan tombol submit, data pendaftaran akan <strong>TERKUNCI</strong> dan tidak dapat diubah.</p>
            </div>
        </div>
    </div>

    <!-- Confirmation Checkbox -->
    <div class="mb-10 flex justify-center">
        <label class="inline-flex items-center gap-3 px-4 py-3 sm:px-6 sm:py-4 bg-white border-2 rounded-xl cursor-pointer transition-all duration-200 w-full sm:w-auto justify-center sm:justify-start" :class="confirmed ? 'border-emerald-500 bg-emerald-50' : 'border-slate-200 hover:border-slate-300'">
            <input type="checkbox" x-model="confirmed" class="w-5 h-5 rounded border-slate-300 text-emerald-500 focus:ring-emerald-500 shrink-0">
            <span class="font-semibold text-slate-900 text-sm sm:text-base">Saya konfirmasi semua data sudah benar</span>
        </label>
    </div>

    <!-- Navigation -->
    <div class="form-navigation">
        <a href="{{ route('applicant.registration.step', 6) }}" class="btn-secondary w-full sm:w-auto" :class="confirmed && 'opacity-50 pointer-events-none'">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali</span>
        </a>
        <button type="submit" 
                class="btn-primary w-full sm:w-auto transition-all duration-300"
                :class="confirmed ? 'bg-emerald-500 hover:bg-emerald-600 shadow-lg shadow-emerald-500/25' : 'bg-slate-200 text-slate-400 cursor-not-allowed hover:bg-slate-200 shadow-none'"
                :disabled="!confirmed">
            <span>Selesai & Cetak Kartu</span>
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </button>
    </div>
</form>
@endsection

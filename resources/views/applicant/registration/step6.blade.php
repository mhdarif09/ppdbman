@extends('applicant.registration.layout')

@section('form')
<form action="{{ route('applicant.registration.save', 6) }}" method="POST" class="animate-fadeIn">
    @csrf

    <!-- Prepare Data -->
    @php
        // Transform collection to array: ['subject' => ['semester' => grade]]
        $grades = $data->groupBy('subject')->map(function($items) {
            return $items->pluck('grade', 'semester');
        })->toArray();
    @endphp

    <!-- Info Box -->
    <div class="mb-8 p-4 bg-slate-100 border border-slate-200 rounded-xl flex items-start gap-3">
        <div class="w-8 h-8 bg-slate-600 rounded-lg flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold text-slate-800 text-sm">Petunjuk Pengisian</p>
            <p class="text-sm text-slate-600">Masukkan <strong>Nilai Rata-rata Pengetahuan</strong> (KI-3) dari rapor untuk setiap semester.</p>
        </div>
    </div>

    <!-- Average Grade Card -->
    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm mb-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-emerald-500 text-white flex items-center justify-center rounded-lg text-sm font-bold uppercase">
                R
            </div>
            <h3 class="font-semibold text-slate-900">Rata-rata Nilai Rapor</h3>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-6 gap-3 min-w-0">
            @php 
                $isPmpa = \Illuminate\Support\Str::contains(strtoupper($applicant->pathway->name ?? ''), 'PMPA');
                $startSem = $isPmpa ? 1 : 3; 
                $endSem = 5;
                $subject = 'average';

                $semesterLabels = [
                    1 => 'Kelas 7 Ganjil',
                    2 => 'Kelas 7 Genap',
                    3 => 'Kelas 8 Ganjil',
                    4 => 'Kelas 8 Genap',
                    5 => 'Kelas 9 Ganjil'
                ];
            @endphp
            
            @for($sem = $startSem; $sem <= $endSem; $sem++)
                <div class="min-w-[100px] flex-1">
                    <label class="text-[10px] text-slate-500 font-bold block mb-1 text-center whitespace-nowrap uppercase tracking-tighter">
                        {{ $semesterLabels[$sem] ?? "Semester $sem" }}
                    </label>
                    <input type="number" 
                           name="grades[{{ $subject }}][{{ $sem }}]" 
                           value="{{ old("grades.$subject.$sem", $grades[$subject][$sem] ?? '') }}"
                           min="0" max="100" step="0.01"
                           required
                           class="w-full text-center !px-1 !py-2.5 sm:!px-2 sm:!py-3 text-base font-black text-emerald-700 bg-emerald-50 border-emerald-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl"
                           placeholder="0.00">
                </div>
            @endfor
        </div>
    </div>

    <!-- Navigation -->
    <div class="form-navigation">
        <a href="{{ route('applicant.registration.step', 5) }}" class="btn-secondary w-full sm:w-auto">
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

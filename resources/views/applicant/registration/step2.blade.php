@extends('applicant.registration.layout')

@section('form')
@php
    // Extract data from controller
    $education = $data['education'] ?? null;
    $existingGrades = $data['existingGrades'] ?? collect();
    $competitions = $data['competitions'] ?? collect();
@endphp

<form action="{{ route('applicant.registration.save', 2) }}" method="POST" 
      x-data="{
          isTransfer: {{ old('is_transfer', $education->is_transfer ?? 0) }},
          competitions: {{ json_encode(old('competitions', $competitions->map(function($c) {
              return ['competition_name' => $c->competition_name, 'year' => $c->year, 'level' => $c->level];
          })->toArray())) ?: '[]' }}
      }" 
      class="animate-fadeIn">
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
                <input type="text" name="previous_school_name" value="{{ old('previous_school_name', $education->previous_school_name ?? '') }}" required placeholder="Contoh: SMP Negeri 1 Palembang">
            </div>
            
            <div class="form-group">
                <label class="input-label">Nomor STTB</label>
                <input type="text" name="sttb_number" value="{{ old('sttb_number', $education->sttb_number ?? '') }}" placeholder="Nomor Ijazah SMP">
            </div>

            <div class="form-group">
                <label class="input-label">Tanggal STTB / Ijazah</label>
                <input type="date" name="sttb_date" value="{{ old('sttb_date', $education->sttb_date ?? '') }}">
            </div>

            <div class="form-group">
                <label class="input-label">Lama Belajar (Tahun)</label>
                <input type="number" name="study_duration" value="{{ old('study_duration', $education->study_duration ?? 3) }}" min="1" max="10" required>
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

    <!-- Section 2: Transfer Info (Conditional) -->
    <div x-show="isTransfer == 1" x-collapse x-cloak class="mb-10">
        <div class="p-6 bg-amber-50 rounded-2xl border border-amber-200">
            <div class="section-header border-amber-200">
                <div class="section-number bg-amber-100 text-amber-600">!</div>
                <h3 class="section-title">Informasi Kepindahan</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <div class="form-group">
                    <label class="input-label">Alasan Pindah</label>
                    <input type="text" name="transfer_reason" value="{{ old('transfer_reason', $education->transfer_reason ?? '') }}" :required="isTransfer == 1" placeholder="Contoh: Ikut orang tua">
                </div>
                <div class="form-group">
                    <label class="input-label">Pindah Dari Tingkat</label>
                    <input type="text" name="transfer_from_grade" value="{{ old('transfer_from_grade', $education->transfer_from_grade ?? '') }}" placeholder="Contoh: Kelas 8">
                </div>
            </div>
        </div>
    </div>

    <!-- Section 3: Nilai Rapor -->
    <div class="mb-10">
        <div class="section-header">
            <div class="section-number">2</div>
            <h3 class="section-title">Nilai Rapor</h3>
        </div>

        <div class="mb-6 p-4 bg-slate-100 border border-slate-200 rounded-xl flex items-start gap-3">
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

            // Transform grades to array
            $grades = $existingGrades->groupBy('subject')->map(function($items) {
                return $items->pluck('grade', 'semester');
            })->toArray();
        @endphp
        
        <div class="grid grid-cols-1 sm:grid-cols-6 gap-3 min-w-0">
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

    <!-- Section 4: Prestasi Lomba / Kegiatan -->
    <div class="mb-10">
        <div class="section-header">
            <div class="section-number">3</div>
            <h3 class="section-title">Prestasi Lomba / Kegiatan</h3>
        </div>

        <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-xl flex items-start gap-3">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-blue-800 text-sm">Informasi</p>
                <p class="text-sm text-blue-600">Tambahkan prestasi lomba atau kegiatan yang pernah diikuti (jika ada). Klik "Tambah Lomba" untuk menambah entry.</p>
            </div>
        </div>

        <div class="space-y-3" x-show="competitions.length > 0">
            <template x-for="(comp, index) in competitions" :key="index">
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                    <div class="flex items-start gap-4">
                        <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="form-group">
                                <label class="input-label text-xs">Nama Kegiatan/Lomba</label>
                                <input type="text" 
                                       :name="'competitions['+index+'][competition_name]'" 
                                       x-model="comp.competition_name"
                                       placeholder="Contoh: Olimpiade Matematika"
                                       class="text-sm">
                            </div>
                            <div class="form-group">
                                <label class="input-label text-xs">Tahun</label>
                                <input type="number" 
                                       :name="'competitions['+index+'][year]'" 
                                       x-model="comp.year"
                                       min="2010" :max="new Date().getFullYear()"
                                       placeholder="2023"
                                       class="text-sm">
                            </div>
                            <div class="form-group">
                                <label class="input-label text-xs">Tingkat</label>
                                <select :name="'competitions['+index+'][level]'" x-model="comp.level" class="text-sm">
                                    <option value="">Pilih Tingkat...</option>
                                    <option value="kecamatan">Kecamatan</option>
                                    <option value="kota">Kota/Kabupaten</option>
                                    <option value="provinsi">Provinsi</option>
                                    <option value="nasional">Nasional</option>
                                </select>
                            </div>
                        </div>
                        <button type="button" 
                                @click="competitions.splice(index, 1)"
                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </template>
        </div>

        <button type="button" 
                @click="competitions.push({ competition_name: '', year: new Date().getFullYear(), level: '' })"
                class="mt-3 w-full py-3 px-4 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-semibold rounded-xl border-2 border-dashed border-emerald-300 transition flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            <span>Tambah Lomba</span>
        </button>
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

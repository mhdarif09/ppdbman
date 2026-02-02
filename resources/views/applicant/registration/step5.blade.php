@extends('applicant.registration.layout')

@section('form')
<form action="{{ route('applicant.registration.save', 5) }}" method="POST" class="animate-fadeIn">
    @csrf
    
    <!-- Header Section -->
    <div class="mb-8">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-500 rounded-full mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-900 mb-2">Checklist Dokumen Persyaratan</h2>
            <p class="text-slate-600">Pastikan semua dokumen berikut sudah disiapkan sebelum submit pendaftaran</p>
        </div>
    </div>

    @php
        $isPmpa = \Illuminate\Support\Str::contains(strtoupper($applicant->pathway->name ?? ''), 'PMPA');
    @endphp

    <!-- Dokumen Wajib (Semua Jalur) -->
    <div class="mb-8">
        <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center text-white text-sm font-bold">!</div>
            Dokumen Wajib (Semua Jalur)
        </h3>
        
        <div class="space-y-3">
            <!-- KK -->
            <label class="flex items-start gap-4 p-4 bg-white rounded-xl border-2 border-slate-200 hover:border-emerald-300 transition cursor-pointer group">
                <input type="checkbox" name="checklist_kk" value="1" required 
                       class="mt-1 w-5 h-5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                <div class="flex-1">
                    <div class="font-semibold text-slate-900 group-hover:text-emerald-600 transition">Fotokopi Kartu Keluarga (KK)</div>
                    <div class="text-sm text-slate-500">1 lembar fotokopi KK</div>
                </div>
            </label>

            <!-- Akte Kelahiran -->
            <label class="flex items-start gap-4 p-4 bg-white rounded-xl border-2 border-slate-200 hover:border-emerald-300 transition cursor-pointer group">
                <input type="checkbox" name="checklist_akte" value="1" required 
                       class="mt-1 w-5 h-5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                <div class="flex-1">
                    <div class="font-semibold text-slate-900 group-hover:text-emerald-600 transition">Fotokopi Akte Kelahiran</div>
                    <div class="text-sm text-slate-500">Fotokopi akte kelahiran 1 Lembar</div>
                </div>
            </label>

            <!-- Photo 3x4 -->
            <label class="flex items-start gap-4 p-4 bg-white rounded-xl border-2 border-slate-200 hover:border-emerald-300 transition cursor-pointer group">
                <input type="checkbox" name="checklist_photo_3x4" value="1" required 
                       class="mt-1 w-5 h-5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                <div class="flex-1">
                    <div class="font-semibold text-slate-900 group-hover:text-emerald-600 transition">Photo 3x4 (Background Merah)</div>
                    <div class="text-sm text-slate-500">3 lembar photo ukuran 3x4 dengan latar belakang merah</div>
                </div>
            </label>

            <!-- Photo 2x3 -->
            <label class="flex items-start gap-4 p-4 bg-white rounded-xl border-2 border-slate-200 hover:border-emerald-300 transition cursor-pointer group">
                <input type="checkbox" name="checklist_photo_2x3" value="1" required 
                       class="mt-1 w-5 h-5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                <div class="flex-1">
                    <div class="font-semibold text-slate-900 group-hover:text-emerald-600 transition">Photo 2x3 (Background Merah)</div>
                    <div class="text-sm text-slate-500">3 lembar photo ukuran 2x3 dengan latar belakang merah</div>
                </div>
            </label>

            <!-- Printout Kartu -->
            <label class="flex items-start gap-4 p-4 bg-white rounded-xl border-2 border-slate-200 hover:border-emerald-300 transition cursor-pointer group">
                <input type="checkbox" name="checklist_printout" value="1" required 
                       class="mt-1 w-5 h-5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                <div class="flex-1">
                    <div class="font-semibold text-slate-900 group-hover:text-emerald-600 transition">Printout Kartu Pendaftaran</div>
                    <div class="text-sm text-slate-500">2 lembar printout kartu bukti pendaftaran (dapat diunduh setelah submit)</div>
                </div>
            </label>

            <!-- Sertifikat -->
            <label class="flex items-start gap-4 p-4 bg-white rounded-xl border-2 border-slate-200 hover:border-emerald-300 transition cursor-pointer group">
                <input type="checkbox" name="checklist_sertifikat" value="1" 
                       class="mt-1 w-5 h-5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                <div class="flex-1">
                    <div class="font-semibold text-slate-900 group-hover:text-emerald-600 transition">Sertifikat Pendukung (Opsional)</div>
                    <div class="text-sm text-slate-500">Sertifikat tahfidz, ranking, prestasi lomba, dll (jika ada)</div>
                </div>
            </label>
        </div>
    </div>

    <!-- Dokumen Khusus Jalur -->
    <div class="mb-8">
        <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
            <div class="w-8 h-8 bg-amber-500 rounded-lg flex items-center justify-center text-white text-sm font-bold">@if($isPmpa) PMPA @else REG @endif</div>
            Dokumen Khusus Jalur {{ $isPmpa ? 'PMPA' : 'Reguler' }}
        </h3>
        
        <div class="space-y-3">
            <!-- Raport -->
            <label class="flex items-start gap-4 p-4 bg-white rounded-xl border-2 border-slate-200 hover:border-emerald-300 transition cursor-pointer group">
                <input type="checkbox" name="checklist_raport" value="1" required 
                       class="mt-1 w-5 h-5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                <div class="flex-1">
                    <div class="font-semibold text-slate-900 group-hover:text-emerald-600 transition">Legalisir Rapor</div>
                    <div class="text-sm text-slate-500">
                        @if($isPmpa)
                            1 lembar legalisir rapor <strong>semester 1-6</strong>
                        @else
                            1 lembar legalisir rapor <strong>semester 3-5</strong>
                        @endif
                    </div>
                </div>
            </label>

            <!-- Rekomendasi (PMPA only) -->
            @if($isPmpa)
            <label class="flex items-start gap-4 p-4 bg-white rounded-xl border-2 border-slate-200 hover:border-emerald-300 transition cursor-pointer group">
                <input type="checkbox" name="checklist_rekomendasi" value="1" required 
                       class="mt-1 w-5 h-5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                <div class="flex-1">
                    <div class="font-semibold text-slate-900 group-hover:text-emerald-600 transition">Surat Rekomendasi Sekolah</div>
                    <div class="text-sm text-slate-500">1 lembar surat rekomendasi dari sekolah asal (Khusus PMPA)</div>
                </div>
            </label>
            @else
            <input type="hidden" name="checklist_rekomendasi" value="0">
            @endif
        </div>
    </div>

    <!-- Info Submission -->
    <div class="mb-8 p-6 bg-emerald-50 rounded-2xl border-2 border-emerald-200">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-emerald-900 mb-2">Pengumpulan Dokumen</h4>
                <p class="text-sm text-emerald-700 leading-relaxed">
                    Dokumen persyaratan dibawa ke <strong>MAN 1 Palembang</strong> pada tanggal <strong>02 Februari - 06 April 2026</strong>
                </p>
                <p class="text-sm text-emerald-700 mt-2 flex items-start gap-2">
                    <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span><strong>Alamat:</strong> Jl. Gubernur H.A. Bastari, 15 Ulu, Kec. Seberang Ulu I, Kota Palembang, Sumatera Selatan</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Anti-Corruption Statement -->
    <div class="mb-10 p-6 bg-slate-900 rounded-2xl border-2 border-slate-700 text-white">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-yellow-400 mb-2 uppercase tracking-wide">Komitmen Zona Integritas</h4>
                <p class="text-sm text-slate-300 leading-relaxed mb-3">
                    <strong class="text-white">MAN 1 PALEMBANG</strong> berkomitmen dalam <strong class="text-yellow-400">ZONA INTEGRITAS</strong> dalam mewujudkan <strong class="text-white">WBK (Wilayah Bebas Korupsi)</strong> & <strong class="text-white">WBBM (Wilayah Birokrasi Bersih dan Melayani)</strong>.
                </p>
                <p class="text-sm text-slate-300">
                    Apabila menemukan <strong class="text-red-400">pungli/gratifikasi</strong>, silahkan menghubungi kontak yang tertera.
                </p>
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
        <button type="submit" class="btn-primary w-full sm:w-auto group">
            <span>Submit Pendaftaran</span>
            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </button>
    </div>
</form>
@endsection

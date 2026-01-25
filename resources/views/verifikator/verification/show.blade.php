@extends('layouts.verifikator')

@section('title', 'Verifikasi Pendaftar')
@section('page-title', 'Detail Verifikasi')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('verifikator.verification.index') }}" class="flex items-center text-gray-600 hover:text-gray-900">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Antrian
        </a>
        <div class="text-sm text-gray-500">
            Mendaftar: {{ $applicant->created_at->format('d F Y, H:i') }}
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Data (Left) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Data Diri Card -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Data Diri & Biodata</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase">Nama Lengkap</label>
                        <div class="mt-1 text-base font-semibold text-gray-900">{{ $applicant->full_name }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase">NISN</label>
                        <div class="mt-1 text-base font-mono bg-gray-50 p-1 rounded w-fit">{{ $applicant->nisn }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase">Tempat, Tgl Lahir</label>
                        <div class="mt-1 text-sm text-gray-900">{{ $applicant->birth_place }}, {{ $applicant->birth_date->format('d F Y') }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase">Jenis Kelamin</label>
                        <div class="mt-1 text-sm text-gray-900">{{ $applicant->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-500 uppercase">Alamat Lengkap</label>
                        <div class="mt-1 text-sm text-gray-900">{{ $applicant->address }}</div>
                    </div>
                </div>
            </div>

            <!-- Data Orang Tua -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Data Orang Tua</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase">Nama Orang Tua/Wali</label>
                        <div class="mt-1 text-sm text-gray-900">{{ $applicant->parent_name }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase">Nomor Telepon</label>
                        <div class="mt-1 text-base font-mono text-gray-900">{{ $applicant->parent_phone }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Dokumen Placeholder -->
             <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Dokumen Persyaratan</h3>
                <div class="bg-blue-50 border border-blue-200 rounded p-4 text-center text-blue-800">
                    <svg class="w-10 h-10 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-sm">Belum ada dokumen yang diunggah secara digital.</p>
                </div>
            </div>
        </div>

        <!-- Action Sidebar (Right) -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Jalur Info -->
            <div class="bg-gray-800 text-white rounded-lg p-6 shadow-md">
                <div class="text-xs text-gray-400 uppercase tracking-widest mb-1">Jalur Pendaftaran</div>
                <div class="text-2xl font-bold">{{ $applicant->pathway->name }}</div>
                <div class="mt-4 pt-4 border-t border-gray-700 flex justify-between">
                    <span class="text-gray-400">No. Reg</span>
                    <span class="font-mono font-medium">{{ $applicant->registration_number }}</span>
                </div>
            </div>

            <!-- Verification Action -->
            <div class="card border-0 shadow-lg ring-1 ring-gray-200">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Panel Verifikasi
                </h3>

                @if($applicant->status === 'pending')
                    <div class="space-y-3">
                        <form action="{{ route('verifikator.verification.approve', $applicant) }}" method="POST"
                              onsubmit="return confirm('Apakah Anda yakin data ini VALID dan LENGKAP?');">
                            @csrf
                            <button type="submit" class="btn btn-success w-full justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                SETUJUI / VALID
                            </button>
                        </form>
                        
                        <div x-data="{ open: false }">
                            <button @click="open = !open" type="button" class="btn btn-danger w-full justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                TOLAK / TIDAK VALID
                            </button>

                            <!-- Reject Form Expansion -->
                            <div x-show="open" class="mt-4 pt-4 border-t border-gray-100" x-transition>
                                <form action="{{ route('verifikator.verification.reject', $applicant) }}" method="POST">
                                    @csrf
                                    <div>
                                        <label class="form-label text-xs">Alasan Penolakan (Wajib Diisi)</label>
                                        <textarea name="rejection_reason" rows="3" class="form-input text-sm" 
                                                  placeholder="Jelaskan alasan dokumen ditolak..." required minlength="5"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-danger mt-3 w-full">
                                        Konfirmasi Penolakan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-500">Berkas ini sudah diproses.</p>
                        <div class="mt-2 text-lg font-bold uppercase {{ $applicant->status == 'verified' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $applicant->status == 'verified' ? 'DITERIMA' : 'DITOLAK' }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

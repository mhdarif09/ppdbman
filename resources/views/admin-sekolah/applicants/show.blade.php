@extends('layouts.admin-sekolah')

@section('title', 'Detail Pendaftar')
@section('page-title', 'Detail Pendaftar')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Header Controls -->
    <div class="flex justify-between items-center">
        <a href="{{ route('admin-sekolah.applicants.index') }}" class="flex items-center text-gray-600 hover:text-gray-900">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
        <div class="flex gap-2">
            <!-- Buttons for future actions e.g. Print -->
        </div>
    </div>

    <!-- Status Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center text-2xl font-bold text-gray-500">
                    {{ substr($applicant->full_name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $applicant->full_name }}</h2>
                    <p class="text-gray-600">{{ $applicant->registration_number }} • {{ $applicant->nisn }}</p>
                </div>
            </div>
            <div class="flex flex-col items-end gap-2">
                <div class="text-sm text-gray-500">Status Pendaftaran</div>
                <div>{!! $applicant->status_badge !!}</div>
            </div>
        </div>
        
        <!-- Verification Info -->
        @if($applicant->verified_at)
            <div class="bg-gray-50 px-6 py-3 border-t border-gray-200 text-sm flex justify-between">
                <span class="text-gray-600">
                    Diverifikasi oleh: <span class="font-medium">{{ $applicant->verifier->name ?? '-' }}</span>
                </span>
                <span class="text-gray-600">
                    Tanggal: <span class="font-medium">{{ $applicant->verified_at->format('d F Y H:i') }}</span>
                </span>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="md:col-span-2 space-y-6">
            <!-- Personal Info -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Data Pribadi</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $applicant->full_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">NISN</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $applicant->nisn }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tempat, Tanggal Lahir</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $applicant->birth_place }}, {{ $applicant->birth_date->format('d F Y') }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $applicant->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $applicant->address }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">No. Telepon</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $applicant->phone }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Parent Info -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Data Orang Tua / Wali</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nama Orang Tua</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $applicant->parent_name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">No. Telepon Orang Tua</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $applicant->parent_phone ?? '-' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <!-- Pathway Info -->
            <div class="card bg-primary-50 border border-primary-100">
                <h3 class="text-lg font-semibold text-primary-900 mb-4">Pilihan Jalur</h3>
                <div class="space-y-3">
                    <div>
                        <span class="block text-xs font-medium text-primary-600 uppercase tracking-wide">Jalur Pendaftaran</span>
                        <span class="block text-lg font-bold text-gray-900">{{ $applicant->pathway->name ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-primary-600 uppercase tracking-wide">Tahun Ajaran</span>
                        <span class="block text-sm font-medium text-gray-900">{{ $applicant->academic_year }}</span>
                    </div>
                </div>
            </div>

            <!-- Verification Status (Detail) -->
            @if($applicant->status == 'rejected')
                <div class="card bg-red-50 border border-red-100">
                    <h3 class="text-lg font-semibold text-red-900 mb-2">Alasan Penolakan</h3>
                    <p class="text-sm text-red-800">{{ $applicant->rejection_reason ?? 'Tidak ada catatan' }}</p>
                </div>
            @endif

            @if($applicant->verification_notes)
                <div class="card bg-yellow-50 border border-yellow-100">
                    <h3 class="text-lg font-semibold text-yellow-900 mb-2">Catatan Verifikasi</h3>
                    <p class="text-sm text-yellow-800">{{ $applicant->verification_notes }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

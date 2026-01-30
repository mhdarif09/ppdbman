@extends('layouts.verifikator')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Verifikator')

@section('content')
<div class="space-y-6">
    <!-- Welcome Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Pending Queue -->
        <div class="card border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Antrian Menunggu</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['pending_count'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">Total antrian sistem</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('verifikator.verification.index') }}" class="btn btn-sm btn-primary w-full">PROSES SEKARANG</a>
            </div>
        </div>

        <!-- Verified Today -->
        <div class="card border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Diverifikasi Hari Ini</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['verified_today'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">Kinerja Anda hari ini</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total History -->
        <div class="card border-l-4 border-gray-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Riwayat</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['my_verified_count'] + $stats['my_rejected_count'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">Total berkas diproses</p>
                </div>
                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Queue List -->
    <div class="card">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center justify-between">
            <span>Antrian Prioritas (Masuk Terdahulu)</span>
            <a href="{{ route('verifikator.verification.index') }}" class="text-sm text-primary-600 hover:text-primary-700">Lihat Semua →</a>
        </h3>
        
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Waktu Masuk</th>
                        <th>No. Pendaftaran</th>
                        <th>Nama Siswa</th>
                        <th>Jalur</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingApplicants as $applicant)
                        <tr>
                            <td class="text-sm text-gray-500">
                                {{ $applicant->created_at->diffForHumans() }}
                            </td>
                            <td class="font-mono text-sm">
                                {{ $applicant->registration_number }}
                            </td>
                            <td class="font-medium">
                                {{ $applicant->full_name }}
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $applicant->pathway->name ?? '-' }}</span>
                            </td>
                            <td class="text-right">
                                <a href="{{ route('verifikator.verification.show', $applicant) }}" class="btn btn-sm btn-primary">
                                    Verifikasi
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-500">
                                🎉 Tidak ada antrian pending. Kerja bagus!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

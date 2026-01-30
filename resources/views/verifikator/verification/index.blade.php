@extends('layouts.verifikator')

@section('title', 'Antrian Validasi')
@section('page-title', 'Antrian Validasi')

@section('content')
<div class="space-y-6">
    <!-- Filter -->
    <div class="card">
        <form method="GET" action="{{ route('verifikator.verification.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari Nama / NISN / No. Reg..."
                    class="form-input"
                >
            </div>
            <div class="w-48">
                <select name="pathway" class="form-input">
                    <option value="">Semua Jalur</option>
                    @foreach($pathways as $pathway)
                        <option value="{{ $pathway->id }}" {{ request('pathway') == $pathway->id ? 'selected' : '' }}>
                            {{ $pathway->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-secondary">Filter</button>
        </form>
    </div>

    <!-- Queue Table -->
    <div class="card overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Masuk</th>
                        <th>No. Reg</th>
                        <th>Nama Lengkap</th>
                        <th>Jalur</th>
                        <th>Dokumen</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applicants as $applicant)
                        <tr>
                            <td class="text-sm text-gray-500 whitespace-nowrap">
                                {{ $applicant->created_at->format('d/m H:i') }}
                                <div class="text-xs text-yellow-600 font-medium">
                                    {{ $applicant->created_at->diffForHumans() }}
                                </div>
                            </td>
                            <td class="font-mono text-sm font-medium">
                                {{ $applicant->registration_number }}
                            </td>
                            <td>
                                <div class="font-medium text-gray-900">{{ $applicant->full_name }}</div>
                                <div class="text-xs text-gray-500">{{ $applicant->nisn }}</div>
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $applicant->pathway->name ?? '-' }}</span>
                            </td>
                            <td class="text-sm text-gray-500">
                                <!-- Placeholder for document count, implement later if needed -->
                                -
                            </td>
                            <td class="text-right">
                                <a href="{{ route('verifikator.verification.show', $applicant) }}" class="btn btn-sm btn-primary">
                                    Proses Validasi
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="font-medium">Antrian Kosong</p>
                                    <p class="text-sm">Silakan cek kembali nanti atau lihat riwayat.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($applicants->hasPages())
        <div class="flex justify-center">
            {{ $applicants->links() }}
        </div>
    @endif
</div>
@endsection

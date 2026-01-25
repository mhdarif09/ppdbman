@extends('layouts.admin-sekolah')

@section('title', 'Data Pendaftar')
@section('page-title', 'Data Pendaftar')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Data Pendaftar</h2>
            <p class="text-gray-600 mt-1">Semua data calon siswa yang masuk</p>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card">
        <form method="GET" action="{{ route('admin-sekolah.applicants.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Filter Pathway -->
            <div>
                <label class="form-label mb-1 text-xs">Jalur</label>
                <select name="pathway" class="form-input text-sm">
                    <option value="">Semua Jalur</option>
                    @foreach($pathways as $pathway)
                        <option value="{{ $pathway->id }}" {{ request('pathway') == $pathway->id ? 'selected' : '' }}>
                            {{ $pathway->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Status -->
            <div>
                <label class="form-label mb-1 text-xs">Status</label>
                <select name="status" class="form-input text-sm">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Diterima</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <!-- Search -->
            <div>
                <label class="form-label mb-1 text-xs">Cari</label>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Nama / NISN / No. Reg"
                    class="form-input text-sm"
                >
            </div>

            <!-- Buttons -->
            <div class="flex items-end gap-2">
                <button type="submit" class="btn btn-secondary w-full">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Filter
                </button>
                @if(request()->anyFilled(['pathway', 'status', 'search']))
                    <a href="{{ route('admin-sekolah.applicants.index') }}" class="btn btn-secondary" title="Reset Filter">
                        ✕
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Applicants Table -->
    <div class="card overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>No. Pendaftaran</th>
                        <th>Nama / NISN</th>
                        <th>Jalur</th>
                        <th>Tanggal Daftar</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applicants as $applicant)
                        <tr>
                            <td class="font-mono text-sm text-gray-600">
                                {{ $applicant->registration_number }}
                            </td>
                            <td>
                                <div class="font-medium text-gray-900">{{ $applicant->full_name }}</div>
                                <div class="text-xs text-gray-500">{{ $applicant->nisn }}</div>
                            </td>
                            <td>
                                @if($applicant->pathway)
                                    <span class="px-2 py-1 bg-gray-100 rounded text-xs font-medium text-gray-700">
                                        {{ $applicant->pathway->name }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="text-sm text-gray-600">
                                {{ $applicant->created_at->format('d/m/Y') }}
                            </td>
                            <td>
                                {!! $applicant->status_badge !!}
                            </td>
                            <td>
                                <div class="flex justify-end">
                                    <a href="{{ route('admin-sekolah.applicants.show', $applicant) }}" 
                                       class="btn btn-sm btn-secondary">
                                        Detail
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-gray-500">
                                Tidak ada data pendaftar yang sesuai filter
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($applicants->hasPages())
        <div class="flex justify-center">
            {{ $applicants->links() }}
        </div>
    @endif
</div>
@endsection

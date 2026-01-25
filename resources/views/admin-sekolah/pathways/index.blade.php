@extends('layouts.admin-sekolah')

@section('title', 'Jalur PPDB')
@section('page-title', 'Manajemen Jalur PPDB')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Jalur PPDB</h2>
            <p class="text-gray-600 mt-1">Kelola jalur dan kuota pendaftaran</p>
        </div>
        <a href="{{ route('admin-sekolah.pathways.create') }}" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Tambah Jalur
        </a>
    </div>

    <!-- Pathways Table -->
    <div class="card overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Jalur</th>
                        <th>Quota</th>
                        <th>Terisi</th>
                        <th>Progress</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pathways as $pathway)
                        <tr>
                            <td>
                                <div class="font-medium text-gray-900">{{ $pathway->name }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($pathway->description, 50) }}</div>
                            </td>
                            <td class="font-medium">{{ $pathway->quota }}</td>
                            <td>{{ $pathway->filled }}</td>
                            <td class="w-1/4">
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-primary-600 h-2.5 rounded-full" style="width: {{ $pathway->quota_progress }}%"></div>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">{{ number_format($pathway->quota_progress, 1) }}%</div>
                            </td>
                            <td>
                                @if($pathway->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin-sekolah.pathways.edit', $pathway) }}" 
                                       class="btn btn-sm btn-secondary">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin-sekolah.pathways.destroy', $pathway) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Yakin ingin menghapus jalur ini?')"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" {{ $pathway->filled > 0 ? 'disabled title="Tidak_bisa_hapus_karena_sudah_ada_pendaftar"' : '' }}>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-gray-500">
                                Belum ada jalur PPDB yang dibuat
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($pathways->hasPages())
        <div class="flex justify-center">
            {{ $pathways->links() }}
        </div>
    @endif
</div>
@endsection

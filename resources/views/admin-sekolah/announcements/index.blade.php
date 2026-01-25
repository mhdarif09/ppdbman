@extends('layouts.admin-sekolah')

@section('title', 'Pengumuman')
@section('page-title', 'Manajemen Pengumuman')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Pengumuman</h2>
            <p class="text-gray-600 mt-1">Publikasi hasil seleksi dan informasi penting</p>
        </div>
        <a href="{{ route('admin-sekolah.announcements.create') }}" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Buat Pengumuman
        </a>
    </div>

    <!-- Announcements List -->
    <div class="space-y-4">
        @forelse($announcements as $announcement)
            <div class="card hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">
                            {{ $announcement->title }}
                        </h3>
                        <div class="flex items-center text-sm text-gray-500 mb-2 space-x-4">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $announcement->published_at ? $announcement->published_at->format('d F Y H:i') : 'Draft' }}
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ $announcement->publisher->name ?? 'System' }}
                            </span>
                        </div>
                    </div>
                    <div>
                        @if($announcement->isPublished())
                            <span class="badge badge-success">Terbit</span>
                        @else
                            <span class="badge badge-warning">Draft</span>
                        @endif
                    </div>
                </div>
                
                <div class="text-gray-600 text-sm mb-4 line-clamp-2">
                    {!! strip_tags($announcement->content) !!}
                </div>

                <div class="border-t pt-4 flex justify-between items-center">
                    <div class="text-xs text-gray-500">
                        {{ $announcement->results_count }} Hasil Seleksi Terlampir
                    </div>
                    <form action="{{ route('admin-sekolah.announcements.destroy', $announcement) }}" 
                          method="POST" 
                          onsubmit="return confirm('Yakin ingin menghapus pengumuman ini? Data hasil seleksi yang terlampir juga akan terhapus.')"
                          class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-white rounded-lg border border-gray-200 border-dashed">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada pengumuman</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai buat pengumuman baru untuk hasil seleksi.</p>
                <div class="mt-6">
                    <a href="{{ route('admin-sekolah.announcements.create') }}" class="btn btn-primary">
                        Buat Pengumuman
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($announcements->hasPages())
        <div class="flex justify-center">
            {{ $announcements->links() }}
        </div>
    @endif
</div>
@endsection

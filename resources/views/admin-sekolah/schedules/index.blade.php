@extends('layouts.admin-sekolah')

@section('title', 'Jadwal PPDB')
@section('page-title', 'Manajemen Jadwal PPDB')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Schedule Form -->
    <div class="lg:col-span-1">
        <div class="card sticky top-24">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tambah Jadwal Baru</h3>
            <form action="{{ route('admin-sekolah.schedules.store') }}" method="POST">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label for="name" class="form-label">Nama Kegiatan</label>
                        <input type="text" id="name" name="name" class="form-input" placeholder="Contoh: Pendaftaran Gelombang 1" required>
                    </div>

                    <div>
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" id="start_date" name="start_date" class="form-input" required>
                    </div>

                    <div>
                        <label for="end_date" class="form-label">Tanggal Selesai</label>
                        <input type="date" id="end_date" name="end_date" class="form-input" required>
                    </div>

                    <div>
                        <label for="description" class="form-label">Keterangan</label>
                        <textarea id="description" name="description" rows="3" class="form-input" placeholder="Opsional..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-full">Tambah Jadwal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Timeline & List -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Visual Timeline -->
        <div class="card">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Timeline Kegiatan</h3>
            <div class="relative border-l-2 border-primary-200 ml-3 space-y-8">
                @forelse($schedules as $schedule)
                    <div class="relative pl-8">
                        <!-- Dot -->
                        <span class="absolute top-0 -left-2.5 w-5 h-5 rounded-full border-2 border-white {{ $schedule->isActive() ? 'bg-green-500' : ($schedule->isPast() ? 'bg-gray-400' : 'bg-primary-500') }}"></span>
                        
                        <!-- Content -->
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start group">
                            <div>
                                <h4 class="text-base font-semibold text-gray-900 {{ $schedule->isActive() ? 'text-green-600' : '' }}">
                                    {{ $schedule->name }}
                                </h4>
                                <p class="text-sm text-gray-500 mb-1">
                                    {{ $schedule->start_date->format('d M Y') }} - {{ $schedule->end_date->format('d M Y') }}
                                </p>
                                @if($schedule->description)
                                    <p class="text-sm text-gray-600 bg-gray-50 p-2 rounded mt-1 inline-block">
                                        {{ $schedule->description }}
                                    </p>
                                @endif
                                
                                @if($schedule->isActive())
                                    <span class="badge badge-success mt-2">Sedang Berlangsung</span>
                                @elseif($schedule->isPast())
                                    <span class="badge badge-secondary mt-2">Selesai</span>
                                @else
                                    <span class="badge badge-info mt-2">Akan Datang</span>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="mt-2 sm:mt-0 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button onclick="editSchedule({{ $schedule->id }}, '{{ $schedule->name }}', '{{ $schedule->start_date->format('Y-m-d') }}', '{{ $schedule->end_date->format('Y-m-d') }}', '{{ $schedule->description }}')" 
                                        class="text-blue-600 hover:text-blue-800 text-sm">
                                    Edit
                                </button>
                                <form action="{{ route('admin-sekolah.schedules.destroy', $schedule) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Hapus jadwal ini?')"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="pl-8 text-gray-500 italic">Belum ada jadwal yang diatur.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal (Simple Implementation using Alpine) -->
<div x-data="{ open: false, id: '', name: '', start: '', end: '', desc: '' }" 
     @edit-schedule.window="open = true; id = $event.detail.id; name = $event.detail.name; start = $event.detail.start; end = $event.detail.end; desc = $event.detail.desc"
     x-show="open" 
     style="display: none;"
     class="fixed inset-0 z-50 overflow-y-auto" 
     aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="open = false"></div>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <form :action="`/admin-sekolah/schedules/${id}`" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4" id="modal-title">Edit Jadwal</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="form-label">Nama Kegiatan</label>
                            <input type="text" name="name" x-model="name" class="form-input" required>
                        </div>
                        <div>
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="start_date" x-model="start" class="form-input" required>
                        </div>
                        <div>
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="end_date" x-model="end" class="form-input" required>
                        </div>
                        <div>
                            <label class="form-label">Keterangan</label>
                            <textarea name="description" x-model="desc" rows="3" class="form-input"></textarea>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Simpan Perubahan
                    </button>
                    <button type="button" @click="open = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:text-gray-500 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editSchedule(id, name, start, end, desc) {
        window.dispatchEvent(new CustomEvent('edit-schedule', {
            detail: { id, name, start, end, desc }
        }));
    }
</script>
@endsection

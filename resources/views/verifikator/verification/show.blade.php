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

            <!-- Data Pendidikan -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Data Pendidikan (Asal Sekolah)</h3>
                
                @if($applicant->education)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-500 uppercase">Nama Sekolah Asal</label>
                        <div class="mt-1 text-base font-semibold text-gray-900">{{ $applicant->education->previous_school_name }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase">Nomor STTB</label>
                        <div class="mt-1 text-sm text-gray-900">{{ $applicant->education->sttb_number ?? '-' }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase">Tanggal STTB</label>
                        <div class="mt-1 text-sm text-gray-900">{{ $applicant->education->sttb_date ? $applicant->education->sttb_date->format('d F Y') : '-' }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase">Lama Belajar</label>
                        <div class="mt-1 text-sm text-gray-900">{{ $applicant->education->study_duration }} Tahun</div>
                    </div>
                    <div class="md:col-span-2">
                         @if($applicant->education->is_transfer)
                            <div class="bg-yellow-50 p-3 rounded border border-yellow-200 text-sm text-yellow-800">
                                <strong>Status Pindahan:</strong> Ya, dari {{ $applicant->education->transfer_from_school }}<br>
                                Alasan: {{ $applicant->education->transfer_reason }}
                            </div>
                         @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Siswa Baru (Bukan Pindahan)
                            </span>
                         @endif
                    </div>
                </div>
                @else
                    <p class="text-gray-500 italic">Data pendidikan belum diisi.</p>
                @endif
            </div>

            <!-- Data Nilai Rapor -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Data Nilai Rapor</h3>
                
                @if($applicant->grades && $applicant->grades->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Rata-rata</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($applicant->grades->sortBy('semester') as $grade)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    Semester {{ $grade->semester }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($grade->grade, 2) }}
                                </td>
                            </tr>
                            @endforeach
                            <!-- Average Row -->
                            <tr class="bg-gray-50 font-bold">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rata-rata Keseluruhan</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($applicant->grades->avg('grade'), 2) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @else
                    <p class="text-gray-500 italic">Data nilai rapor belum diisi.</p>
                @endif
            </div>

            <!-- Data Tambahan (Hobi & Perkembangan) -->
             <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Data Tambahan</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-medium text-gray-700 mb-2">Hobi & Kegemaran</h4>
                        @if($applicant->hobby)
                        <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                            <li>Kesenian: {{ $applicant->hobby->arts ?? '-' }}</li>
                            <li>Olahraga: {{ $applicant->hobby->sports ?? '-' }}</li>
                            <li>Organisasi: {{ $applicant->hobby->organization ?? '-' }}</li>
                            <li>Lainnya: {{ $applicant->hobby->other ?? '-' }}</li>
                        </ul>
                        @else
                            <p class="text-xs text-gray-400">Tidak ada data hobi.</p>
                        @endif
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-700 mb-2">Perkembangan Siswa</h4>
                        @if($applicant->development)
                        <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                            <li>Beasiswa: {{ $applicant->development->scholarships ?? '-' }}</li>
                            <li>Prestasi: {{ $applicant->development->achievements ?? '-' }}</li>
                            <li>Pernah Tinggal Kelas: {{ $applicant->development->leave_year ? 'Ya (' . $applicant->development->leave_year . ' tahun)' : 'Tidak' }}</li>
                        </ul>
                        @else
                            <p class="text-xs text-gray-400">Tidak ada data perkembangan.</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Dokumen Persyaratan -->
             <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Dokumen Persyaratan (Checklist Siswa)</h3>
                
                @if($applicant->documents_checklist)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @php
                            $labels = [
                                'printout' => 'Cetak Bukti Pendaftaran',
                                'raport' => 'Fotokopi Nilai Rapor',
                                'kk' => 'Fotokopi Kartu Keluarga',
                                'akte' => 'Fotokopi Akte Kelahiran',
                                'photos_2x3' => 'Pas Foto 2x3 (3 Lembar)',
                                'photos_3x4' => 'Pas Foto 3x4 (3 Lembar)'
                            ];
                        @endphp
                        
                        @foreach($labels as $key => $label)
                            <div class="flex items-center p-3 rounded border {{ isset($applicant->documents_checklist[$key]) ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }}">
                                <div class="flex-shrink-0 mr-3">
                                    @if(isset($applicant->documents_checklist[$key]))
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    @endif
                                </div>
                                <span class="text-sm font-medium {{ isset($applicant->documents_checklist[$key]) ? 'text-green-800' : 'text-gray-500' }}">
                                    {{ $label }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded p-4 text-center text-yellow-800">
                        <p class="text-sm">Data checklist dokumen tidak ditemukan.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Action Sidebar (Right) -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Jalur Info -->
            <div class="bg-gray-800 text-white rounded-lg p-6 shadow-md">
                <div class="text-xs text-gray-400 uppercase tracking-widest mb-1">Jalur Pendaftaran</div>
                <div class="text-2xl font-bold">{{ $applicant->pathway->name ?? 'Tidak ada jalur' }}</div>
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

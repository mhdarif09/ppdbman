@extends('layouts.admin-sekolah')

@section('title', 'Laporan')
@section('page-title', 'Laporan & Export Data')

@section('content')
<div class="max-w-4xl">
    <div class="card bg-white shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Filter Data Laporan</h3>
            <p class="text-sm text-gray-500 mt-1">Pilih kriteria data yang ingin diexport</p>
        </div>
        
        <div class="p-6">
            <form id="exportForm" action="" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Pathway -->
                    <div>
                        <label class="form-label">Jalur PPDB</label>
                        <select name="pathway" class="form-input">
                            <option value="">Semua Jalur</option>
                            @foreach($pathways as $pathway)
                                <option value="{{ $pathway->id }}">{{ $pathway->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="form-label">Status Pendaftaran</label>
                        <select name="status" class="form-input">
                            <option value="">Semua Status</option>
                            <option value="pending">Menunggu</option>
                            <option value="verified">Terverifikasi</option>
                            <option value="accepted">Diterima</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>

                    <!-- Date Range -->
                    <div>
                        <label class="form-label">Dari Tanggal</label>
                        <input type="date" name="date_from" class="form-input">
                    </div>

                    <div>
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" name="date_to" class="form-input">
                    </div>
                </div>

                <div class="mt-8 flex gap-4">
                    <button type="submit" 
                            onclick="document.getElementById('exportForm').action='{{ route('admin-sekolah.reports.export-excel') }}'"
                            class="btn btn-success flex-1 flex justify-center items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Download Excel
                    </button>

                    <button type="submit" 
                            onclick="document.getElementById('exportForm').action='{{ route('admin-sekolah.reports.export-csv') }}'"
                            class="btn btn-primary flex-1 flex justify-center items-center bg-blue-600 hover:bg-blue-700 text-white">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Download CSV
                    </button>
                    
                    <button type="submit" 
                            onclick="document.getElementById('exportForm').action='{{ route('admin-sekolah.reports.export-pdf') }}'"
                            class="btn btn-danger flex-1 flex justify-center items-center bg-red-600 hover:bg-red-700 text-white">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        Download PDF
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Box -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <div class="text-sm text-blue-800">
                <p><strong>Tips:</strong> Kosongkan semua filter untuk mendownload seluruh data pendaftar.</p>
            </div>
        </div>
    </div>
</div>
@endsection

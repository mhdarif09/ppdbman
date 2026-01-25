@extends('layouts.guest')

@section('title', 'Beranda')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-primary-50 to-white">
    <!-- Header  -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-primary-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                        P
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">{{ \App\Models\SystemSetting::get('school_name', 'SMA Negeri 1') }}</h1>
                        <p class="text-sm text-gray-600">Sistem PPDB Online</p>
                    </div>
                </div>
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Login
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Penerimaan Peserta Didik Baru
            </h2>
            <p class="text-xl text-gray-600 mb-2">
                Tahun Ajaran {{ \App\Models\SystemSetting::get('academic_year_active', '2024/2025') }}
            </p>
            
            @php
                $ppdbStatus = \App\Models\SystemSetting::get('ppdb_status', 'closed');
            @endphp
            
            <div class="mt-6">
                @if($ppdbStatus === 'open')
                    <span class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-full font-medium">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Pendaftaran Dibuka
                    </span>
                @else
                    <span class="inline-flex items-center px-4 py-2 bg-red-100 text-red-800 rounded-full font-medium">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        Pendaftaran Ditutup
                    </span>
                @endif
            </div>
            
            <div class="mt-12">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-8 py-4 text-lg">
                    Mulai Pendaftaran
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Pendaftaran Online</h3>
                <p class="text-gray-600">Daftar kapan saja, dimana saja dengan sistem online yang mudah dan cepat.</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Verifikasi Cepat</h3>
                <p class="text-gray-600">Proses verifikasi dokumen yang transparan dan real-time.</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Notifikasi</h3>
                <p class="text-gray-600">Dapatkan update status pendaftaran langsung ke email Anda.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-gray-600">
                <p>&copy; {{ date('Y') }} {{ \App\Models\SystemSetting::get('school_name', 'SMA Negeri 1') }}. All rights reserved.</p>
                <p class="mt-2 text-sm">
                    Kontak: {{ \App\Models\SystemSetting::get('contact_email', 'ppdb@sekolah.sch.id') }} | 
                    {{ \App\Models\SystemSetting::get('contact_phone', '021-12345678') }}
                </p>
            </div>
        </div>
    </footer>
</div>
@endsection

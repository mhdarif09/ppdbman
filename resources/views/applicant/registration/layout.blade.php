@extends('layouts.guest')

@section('title', 'Form Pendaftaran - PPDB MAN 1 Palembang')

@section('content')
<div class="min-h-screen bg-slate-50 font-sans antialiased">
    <!-- Clean Modern Header -->
    <header class="bg-white/80 backdrop-blur-xl sticky top-0 z-50 border-b border-slate-200/60">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-sm sm:text-base font-bold text-slate-900 leading-tight">PPDB MAN 1</h1>
                        <p class="text-[10px] sm:text-xs text-slate-500">Formulir Pendaftaran</p>
                    </div>
                </div>
                
                <!-- User -->
                <div class="flex items-center gap-4">
                    <div class="hidden sm:block text-right">
                        <p class="text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-emerald-600">{{ $applicant->pathway->name ?? 'Calon Siswa' }}</p>
                    </div>
                    <a href="{{ route('applicant.dashboard') }}" 
                       class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-8">
        @php
            $currentStep = $step ?? 1;
            $maxStep = $applicant->registration_step ?? 1;
            $stepData = [
                1 => ['title' => 'Identitas Diri', 'desc' => 'Data pribadi, psikis & intellectual'],
                2 => ['title' => 'Riwayat Pendidikan', 'desc' => 'Nilai rapor & prestasi lomba'],
                3 => ['title' => 'Data Orang Tua', 'desc' => 'Informasi keluarga'],
                4 => ['title' => 'Minat & Bakat', 'desc' => 'Hobi dan potensi'],
                5 => ['title' => 'Finalisasi', 'desc' => 'Checklist dokumen & submit']
            ];
        @endphp

        <!-- Step Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                        Langkah {{ $currentStep }} dari 5
                    </span>
                </div>
                <span class="text-sm font-medium text-slate-500">{{ round(($currentStep/5)*100) }}% selesai</span>
            </div>
            
            <!-- Progress Steps -->
            <div class="flex gap-2">
                @for($i = 1; $i <= 5; $i++)
                    <div class="flex-1 h-2 rounded-full transition-all duration-500 {{ $i <= $currentStep ? 'bg-emerald-500' : 'bg-slate-200' }}"></div>
                @endfor
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar Navigation (Hidden on Mobile) -->
            <aside class="hidden lg:block lg:col-span-1">
                <nav class="space-y-1">
                    @foreach($stepData as $num => $data)
                        @php
                            $isActive = $num == $currentStep;
                            $isCompleted = $num < $currentStep;
                            $isAccessible = $num <= $maxStep;
                        @endphp
                        <a href="{{ $isAccessible ? route('applicant.registration.step', $num) : '#' }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                                  {{ $isActive ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/25' : 
                                     ($isAccessible ? 'hover:bg-slate-100 text-slate-600' : 'text-slate-300 cursor-not-allowed') }}">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold
                                        {{ $isActive ? 'bg-white/20 text-white' : 
                                           ($isCompleted ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-400') }}">
                                @if($isCompleted && !$isActive)
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    {{ $num }}
                                @endif
                            </div>
                            <div class="hidden lg:block">
                                <p class="text-sm font-semibold {{ $isActive ? 'text-white' : '' }}">{{ $data['title'] }}</p>
                                <p class="text-xs {{ $isActive ? 'text-white/70' : 'text-slate-400' }}">{{ $data['desc'] }}</p>
                            </div>
                        </a>
                    @endforeach
                </nav>
            </aside>

            <!-- Main Form Area -->
            <div class="lg:col-span-3">
                <!-- Form Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
                    <!-- Form Header -->
                    <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
                        <h2 class="text-xl font-bold text-slate-900">{{ $stepData[$currentStep]['title'] }}</h2>
                        <p class="text-sm text-slate-500 mt-1">{{ $stepData[$currentStep]['desc'] }}</p>
                    </div>

                    <!-- Alert Messages -->
                    @if(session('success'))
                        <div class="mx-6 mt-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3">
                            <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mx-6 mt-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-red-800">Mohon perbaiki kesalahan berikut:</p>
                            </div>
                            <ul class="ml-11 text-sm text-red-600 list-disc">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form Content -->
                    <div class="p-4 sm:p-6 form-wrapper">
                        @yield('form')
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>


<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

@endsection
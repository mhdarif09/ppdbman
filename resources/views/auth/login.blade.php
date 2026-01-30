
@extends('layouts.guest')

@section('title', 'Masuk - PPDB MAN 1 Palembang')

@section('content')
<div class="min-h-screen flex bg-white font-sans antialiased overflow-hidden">
    <!-- Left Section: Immersive Graphics (Hidden on mobile) -->
    <div class="hidden lg:flex lg:w-1/2 bg-[#004d2c] relative items-center justify-center p-12 overflow-hidden">
        <!-- Abstract Decorations -->
        <div class="absolute top-0 left-0 w-full h-full opacity-20 pointer-events-none">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-green-400 rounded-full blur-[100px] animate-pulse"></div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-emerald-500 rounded-full blur-[100px] animate-pulse"></div>
        </div>
        
        <div class="relative z-10 text-center space-y-8 max-w-lg">
            <div class="inline-block p-4 bg-white/10 backdrop-blur-xl rounded-[2.5rem] border border-white/20 shadow-2xl transform hover:scale-105 transition duration-500">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Kemenag" class="h-24 w-auto drop-shadow-2xl">
            </div>
            
            <div class="space-y-4">
                <h1 class="text-6xl font-black text-white leading-tight tracking-tighter uppercase italic">
                    SELAMAT <span class="text-green-400">DATANG</span>
                </h1>
                <p class="text-green-100 text-lg font-medium leading-relaxed opacity-80">
                    Akses dashboard pendaftaran Anda dan pantau status verifikasi secara real-time.
                </p>
            </div>

            <!-- Illustration -->
            <div class="relative group">
                <div class="absolute inset-0 bg-green-400/20 blur-3xl rounded-full scale-75 group-hover:scale-100 transition duration-700"></div>
                <img src="{{ asset('images/siswa.png') }}" alt="Siswa MAN 1 Palembang" class="relative z-10 w-full max-w-sm mx-auto drop-shadow-[0_35px_35px_rgba(0,0,0,0.5)] transform rotate-3 group-hover:rotate-0 transition duration-700">
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 gap-4 pt-12">
                <div class="p-6 bg-white/5 backdrop-blur-md rounded-3xl border border-white/10">
                    <p class="text-3xl font-black text-white">100%</p>
                    <p class="text-[10px] text-green-300 font-bold uppercase tracking-widest mt-1">Transparan</p>
                </div>
                <div class="p-6 bg-white/5 backdrop-blur-md rounded-3xl border border-white/10">
                    <p class="text-3xl font-black text-white">REAL</p>
                    <p class="text-[10px] text-green-300 font-bold uppercase tracking-widest mt-1">Time Status</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Section: Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 md:p-16 lg:p-24 bg-[#f8fafc] overflow-y-auto">
        <div class="w-full max-w-md space-y-12">
            <!-- Mobile Header -->
            <div class="lg:hidden text-center mb-8">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Kemenag" class="h-16 w-auto mx-auto mb-4">
                <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tighter">MAN 1 PALEMBANG</h2>
            </div>

            <div class="space-y-3">
                <h2 class="text-4xl font-black text-gray-900 tracking-tighter uppercase leading-none">Masuk Akun</h2>
                <p class="text-sm font-bold text-gray-400 uppercase tracking-[0.2em]">Silakan masuk untuk melanjutkan</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-8">
                @csrf
                
                <div class="space-y-6">
                    <!-- Email -->
                    <div class="group">
                        <label for="email" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 group-focus-within:text-green-600 transition">Email</label>
                        <div class="relative">
                            <input type="email" name="email" id="email" required autofocus value="{{ old('email') }}"
                                   class="block w-full px-7 py-5 bg-white border-2 border-gray-100 rounded-[1.5rem] font-bold text-gray-900 placeholder-gray-300 focus:outline-none focus:border-green-500 focus:ring-4 focus:ring-green-50/50 transition duration-200"
                                   placeholder="nama@email.com">
                            <div class="absolute right-7 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-green-500 transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                            </div>
                        </div>
                        @error('email')<p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wide">{{ $message }}</p>@enderror
                    </div>

                    <!-- Password -->
                    <div class="group">
                        <div class="flex items-center justify-between mb-3">
                            <label for="password" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-green-600 transition">Password</label>
                        </div>
                        <div class="relative">
                            <input type="password" name="password" id="password" required
                                   class="block w-full px-7 py-5 bg-white border-2 border-gray-100 rounded-[1.5rem] font-bold text-gray-900 placeholder-gray-300 focus:outline-none focus:border-green-500 focus:ring-4 focus:ring-green-50/50 transition duration-200"
                                   placeholder="••••••••">
                            <div class="absolute right-7 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-green-500 transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                        </div>
                        @error('password')<p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wide">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center group cursor-pointer">
                            <input type="checkbox" name="remember" class="sr-only peer">
                            <div class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-lg flex items-center justify-center peer-checked:bg-green-500 peer-checked:border-green-500 transition-all">
                                <svg class="w-4 h-4 text-white hidden peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="ml-3 text-[10px] font-black text-gray-400 uppercase tracking-widest group-hover:text-gray-600 transition">Ingat Saya</span>
                        </label>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit"
                            class="w-full relative group overflow-hidden bg-green-700 text-white py-6 px-6 rounded-[1.5rem] font-black text-sm uppercase tracking-widest shadow-[0_20px_40px_-15px_rgba(0,0,0,0.3)] hover:shadow-green-200 transition-all duration-300 transform hover:-translate-y-1 active:scale-95">
                        <span class="relative z-10 flex justify-center items-center gap-2">
                            Masuk Ke Dashboard
                            <svg class="w-6 h-6 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-emerald-600 opacity-0 group-hover:opacity-100 transition duration-500"></div>
                    </button>
                    
                    <!-- Demo Account Info -->
                    <div class="mt-8 p-6 bg-gray-50 rounded-[1.5rem] border-2 border-dashed border-gray-200 text-center">
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em] mb-2">Akun Percobaan (Demo)</p>
                        <div class="space-y-1">
                            <p class="text-[11px] font-black text-gray-600">ADMIN: <span class="text-green-700">superadmin@ppdb.test</span></p>
                            <p class="text-[11px] font-black text-gray-600">PASSWORD: <span class="text-green-700">password</span></p>
                        </div>
                    </div>

                    <p class="mt-10 text-center text-[11px] font-bold text-gray-400 uppercase tracking-widest">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-green-700 hover:text-green-800 underline underline-offset-4 ml-1">Daftar Tahap Awal</a>
                    </p>
                </div>
            </form>

            <!-- Footer Links -->
            <div class="pt-8 flex justify-center">
                <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 text-[10px] font-black text-gray-400 hover:text-gray-900 uppercase tracking-[0.2em] transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Beranda Utama
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

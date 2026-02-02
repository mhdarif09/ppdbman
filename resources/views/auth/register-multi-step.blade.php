
@extends('layouts.guest')

@section('title', 'Pendaftaran - PMB MAN 1 Palembang')

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
                <h1 class="text-5xl font-black text-white leading-tight tracking-tighter uppercase italic">
                    Wujudkan Masa Depan <span class="text-green-400">Gemilang</span>
                </h1>
                <p class="text-green-100 text-lg font-medium leading-relaxed opacity-80">
                    Bergabunglah bersama keluarga besar MAN 1 Palembang dan mulailah perjalanan akademis terbaikmu di sini.
                </p>
            </div>

            <!-- Illustration -->
            <div class="relative group">
                <div class="absolute inset-0 bg-green-400/20 blur-3xl rounded-full scale-75 group-hover:scale-100 transition duration-700"></div>
                <img src="{{ asset('images/siswa.png') }}" alt="Siswa MAN 1 Palembang" class="relative z-10 w-full max-w-sm mx-auto drop-shadow-[0_35px_35px_rgba(0,0,0,0.5)] transform -rotate-3 group-hover:rotate-0 transition duration-700">
            </div>

            <!-- Trust Badges -->
            <div class="flex items-center justify-center gap-6 pt-8">
                <div class="flex flex-col items-center">
                    <span class="text-white font-black text-2xl">95%</span>
                    <span class="text-green-300 text-[10px] font-bold uppercase tracking-widest">Alumni Sukses</span>
                </div>
                <div class="w-px h-8 bg-white/20"></div>
                <div class="flex flex-col items-center">
                    <span class="text-white font-black text-2xl">A+</span>
                    <span class="text-green-300 text-[10px] font-bold uppercase tracking-widest">Akreditasi</span>
                </div>
                <div class="w-px h-8 bg-white/20"></div>
                <div class="flex flex-col items-center">
                    <span class="text-white font-black text-2xl">2024</span>
                    <span class="text-green-300 text-[10px] font-bold uppercase tracking-widest">Angkatan Baru</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Section: Registration Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 md:p-16 lg:p-24 bg-[#f8fafc] overflow-y-auto">
        <div class="w-full max-w-md space-y-10">
            <!-- Mobile Header -->
            <div class="lg:hidden text-center mb-8">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Kemenag" class="h-16 w-auto mx-auto mb-4">
                <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tighter">MAN 1 PALEMBANG</h2>
            </div>

            <div class="space-y-2">
                <h2 class="text-4xl font-black text-gray-900 tracking-tighter uppercase leading-none">Buat Akun</h2>
                <p class="text-sm font-bold text-gray-400 uppercase tracking-[0.2em]">Lengkapi data untuk memulai pendaftaran</p>
            </div>

            <form action="{{ route('register.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 gap-5">
                    <!-- NISN -->
                    <div class="group">
                        <label for="nisn" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 group-focus-within:text-green-600 transition">NISN</label>
                        <div class="relative">
                            <input type="text" name="nisn" id="nisn" required maxlength="10" value="{{ old('nisn') }}"
                                   class="block w-full px-6 py-4 bg-white border-2 border-gray-100 rounded-2xl font-bold text-gray-900 placeholder-gray-300 focus:outline-none focus:border-green-500 focus:ring-4 focus:ring-green-50/50 transition duration-200"
                                   placeholder="Nomor Induk Siswa Nasional">
                            <div class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-green-500 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </div>
                        </div>
                        @error('nisn')<p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wide">{{ $message }}</p>@enderror
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="group">
                        <label for="full_name" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 group-focus-within:text-green-600 transition">Nama Lengkap</label>
                        <div class="relative">
                            <input type="text" name="full_name" id="full_name" required value="{{ old('full_name') }}"
                                   class="block w-full px-6 py-4 bg-white border-2 border-gray-100 rounded-2xl font-bold text-gray-900 placeholder-gray-300 focus:outline-none focus:border-green-500 focus:ring-4 focus:ring-green-50/50 transition duration-200"
                                   placeholder="Sesuai Ijazah / Akta">
                            <div class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-green-500 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                        </div>
                        @error('full_name')<p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wide">{{ $message }}</p>@enderror
                    </div>

                    <!-- Email -->
                    <div class="group">
                        <label for="email" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 group-focus-within:text-green-600 transition">Email Aktif</label>
                        <div class="relative">
                            <input type="email" name="email" id="email" required value="{{ old('email') }}"
                                   class="block w-full px-6 py-4 bg-white border-2 border-gray-100 rounded-2xl font-bold text-gray-900 placeholder-gray-300 focus:outline-none focus:border-green-500 focus:ring-4 focus:ring-green-50/50 transition duration-200"
                                   placeholder="contoh@email.com">
                            <div class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-green-500 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                        </div>
                        @error('email')<p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wide">{{ $message }}</p>@enderror
                    </div>

                    <!-- Passwords -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="group">
                            <label for="password" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 group-focus-within:text-green-600 transition">Password</label>
                            <input type="password" name="password" id="password" required minlength="8"
                                   class="block w-full px-6 py-4 bg-white border-2 border-gray-100 rounded-2xl font-bold text-gray-900 placeholder-gray-300 focus:outline-none focus:border-green-500 focus:ring-4 focus:ring-green-50/50 transition duration-200"
                                   placeholder="••••••••">
                        </div>
                        <div class="group">
                            <label for="password_confirmation" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 group-focus-within:text-green-600 transition">Konfirmasi</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8"
                                   class="block w-full px-6 py-4 bg-white border-2 border-gray-100 rounded-2xl font-bold text-gray-900 placeholder-gray-300 focus:outline-none focus:border-green-500 focus:ring-4 focus:ring-green-50/50 transition duration-200"
                                   placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit"
                            class="w-full relative group overflow-hidden bg-green-700 text-white py-5 px-6 rounded-2xl font-black text-sm uppercase tracking-widest shadow-[0_20px_40px_-15px_rgba(0,0,0,0.3)] hover:shadow-green-200 transition-all duration-300 transform hover:-translate-y-1 active:scale-95">
                        <span class="relative z-10 flex justify-center items-center gap-2">
                            Mulai Pendaftaran
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-emerald-600 opacity-0 group-hover:opacity-100 transition duration-500"></div>
                    </button>
                    
                    <p class="mt-8 text-center text-[11px] font-bold text-gray-400 uppercase tracking-widest">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-green-700 hover:text-green-800 underline underline-offset-4 ml-1">Masuk Sekarang</a>
                    </p>
                </div>
            </form>

            <!-- Footer Links -->
            <div class="pt-10 flex justify-center">
                <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 text-[10px] font-black text-gray-400 hover:text-gray-900 uppercase tracking-[0.2em] transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector('form').addEventListener('submit', function() {
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<span class="flex items-center justify-center gap-2 uppercase tracking-widest"><svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...</span>';
        btn.classList.add('bg-green-800', 'opacity-80');
    });
</script>
@endsection

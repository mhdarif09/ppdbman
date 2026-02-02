
@extends('layouts.guest')

@section('title', 'Beranda - PMB Online MAN 1 Palembang')

@section('content')
<div class="font-sans antialiased text-gray-900 bg-white" x-data="{ scrolled: false, mobileMenuOpen: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">
    
    <!-- Navbar -->
    <nav :class="{'bg-white/95 backdrop-blur-md shadow-lg': scrolled, 'bg-white shadow-sm': !scrolled}" class="fixed top-0 w-full z-50 transition-all duration-300 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo MAN 1" class="h-12 w-auto">
                    <div class="leading-tight">
                        <h1 class="text-lg font-bold text-green-800 tracking-tight">MAN 1 PALEMBANG</h1>
                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">Unggul dalam Imtaq & Iptek</p>
                    </div>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#beranda" class="text-sm font-semibold text-gray-600 hover:text-green-700 transition">Beranda</a>
                    <a href="#visi" class="text-sm font-semibold text-gray-600 hover:text-green-700 transition">Visi Misi</a>
                    <a href="#jalur" class="text-sm font-semibold text-gray-600 hover:text-green-700 transition">Jalur</a>
                    <a href="#fasilitas" class="text-sm font-semibold text-gray-600 hover:text-green-700 transition">Fasilitas</a>
                    <a href="#faq" class="text-sm font-semibold text-gray-600 hover:text-green-700 transition">FAQ</a>
                    
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center bg-green-700 hover:bg-green-800 text-white px-6 py-2.5 rounded-full font-bold shadow-lg shadow-green-200 transition transform hover:-translate-y-0.5">
                            Dashboard
                        </a>
                    @else
                        <div class="flex items-center gap-4 border-l pl-8 border-gray-200">
                            <a href="{{ route('login') }}" class="text-sm font-bold text-gray-700 hover:text-green-700">Masuk</a>
                            <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-full font-bold shadow-md shadow-green-100 transition transition-all">
                                Daftar
                            </a>
                        </div>
                    @endauth
                </div>
                
                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-600 hover:text-green-700 focus:outline-none">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Panel -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="md:hidden bg-white border-t border-gray-100 absolute w-full shadow-2xl pb-6">
            <div class="px-4 pt-4 space-y-2">
                <a href="#beranda" @click="mobileMenuOpen = false" class="block px-4 py-3 text-base font-bold text-gray-700 hover:bg-green-50 hover:text-green-700 rounded-xl transition">Beranda</a>
                <a href="#visi" @click="mobileMenuOpen = false" class="block px-4 py-3 text-base font-bold text-gray-700 hover:bg-green-50 hover:text-green-700 rounded-xl transition">Visi Misi</a>
                <a href="#jalur" @click="mobileMenuOpen = false" class="block px-4 py-3 text-base font-bold text-gray-700 hover:bg-green-50 hover:text-green-700 rounded-xl transition">Jalur</a>
                <a href="#fasilitas" @click="mobileMenuOpen = false" class="block px-4 py-3 text-base font-bold text-gray-700 hover:bg-green-50 hover:text-green-700 rounded-xl transition">Fasilitas</a>
                <a href="#faq" @click="mobileMenuOpen = false" class="block px-4 py-3 text-base font-bold text-gray-700 hover:bg-green-50 hover:text-green-700 rounded-xl transition">FAQ</a>
                <div class="pt-4 flex flex-col gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="w-full text-center bg-green-700 text-white font-bold py-4 rounded-xl shadow-lg">Buka Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="w-full text-center bg-green-700 text-white font-bold py-4 rounded-xl shadow-lg">Daftar Sekarang</a>
                        <a href="{{ route('login') }}" class="w-full text-center bg-white text-gray-700 border border-gray-200 font-bold py-4 rounded-xl">Masuk ke Akun</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-gradient-to-br from-green-50 via-white to-emerald-50">
        <!-- Floating Elements Decoration -->
        <div class="absolute top-0 right-0 -mr-24 -mt-24 w-[500px] h-[500px] rounded-full bg-green-200/30 blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 left-0 -ml-24 -mb-24 w-[400px] h-[400px] rounded-full bg-emerald-200/30 blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="text-center lg:text-left space-y-8">
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-green-100 text-green-800 text-sm font-bold border border-green-200 mb-2">
                        <span class="relative flex h-3 w-3 mr-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                        </span>
                        STATUS: PENDAFTARAN DIBUKA
                    </div>
                    
                    <h1 class="text-5xl lg:text-7xl font-extrabold text-gray-900 leading-[1.1] tracking-tight">
                        Masa Depan Cerah Dimulai di <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-700 to-emerald-600">MAN 1 Palembang</span>
                    </h1>
                    
                    <p class="text-xl text-gray-600 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Madrasah Aliyah Negeri Unggulan yang memadukan kedalaman ilmu agama dengan kecanggihan teknologi serta prestasi global.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        @auth
                            <a href="{{ route('dashboard') }}" class="group bg-green-700 hover:bg-green-800 text-white text-lg px-10 py-5 rounded-2xl shadow-[0_20px_50px_rgba(21,128,61,0.3)] hover:shadow-[0_20px_50px_rgba(21,128,61,0.4)] transition-all transform hover:-translate-y-1 font-bold flex items-center justify-center">
                                Lanjutkan Registrasi
                                <svg class="w-6 h-6 ml-2 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="group bg-green-700 hover:bg-green-800 text-white text-lg px-10 py-5 rounded-2xl shadow-[0_20px_50px_rgba(21,128,61,0.3)] transition-all transform hover:-translate-y-1 font-bold flex items-center justify-center">
                                Mulai Daftar
                                <svg class="w-6 h-6 ml-2 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                            <a href="#alur" class="bg-white/80 backdrop-blur text-gray-800 border-2 border-green-100 hover:border-green-200 text-lg px-10 py-5 rounded-2xl shadow-sm hover:shadow-md transition-all font-bold flex items-center justify-center">
                                Lihat Alur
                            </a>
                        @endauth
                    </div>
                    
                    <div class="pt-8 grid grid-cols-3 gap-4 text-center lg:text-left">
                        <div class="p-4 bg-white/50 rounded-2xl border border-white">
                            <div class="text-3xl font-black text-green-800">A+</div>
                            <div class="text-[10px] uppercase font-bold text-gray-500 tracking-widest">Akreditasi</div>
                        </div>
                        <div class="p-4 bg-white/50 rounded-2xl border border-white">
                            <div class="text-3xl font-black text-green-800">100%</div>
                            <div class="text-[10px] uppercase font-bold text-gray-500 tracking-widest">Digital Learning</div>
                        </div>
                        <div class="p-4 bg-white/50 rounded-2xl border border-white">
                            <div class="text-3xl font-black text-green-800">50+</div>
                            <div class="text-[10px] uppercase font-bold text-gray-500 tracking-widest">Extra Kulikuler</div>
                        </div>
                    </div>
                </div>
                
                <div class="relative group">
                    <div class="absolute inset-0 bg-green-600 rounded-3xl rotate-3 scale-105 opacity-10 group-hover:rotate-6 transition duration-500"></div>
                    <div class="-rotate-3 group-hover:rotate-0 transition duration-500 relative overflow-hidden rounded-3xl shadow-2xl border-4 border-white">
                         <img src="{{ asset('images/siswa.png') }}" class="w-full h-auto object-cover" alt="Siswa MAN 1 Palembang">
                         <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 p-8 text-white">
                             <h3 class="text-2xl font-bold">MAN 1 PALEMBANG</h3>
                             <p class="text-sm opacity-80">Lingkungan belajar modern & asri</p>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Visi Misi Section -->
    <section id="visi" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-20 items-center">
                <div class="order-2 lg:order-1">
                    <div class="space-y-6">
                        <div class="inline-block p-4 bg-green-50 rounded-2xl text-green-700 font-bold text-sm tracking-widest">OUR PHILOSOPHY</div>
                        <h2 class="text-4xl font-black text-gray-900 uppercase">Visi & Misi</h2>
                        <div class="p-8 bg-green-100 rounded-3xl border-l-8 border-green-700 italic text-xl text-green-900 leading-relaxed font-semibold">
                            "Mewujudkan Lembaga Pendidikan Islam yang Unggul dalam Prestasi, Mandiri, dan Berwawasan Lingkungan Berlandaskan Iman dan Taqwa."
                        </div>
                        <div class="grid gap-4 mt-8">
                            <div class="flex gap-4 p-5 bg-gray-50 rounded-2xl hover:bg-green-50 transition border border-gray-100">
                                <div class="w-12 h-12 bg-green-700 rounded-xl flex items-center justify-center text-white shrink-0 shadow-lg">1</div>
                                <p class="text-gray-700 font-medium">Menyelenggarakan pendidikan berkualitas yang mengintegrasikan sains, teknologi, dan nilai-nilai Al-Qur'an.</p>
                            </div>
                            <div class="flex gap-4 p-5 bg-gray-50 rounded-2xl hover:bg-green-50 transition border border-gray-100">
                                <div class="w-12 h-12 bg-green-700 rounded-xl flex items-center justify-center text-white shrink-0 shadow-lg">2</div>
                                <p class="text-gray-700 font-medium">Mengembangkan potensi siswa secara optimal dalam bidang akademik dan non-akademik.</p>
                            </div>
                            <div class="flex gap-4 p-5 bg-gray-50 rounded-2xl hover:bg-green-50 transition border border-gray-100">
                                <div class="w-12 h-12 bg-green-700 rounded-xl flex items-center justify-center text-white shrink-0 shadow-lg">3</div>
                                <p class="text-gray-700 font-medium">Membangun karakter siswa yang mandiri, jujur, dan peduli terhadap pelestarian lingkungan.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="order-1 lg:order-2 grid grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <div class="bg-gray-100 rounded-3xl h-64 overflow-hidden shadow-lg"><img src="{{ asset('images/career_student.png') }}" class="w-full h-full object-cover"></div>
                        <div class="bg-green-700 rounded-3xl h-40 flex items-center justify-center p-8 text-white font-black text-center text-3xl shadow-xl">MAN 1 PLG JOBS</div>
                    </div>
                    <div class="space-y-4 pt-12">
                        <div class="bg-emerald-500 rounded-3xl h-40 flex items-center justify-center p-8 text-white font-black text-center text-3xl shadow-xl italic uppercase font-serif tracking-widest leading-none bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] bg-repeat">UNGGUL</div>
                        <div class="bg-gray-100 rounded-3xl h-64 overflow-hidden shadow-lg"><img src="{{ asset('images/achievement_trophy.png') }}" class="w-full h-full object-cover"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Jalur Section -->
    <section id="jalur" class="py-24 bg-gray-50 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-green-100 rounded-full blur-3xl opacity-50"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center mb-16 space-y-4">
                <span class="text-green-700 font-black tracking-[0.2em] uppercase text-xs">Pathways Selection</span>
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 uppercase">Pilih Jalur Juara Anda</h2>
                <p class="text-gray-500 max-w-2xl mx-auto font-medium">Kami menyediakan berbagai jalur masuk yang disesuaikan dengan minat dan bakat calon siswa.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Reguler -->
                <div class="bg-white rounded-[2rem] p-10 shadow-xl border border-gray-100 hover:shadow-2xl transition-all duration-500 group relative">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition duration-500 shadow-lg">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-4">JALUR REGULER (UMUM)</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-8">Pendaftaran umum melalui seleksi Computer Assisted Test (CAT) mandiri di madrasah.</p>
                    <div class="space-y-4 pt-8 border-t border-gray-100">
                        <div class="flex items-center gap-3"><div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-700">✓</div><span class="text-sm font-bold text-gray-700">Tes Akademik (CAT)</span></div>
                        <div class="flex items-center gap-3"><div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-700">✓</div><span class="text-sm font-bold text-gray-700">Tes Mengaji & Wawancara</span></div>
                    </div>
                </div>

                <!-- Prestasi -->
                <div class="bg-green-700 rounded-[2rem] p-10 shadow-[0_30px_60px_rgba(21,128,61,0.25)] text-white hover:shadow-2xl transition-all duration-500 group relative overflow-hidden">
                    <div class="absolute -right-8 -top-8 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="w-16 h-16 bg-white/20 text-white rounded-2xl flex items-center justify-center mb-8 group-hover:rotate-12 transition duration-500 shadow-xl border border-white/20">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </div>
                    <h3 class="text-2xl font-black mb-4 uppercase">JALUR PMPA (PRESTASI)</h3>
                    <p class="text-white/80 text-sm leading-relaxed mb-8 font-medium">Bagi siswa yang memiliki prestasi akademik (Peringkat 1-3) atau non-akademik tingkat Kota/Provinsi.</p>
                    <div class="space-y-4 pt-8 border-t border-white/20">
                        <div class="flex items-center gap-3"><div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center text-white font-bold">✓</div><span class="text-sm font-bold">BEBAS TES AKADEMIK</span></div>
                        <div class="flex items-center gap-3"><div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center text-white font-bold">✓</div><span class="text-sm font-bold">Sertifikat Internasional/Nasional</span></div>
                    </div>
                </div>

                <!-- Tahfidz -->
                <div class="bg-white rounded-[2rem] p-10 shadow-xl border border-gray-100 hover:shadow-2xl transition-all duration-500 group relative">
                    <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition duration-500 shadow-lg">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-4">JALUR TAHFIDZ</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-8">Penerimaan khusus diperuntukkan bagi Hafidz/Hafidzah Al-Qur'an minimal 2 Juz Mutqin.</p>
                    <div class="space-y-4 pt-8 border-t border-gray-100">
                        <div class="flex items-center gap-3"><div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-700">✓</div><span class="text-sm font-bold text-gray-700">Tes Hafalan Al-Qur'an</span></div>
                        <div class="flex items-center gap-3"><div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-700">✓</div><span class="text-sm font-bold text-gray-700">Fasilitas Kelas Tahfidz</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Persyaratan Section -->
    <section class="py-24 bg-white border-b border-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-start">
                <div>
                     <span class="text-green-700 font-black tracking-widest uppercase text-xs">Requirements Info</span>
                     <h2 class="text-4xl font-black text-gray-900 uppercase my-4">Persyaratan Dokumen</h2>
                     <p class="text-gray-500 font-medium mb-10 leading-relaxed">Siapkan kelengkapan berkas fisik berikut untuk dibawa pada saat tahap verifikasi pendaftaran di Madrasah.</p>
                     
                     <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-6 bg-gray-50 rounded-[1.5rem] border border-gray-100 flex items-center gap-4 group hover:bg-green-700 transition duration-300 group">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-green-700 font-black shadow-sm group-hover:bg-white/20 group-hover:text-white transition">01</div>
                            <span class="text-sm font-bold text-gray-700 group-hover:text-white transition">Formulir Pendaftaran</span>
                        </div>
                        <div class="p-6 bg-gray-50 rounded-[1.5rem] border border-gray-100 flex items-center gap-4 group hover:bg-green-700 transition duration-300">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-green-700 font-black shadow-sm group-hover:bg-white/20 group-hover:text-white transition">02</div>
                            <span class="text-sm font-bold text-gray-700 group-hover:text-white transition">Fc. Rapor Smt 1-5</span>
                        </div>
                        <div class="p-6 bg-gray-50 rounded-[1.5rem] border border-gray-100 flex items-center gap-4 group hover:bg-green-700 transition duration-300">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-green-700 font-black shadow-sm group-hover:bg-white/20 group-hover:text-white transition">03</div>
                            <span class="text-sm font-bold text-gray-700 group-hover:text-white transition">Fc. Kartu Keluarga</span>
                        </div>
                        <div class="p-6 bg-gray-50 rounded-[1.5rem] border border-gray-100 flex items-center gap-4 group hover:bg-green-700 transition duration-300">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-green-700 font-black shadow-sm group-hover:bg-white/20 group-hover:text-white transition">04</div>
                            <span class="text-sm font-bold text-gray-700 group-hover:text-white transition">Fc. Akta Kelahiran</span>
                        </div>
                        <div class="p-6 bg-gray-50 rounded-[1.5rem] border border-gray-100 flex items-center gap-4 group hover:bg-green-700 transition duration-300">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-green-700 font-black shadow-sm group-hover:bg-white/20 group-hover:text-white transition">05</div>
                            <span class="text-sm font-bold text-gray-700 group-hover:text-white transition">Pas Foto 3x4 (4 Lbr)</span>
                        </div>
                        <div class="p-6 bg-gray-50 rounded-[1.5rem] border border-gray-100 flex items-center gap-4 group hover:bg-green-700 transition duration-300">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-green-700 font-black shadow-sm group-hover:bg-white/20 group-hover:text-white transition">06</div>
                            <span class="text-sm font-bold text-gray-700 group-hover:text-white transition">Sertifikat (Opsional)</span>
                        </div>
                     </div>
                </div>

                <div class="bg-gray-900 rounded-[2.5rem] p-12 text-white shadow-2xl relative overflow-hidden h-full flex flex-col justify-center">
                    <div class="absolute -bottom-20 -right-20 w-80 h-80 bg-green-700 rounded-full opacity-20 blur-3xl"></div>
                    <div class="relative z-10 space-y-8">
                        <div class="w-20 h-20 bg-green-600 rounded-3xl flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <h3 class="text-3xl font-black">PANDUAN PENDAFTARAN</h3>
                        <p class="text-gray-400 font-medium">Bagi Anda yang kesulitan melakukan pendaftaran mandiri, tim IT kami siap membantu di Helpdesk Online.</p>
                        <div class="flex flex-col gap-4">
                            <a href="#" class="inline-flex items-center gap-4 bg-white/10 hover:bg-white/20 p-5 rounded-2xl transition border border-white/10">
                                <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center shrink-0">W</div>
                                <div>
                                    <div class="font-bold">Chat Helpdesk (WhatsApp)</div>
                                    <div class="text-xs text-gray-400">Jam Layanan: 08:00 - 15:00</div>
                                </div>
                            </a>
                            <a href="#" class="inline-flex items-center gap-4 bg-white/10 hover:bg-white/20 p-5 rounded-2xl transition border border-white/10">
                                <div class="w-10 h-10 bg-red-600 rounded-full flex items-center justify-center shrink-0">Y</div>
                                <div>
                                    <div class="font-bold">Tutorial Pendaftaran</div>
                                    <div class="text-xs text-gray-400">Video panduan langkah demi langkah</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Alur Section -->
    <section id="alur" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20 space-y-4">
                <span class="text-green-700 font-black tracking-widest uppercase text-xs">The Flow</span>
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 uppercase">Prosedur Pendaftaran</h2>
            </div>
            
            <div class="relative">
                <div class="hidden lg:block absolute top-[50%] left-0 right-0 h-1 bg-gradient-to-r from-transparent via-green-200 to-transparent z-0"></div>
                <div class="grid lg:grid-cols-5 gap-8 relative z-10">
                    <div class="bg-white p-8 rounded-[2rem] shadow-xl border border-gray-100 flex flex-col items-center text-center group hover:bg-green-700 transition duration-500 transform hover:-translate-y-2">
                        <div class="w-16 h-16 bg-green-50 text-green-700 rounded-2xl flex items-center justify-center mb-6 font-black text-2xl group-hover:bg-white/20 group-hover:text-white transition">1</div>
                        <h4 class="font-black text-gray-900 mb-2 truncate group-hover:text-white transition">BUAT AKUN</h4>
                        <p class="text-xs text-gray-500 font-medium group-hover:text-white/80 transition leading-relaxed">Daftar dengan NISN & Email Valid</p>
                    </div>
                    <div class="bg-white p-8 rounded-[2rem] shadow-xl border border-gray-100 flex flex-col items-center text-center group hover:bg-green-700 transition duration-500 transform hover:-translate-y-2 lg:mt-12">
                        <div class="w-16 h-16 bg-green-50 text-green-700 rounded-2xl flex items-center justify-center mb-6 font-black text-2xl group-hover:bg-white/20 group-hover:text-white transition">2</div>
                        <h4 class="font-black text-gray-900 mb-2 truncate group-hover:text-white transition">LOG IN</h4>
                        <p class="text-xs text-gray-500 font-medium group-hover:text-white/80 transition leading-relaxed">Lengkapi Data Diri & Rapor</p>
                    </div>
                    <div class="bg-white p-8 rounded-[2rem] shadow-xl border border-gray-100 flex flex-col items-center text-center group hover:bg-green-700 transition duration-500 transform hover:-translate-y-2">
                        <div class="w-16 h-16 bg-green-50 text-green-700 rounded-2xl flex items-center justify-center mb-6 font-black text-2xl group-hover:bg-white/20 group-hover:text-white transition">3</div>
                        <h4 class="font-black text-gray-900 mb-2 truncate group-hover:text-white transition">FINALISASI</h4>
                        <p class="text-xs text-gray-500 font-medium group-hover:text-white/80 transition leading-relaxed">Pilih Jalur & Cetak Kartu</p>
                    </div>
                    <div class="bg-white p-8 rounded-[2rem] shadow-xl border border-gray-100 flex flex-col items-center text-center group hover:bg-green-700 transition duration-500 transform hover:-translate-y-2 lg:mt-12">
                        <div class="w-16 h-16 bg-green-50 text-green-700 rounded-2xl flex items-center justify-center mb-6 font-black text-2xl group-hover:bg-white/20 group-hover:text-white transition">4</div>
                        <h4 class="font-black text-gray-900 mb-2 truncate group-hover:text-white transition">SELEKSI</h4>
                        <p class="text-xs text-gray-500 font-medium group-hover:text-white/80 transition leading-relaxed">Verifikasi Berkas & Tes CAT</p>
                    </div>
                    <div class="bg-white p-8 rounded-[2rem] shadow-xl border border-gray-100 flex flex-col items-center text-center group hover:bg-green-700 transition duration-500 transform hover:-translate-y-2">
                        <div class="w-16 h-16 bg-green-50 text-green-700 rounded-2xl flex items-center justify-center mb-6 font-black text-2xl group-hover:bg-white/20 group-hover:text-white transition">5</div>
                        <h4 class="font-black text-gray-900 mb-2 truncate group-hover:text-white transition">HASIL</h4>
                        <p class="text-xs text-gray-500 font-medium group-hover:text-white/80 transition leading-relaxed">Pantau Pengumuman Kelulusan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- FAQ Section -->
    <section id="faq" class="py-24 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 space-y-4">
                <span class="text-green-700 font-black tracking-widest uppercase text-xs">Knowledge Base</span>
                <h2 class="text-4xl font-black text-gray-900 uppercase">Pertanyaan Umum (FAQ)</h2>
            </div>
            
            <div class="space-y-4" x-data="{ active: 1 }">
                <!-- Q1 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <button @click="active = (active == 1 ? 0 : 1)" class="w-full px-8 py-6 flex items-center justify-between text-left focus:outline-none">
                        <span class="font-bold text-gray-900" :class="active == 1 ? 'text-green-700' : ''">Kapan batas akhir pendaftaran online?</span>
                        <svg class="w-6 h-6 transition transform" :class="active == 1 ? 'rotate-180 text-green-700' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="active == 1" class="px-8 pb-8 text-gray-600 font-medium leading-relaxed" x-collapse>
                        Pendaftaran online dibuka mulai tanggal 1 Maret hingga batas akhir pada 30 April. Dianjurkan melakukan pendaftaran lebih awal untuk menghindari kendala teknis di akhir waktu.
                    </div>
                </div>

                <!-- Q2 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <button @click="active = (active == 2 ? 0 : 2)" class="w-full px-8 py-6 flex items-center justify-between text-left focus:outline-none">
                        <span class="font-bold text-gray-900" :class="active == 2 ? 'text-green-700' : ''">Apakah ada biaya pendaftaran?</span>
                        <svg class="w-6 h-6 transition transform" :class="active == 2 ? 'rotate-180 text-green-700' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="active == 2" class="px-8 pb-8 text-gray-600 font-medium leading-relaxed" x-collapse>
                        Proses pendaftaran awal di sistem PMB online MAN 1 Palembang adalah gratis (tidak dipungut biaya). Biaya operasional seleksi mungkin berlaku tergantung kebijakan madrasah.
                    </div>
                </div>

                <!-- Q3 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <button @click="active = (active == 3 ? 0 : 3)" class="w-full px-8 py-6 flex items-center justify-between text-left focus:outline-none">
                        <span class="font-bold text-gray-900" :class="active == 3 ? 'text-green-700' : ''">Apa saja materi tes akademiknya?</span>
                        <svg class="w-6 h-6 transition transform" :class="active == 3 ? 'rotate-180 text-green-700' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="active == 3" class="px-8 pb-8 text-gray-600 font-medium leading-relaxed" x-collapse>
                        Materi tes Computer Assisted Test (CAT) meliputi: Matematika, IPA, Agama Islam, Bahasa Indonesia, Bahasa Inggris, serta Tes Potensi Akademik (TPA).
                    </div>
                </div>

                <!-- Q4 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <button @click="active = (active == 4 ? 0 : 4)" class="w-full px-8 py-6 flex items-center justify-between text-left focus:outline-none">
                        <span class="font-bold text-gray-900" :class="active == 4 ? 'text-green-700' : ''">Bagaimana jika lupa password akun?</span>
                        <svg class="w-6 h-6 transition transform" :class="active == 4 ? 'rotate-180 text-green-700' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="active == 4" class="px-8 pb-8 text-gray-600 font-medium leading-relaxed" x-collapse>
                        Anda dapat menghubungi Helpdesk WhatsApp kami dengan melampirkan foto kartu pelajar atau identitas resmi sebagai bukti kepemilikan akun untuk proses reset password.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="h-[400px] w-full bg-gray-200 grayscale hover:grayscale-0 transition duration-700 overflow-hidden relative">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.341452243788!2d104.78918887497044!3d-3.002772540156453!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e3b77a06c888889%3A0xe6365452d9a39f60!2sMAN%201%20Palembang!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" 
            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        <div class="absolute bottom-4 left-4 right-4 md:left-auto md:right-10 md:w-80 bg-white p-6 rounded-2xl shadow-2xl border border-gray-100">
            <h5 class="font-black text-gray-900 mb-2">LOKASI SEKOLAH</h5>
            <p class="text-xs text-gray-500 font-bold mb-4">Jl. Gubernur H. Ahmad Bastari, Jakabaring, Palembang</p>
            <a href="https://maps.app.goo.gl/uX3L5G3tV6Q" target="_blank" class="block text-center py-2 bg-green-700 text-white rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-green-800 transition">Petunjuk Arah</a>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="bg-gray-900 text-white pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-12 mb-20">
                <div class="col-span-2 space-y-8">
                    <h3 class="text-3xl font-black flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" class="h-10 brightness-0 invert">
                        MAN 1 PALEMBANG
                    </h3>
                    <p class="text-gray-400 text-lg leading-relaxed max-w-lg">
                        Unggul dalam akhlak, terdepan dalam prestasi ilmiah. Bergabunglah dengan institusi pendidikan Islam modern di Sumatera Selatan.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-12 h-12 rounded-2xl bg-white/5 hover:bg-green-700 transition flex items-center justify-center border border-white/10 group"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                        <a href="#" class="w-12 h-12 rounded-2xl bg-white/5 hover:bg-green-700 transition flex items-center justify-center border border-white/10 group"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.072 3.252.148 4.771 1.691 4.919 4.919.06 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4z"/></svg></a>
                        <a href="#" class="w-12 h-12 rounded-2xl bg-white/5 hover:bg-green-700 transition flex items-center justify-center border border-white/10 group uppercase font-black text-xs">YT</a>
                    </div>
                </div>
                
                <div class="space-y-6">
                    <h4 class="text-white font-black text-xs uppercase tracking-[0.2em] mb-4 shadow-[0_1px_0_rgba(255,255,255,0.1)] inline-block pb-1">Kontak Kami</h4>
                    <p class="text-gray-400 font-bold mb-4">
                        📍 Jl. Gubernur H. Ahmad Bastari, Jakabaring, Palembang
                    </p>
                    <div class="space-y-2">
                        <span class="block text-gray-400 text-sm font-medium">📞 (0711) 5620083</span>
                        <span class="block text-gray-400 text-sm font-medium">📧 man1palembanofficia@gmail.com</span>
                    </div>
                </div>
                
                <div class="space-y-6">
                     <h4 class="text-white font-black text-xs uppercase tracking-[0.2em] mb-4 shadow-[0_1px_0_rgba(255,255,255,0.1)] inline-block pb-1">Internal Link</h4>
                     <ul class="text-gray-400 space-y-3 text-sm font-bold">
                         <li><a href="#beranda" class="hover:text-green-500 transition">Beranda Utama</a></li>
                         <li><a href="#visi" class="hover:text-green-500 transition">Profil Madrasah</a></li>
                         <li><a href="#jalur" class="hover:text-green-500 transition">Panduan Jalur</a></li>
                         <li><a href="{{ route('login') }}" class="hover:text-green-500 transition">Area Verifikator</a></li>
                     </ul>
                </div>
            </div>
            
            <div class="border-t border-white/5 pt-12 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="text-gray-500 font-bold text-xs uppercase tracking-widest text-center md:text-left">
                    &copy; {{ date('Y') }} MADRASAH ALIYAH NEGERI 1 PALEMBANG. ALL RIGHTS RESERVED.
                </div>
                <div class="flex items-center gap-4">
                    <div class="h-2 w-2 rounded-full bg-green-500 animate-pulse"></div>
                    <span class="text-[10px] font-black uppercase text-gray-400 tracking-[0.2em]">Desain By Sarang Tumbuh</span>
                </div>
            </div>
        </div>
    </footer>
</div>
@endsection

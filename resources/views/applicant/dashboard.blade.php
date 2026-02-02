
@extends('layouts.guest')

@section('title', 'Dashboard Pendaftar - PMB MAN 1 Palembang')

@section('content')
<div class="min-h-screen bg-[#f8fafc] font-sans antialiased text-gray-900" x-data="{ mobileMenuOpen: false }">
    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 w-full z-50 border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Kemenag" class="h-10 w-auto">
                    <div class="leading-tight hidden sm:block">
                        <h1 class="text-sm font-bold text-green-800 tracking-tight">MAN 1 PALEMBANG</h1>
                        <p class="text-[8px] text-gray-500 font-bold uppercase tracking-wider">Dashboard Pendaftar</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 sm:gap-6">
                    <div class="text-right hidden md:block">
                        <p class="text-xs font-bold text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-gray-500">NISN: {{ $applicant->nisn }}</p>
                    </div>
                    
                    <div class="h-8 w-px bg-gray-200 hidden md:block"></div>

                    @if($applicant->registration_completed_at)
                    <a href="{{ route('applicant.registration-card.show') }}" target="_blank" class="p-2 text-gray-400 hover:text-green-500 transition-colors rounded-xl hover:bg-green-50" title="Cetak Kartu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                    </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition-colors rounded-xl hover:bg-red-50" title="Keluar">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <!-- Dashboard Header -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div class="space-y-1">
                <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-700 text-[10px] font-black uppercase tracking-widest border border-green-200">PMB TA 2026/2027</span>
                <h2 class="text-3xl font-black text-gray-900 tracking-tight">Selamat Datang, <span class="text-green-600 italic">{{ explode(' ', Auth::user()->name)[0] }}</span>!</h2>
                <p class="text-gray-500 font-medium">Pantau status pendaftaran dan lengkapi data Anda di sini.</p>
            </div>
            
            <div class="flex items-center gap-3">
                 <div class="px-5 py-3 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></div>
                    <span class="text-xs font-bold text-gray-600">Status:</span>
                    {!! $applicant->status_badge !!}
                 </div>
            </div>
        </div>

        @if($completionPercentage < 100)
            <!-- Incomplete Profile View -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Welcome & Progress Card -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-gradient-to-br from-green-600 to-emerald-700 rounded-[2.5rem] p-8 md:p-10 text-white shadow-2xl shadow-green-200 relative overflow-hidden">
                        <div class="absolute -top-20 -right-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                        <div class="relative z-10">
                            <h3 class="text-2xl md:text-3xl font-black mb-4 uppercase">Lengkapi Profil Anda</h3>
                            <p class="text-green-100 font-medium mb-8 leading-relaxed max-w-xl">Data profil wajib dilengkapi sebelum Anda dapat memilih jalur pendaftaran dan melanjutkan ke tahap seleksi.</p>
                            
                            <div class="space-y-2">
                                <div class="flex justify-between items-end">
                                    <span class="text-sm font-bold uppercase tracking-widest text-green-200">Progress Kelengkapan</span>
                                    <span class="text-3xl font-black">{{ $completionPercentage }}%</span>
                                </div>
                                <div class="w-full bg-black/20 rounded-full h-4 overflow-hidden p-1">
                                    <div class="bg-white h-full rounded-full transition-all duration-1000 ease-out shadow-[0_0_15px_rgba(255,255,255,0.5)]" style="width: {{ $completionPercentage }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Form Card -->
                    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
                        <div class="p-8 md:p-10">
                            <h4 class="text-xl font-black text-gray-900 border-b border-gray-100 pb-6 mb-8 uppercase tracking-tight">Formulir Profil Dasar</h4>
                            
                            <form action="{{ route('applicant.dashboard.update') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                                @csrf
                                
                                <!-- Photo Upload -->
                                <div class="bg-gray-50 p-8 rounded-3xl border-2 border-dashed border-gray-200 group hover:border-green-400 transition-all duration-300">
                                    <div class="flex flex-col md:flex-row items-center gap-8">
                                        <div class="relative group">
                                            <div class="absolute inset-0 bg-green-500 rounded-2xl rotate-6 opacity-10 group-hover:rotate-12 transition"></div>
                                            <div class="w-32 h-40 bg-white rounded-2xl shadow-lg border-4 border-white overflow-hidden relative z-10">
                                                @if($applicant->photo)
                                                    <img src="{{ Storage::url($applicant->photo) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-300 p-4 text-center">
                                                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                        <span class="text-[10px] font-bold uppercase tracking-widest">No Photo</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex-1 space-y-4 text-center md:text-left">
                                            <div>
                                                <h5 class="text-lg font-black text-gray-900">Upload Pas Foto</h5>
                                                <p class="text-sm text-gray-500 font-medium">Gunakan foto resmi berlatar biru/merah. Maks 2MB.</p>
                                            </div>
                                            <input type="file" name="photo" id="photo-upload" class="hidden">
                                            <label for="photo-upload" class="inline-flex items-center px-6 py-3 bg-white border-2 border-green-500 text-green-600 rounded-xl font-bold text-sm cursor-pointer hover:bg-green-500 hover:text-white transition-all transform active:scale-95 shadow-lg shadow-green-100">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12"/></svg>
                                                Pilih File Foto
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                                    <!-- Left Col -->
                                    <div class="space-y-6">
                                        <div class="group">
                                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 group-focus-within:text-green-600 transition">Nama Lengkap (Sesuai Ijazah)</label>
                                            <input type="text" value="{{ $applicant->full_name }}" readonly class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl px-5 py-4 text-gray-500 font-bold cursor-not-allowed">
                                        </div>
                                        
                                        <div class="group">
                                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 group-focus-within:text-green-600 transition">Tempat Lahir</label>
                                            <input type="text" name="birth_place" value="{{ old('birth_place', $applicant->birth_place) }}" placeholder="Contoh: Palembang" required class="w-full bg-white border-2 border-gray-100 focus:border-green-400 focus:ring-4 focus:ring-green-50/50 rounded-2xl px-5 py-4 font-bold transition-all outline-none">
                                        </div>

                                        <div class="group">
                                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 group-focus-within:text-green-600 transition">Tanggal Lahir</label>
                                            <input type="date" name="birth_date" value="{{ old('birth_date', $applicant->birth_date ? $applicant->birth_date->format('Y-m-d') : '') }}" required class="w-full bg-white border-2 border-gray-100 focus:border-green-400 focus:ring-4 focus:ring-green-50/50 rounded-2xl px-5 py-4 font-bold transition-all outline-none">
                                        </div>

                                        <div class="group">
                                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 group-focus-within:text-green-600 transition">Jenis Kelamin</label>
                                            <div class="flex gap-4">
                                                <label class="flex-1 relative cursor-pointer group">
                                                    <input type="radio" name="gender" value="L" class="peer hidden" {{ old('gender', $applicant->gender) == 'L' ? 'checked' : '' }} required>
                                                    <div class="peer-checked:bg-green-500 peer-checked:text-white peer-checked:border-green-500 border-2 border-gray-100 rounded-2xl px-5 py-4 text-center font-bold text-gray-500 transition-all hover:bg-gray-50">Laki-laki</div>
                                                </label>
                                                <label class="flex-1 relative cursor-pointer group">
                                                    <input type="radio" name="gender" value="P" class="peer hidden" {{ old('gender', $applicant->gender) == 'P' ? 'checked' : '' }} required>
                                                    <div class="peer-checked:bg-green-500 peer-checked:text-white peer-checked:border-green-500 border-2 border-gray-100 rounded-2xl px-5 py-4 text-center font-bold text-gray-500 transition-all hover:bg-gray-50">Perempuan</div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Col -->
                                    <div class="space-y-6">
                                        <div class="group">
                                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 group-focus-within:text-green-600 transition">Nomor HP / WhatsApp Aktif</label>
                                            <input type="text" name="phone" value="{{ old('phone', $applicant->phone) }}" placeholder="08xxxxxxxxxx" required class="w-full bg-white border-2 border-gray-100 focus:border-green-400 focus:ring-4 focus:ring-green-50/50 rounded-2xl px-5 py-4 font-bold transition-all outline-none">
                                        </div>

                                        <div class="group">
                                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 group-focus-within:text-green-600 transition">Nama Orang Tua / Wali</label>
                                            <input type="text" name="parent_name" value="{{ old('parent_name', $applicant->parent_name) }}" placeholder="Nama Ayah / Ibu / Wali" required class="w-full bg-white border-2 border-gray-100 focus:border-green-400 focus:ring-4 focus:ring-green-50/50 rounded-2xl px-5 py-4 font-bold transition-all outline-none">
                                        </div>

                                        <div class="group">
                                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 group-focus-within:text-green-600 transition">No. HP Orang Tua / Wali</label>
                                            <input type="text" name="parent_phone" value="{{ old('parent_phone', $applicant->parent_phone) }}" placeholder="Nomor HP dapat dihubungi" required class="w-full bg-white border-2 border-gray-100 focus:border-green-400 focus:ring-4 focus:ring-green-50/50 rounded-2xl px-5 py-4 font-bold transition-all outline-none">
                                        </div>

                                        <div class="group">
                                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 group-focus-within:text-green-600 transition">Alamat Lengkap Saat Ini</label>
                                            <textarea name="address" rows="1" required class="w-full bg-white border-2 border-gray-100 focus:border-green-400 focus:ring-4 focus:ring-green-50/50 rounded-2xl px-5 py-4 font-bold transition-all outline-none resize-none min-h-[110px]" placeholder="Jl. Contoh No. 123, Kel. ..." required>{{ old('address', $applicant->address) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-10 border-t border-gray-100 flex justify-center sm:justify-end">
                                    <button type="submit" class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white font-black text-lg px-12 py-5 rounded-[2rem] shadow-[0_20px_40px_rgba(22,163,74,0.3)] transition-all transform hover:-translate-y-1 active:scale-95">
                                        Simpan & Lanjutkan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Guidance Sidebar -->
                <div class="space-y-6">
                    <div class="bg-white rounded-[2rem] p-8 shadow-lg border border-gray-100">
                        <h4 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-6 border-b border-gray-50 pb-4">Panduan Pengisian</h4>
                        <div class="space-y-6">
                            <div class="flex gap-4">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 font-bold">1</div>
                                <p class="text-xs text-gray-500 leading-relaxed font-bold">Pastikan <span class="text-gray-900 leading-relaxed">Nama Lengkap</span> sesuai dengan yang tertera di Akta Kelahiran atau Ijazah SMP/MTs.</p>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center shrink-0 font-bold">2</div>
                                <p class="text-xs text-gray-500 leading-relaxed font-bold">Upload <span class="text-gray-900 leading-relaxed">Foto Resmi</span>. Foto akan digunakan untuk Kartu Ujian dan Sertifikat.</p>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center shrink-0 font-bold">3</div>
                                <p class="text-xs text-gray-500 leading-relaxed font-bold">Gunakan nomor <span class="text-gray-900 leading-relaxed">WhatsApp aktif</span> untuk menerima notifikasi pengumuman.</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-900 rounded-[2rem] p-8 text-white shadow-xl relative overflow-hidden group">
                        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-green-500 rounded-full blur-3xl opacity-20 group-hover:opacity-40 transition"></div>
                        <h4 class="text-lg font-black mb-4 uppercase leading-tight">Butuh Bantuan Teknis?</h4>
                        <p class="text-gray-400 text-sm font-medium mb-6">Tim IT kami siap membantu jika Anda mengalami kendala saat pengisian data.</p>
                        <a href="#" class="inline-flex items-center gap-2 text-green-400 font-black text-xs uppercase tracking-widest hover:text-green-300 transition">
                            Chat Admin PMB 
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>

        @else
            <!-- Complete Profile View (Pathway Selection / Registration Phase) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- User Summary Card -->
                <div class="space-y-6">
                    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 p-8 text-center relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-green-500/5 rounded-full -mr-8 -mt-8"></div>
                        <div class="relative inline-block mx-auto mb-6">
                            <div class="w-24 h-32 bg-gray-100 rounded-3xl overflow-hidden shadow-inner border-4 border-white relative z-10">
                                @if($applicant->photo)
                                    <img src="{{ Storage::url($applicant->photo) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-green-500 rounded-2xl flex items-center justify-center text-white border-4 border-white shadow-lg shadow-green-200 z-20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-black text-gray-900 mb-1 truncate px-2">{{ $applicant->full_name }}</h3>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ $applicant->nisn }}</p>
                    </div>

                    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
                        <div class="p-8">
                             <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6 flex items-center justify-between">
                                Data Terverifikasi
                                <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zM10 5a1 1 0 00-1 1v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                             </h4>
                             <div class="space-y-4">
                                <div class="p-4 bg-gray-50 rounded-2xl flex items-center justify-between">
                                    <span class="text-xs font-bold text-gray-400 uppercase">Lahir</span>
                                    <span class="text-sm font-black text-gray-900">{{ $applicant->birth_date->format('d/m/Y') }}</span>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-2xl flex items-center justify-between">
                                    <span class="text-xs font-bold text-gray-400 uppercase">Gender</span>
                                    <span class="text-sm font-black text-gray-900">{{ $applicant->gender == 'L' ? 'LAKI-LAKI' : 'PEREMPUAN' }}</span>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-2xl">
                                    <span class="text-xs font-bold text-gray-400 uppercase block mb-1">Alamat</span>
                                    <span class="text-xs font-black text-gray-900 line-clamp-2 leading-relaxed uppercase">{{ $applicant->address }}</span>
                                </div>
                             </div>
                             <div class="mt-8">
                                <a href="#" class="w-full py-4 text-center block bg-gray-50 hover:bg-green-50 text-gray-400 hover:text-green-600 rounded-2xl font-bold text-xs uppercase tracking-widest transition-all">Perbarui Profil</a>
                             </div>
                        </div>
                    </div>
                </div>

                <!-- Registration Detail / Pathway Selection -->
                <div class="lg:col-span-2 space-y-6">
                    
                    @if($applicant->registration_completed_at)
                        <!-- Final Registration State -->
                        <div class="bg-gray-900 rounded-[2.5rem] shadow-2xl shadow-green-200/20 overflow-hidden relative border-4 border-green-500/20">
                            <div class="p-8 md:p-10 flex flex-col md:flex-row gap-8 items-center justify-between relative z-10">
                                <div class="flex-1 text-center md:text-left">
                                     <div class="inline-flex items-center px-4 py-2 rounded-full bg-green-500/20 text-green-400 text-[10px] font-black uppercase tracking-widest mb-4 border border-green-500/50">
                                        REGISTRASI SELESAI
                                     </div>
                                     <h3 class="text-2xl md:text-3xl font-black text-white mb-2 leading-tight">Pendaftaran Anda Telah <span class="text-green-400 italic underline underline-offset-8">Diterima</span></h3>
                                     <p class="text-gray-400 font-medium">Nomor Registrasi: <span class="text-white font-black font-mono tracking-tighter">{{ $applicant->registration_number }}</span></p>
                                </div>
                                
                                <div class="grid grid-cols-2 lg:grid-cols-1 gap-3 w-full md:w-auto">
                                    <a href="{{ route('applicant.registration-card.download') }}" class="group flex items-center justify-center bg-green-600 hover:bg-green-700 text-white px-8 py-5 rounded-3xl font-black text-sm shadow-xl shadow-green-900/40 transition-all transform hover:-translate-y-1 active:scale-95">
                                        <svg class="w-5 h-5 mr-3 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        DOWNLOAD PDF
                                    </a>
                                    <a href="{{ route('applicant.registration-card.show') }}" target="_blank" class="flex items-center justify-center bg-white/10 hover:bg-white/20 text-white px-8 py-5 rounded-3xl font-black text-sm transition-all border border-white/10">
                                        LIHAT KARTU
                                    </a>

                                    @php
                                        $pathwayName = strtoupper($applicant->pathway->name ?? '');
                                        $isExamEligible = (str_contains($pathwayName, 'REGULER') || str_contains($pathwayName, 'TAHFIDZ')) && $applicant->status == 'verified';
                                    @endphp

                                    @if($isExamEligible)
                                    <a href="{{ route('applicant.registration-card.download-exam') }}" class="col-span-2 lg:col-span-1 group flex items-center justify-center bg-yellow-500 hover:bg-yellow-600 text-white px-8 py-5 rounded-3xl font-black text-sm shadow-xl shadow-yellow-900/40 transition-all transform hover:-translate-y-1 active:scale-95">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                                        KARTU UJIAN
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Secondary Status Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-white rounded-[2rem] p-8 shadow-lg border border-gray-100 flex flex-col justify-between">
                                <div>
                                    <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Verifikasi Faktual</h4>
                                    
                                    @if($applicant->status == 'verified')
                                        <div class="flex items-center gap-4 mb-4">
                                            <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-green-600 shadow-sm border border-green-50 animate-pulse">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-black text-green-700 leading-tight">SUDAH DIVERIFIKASI</p>
                                                <p class="text-[10px] font-bold text-gray-400 uppercase mt-1 tracking-tighter">Oleh: {{ $applicant->verifier->name ?? 'Panitia PMB' }}</p>
                                            </div>
                                        </div>
                                    @elseif($applicant->status == 'rejected')
                                        <div class="flex items-center gap-4 mb-4">
                                            <div class="w-14 h-14 rounded-2xl bg-red-100 flex items-center justify-center text-red-600 shadow-sm border border-red-50">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-black text-red-700 leading-tight">VERIFIKASI DITOLAK</p>
                                                <p class="text-[10px] font-bold text-gray-400 uppercase mt-1 tracking-tighter">Mohon Cek Catatan / Hubungi Panitia</p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-4 mb-4">
                                            <div class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center text-orange-600 shadow-sm border border-orange-50">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-black text-gray-900 leading-tight">MENGUNGGU VERIFIKASI</p>
                                                <p class="text-[10px] font-bold text-gray-400 uppercase mt-1 tracking-tighter">Bawa Berkas Fisik ke Madrasah</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 font-medium leading-relaxed italic border-t border-gray-50 pt-4">
                                    @if($applicant->status == 'verified')
                                        Selamat! Data Anda telah valid. Silakan cetak Kartu Ujian (jika tersedia).
                                    @elseif($applicant->status == 'rejected')
                                        Data Anda belum memenuhi syarat. {{ $applicant->verification_notes ?? 'Silakan lengkapi berkas.' }}
                                    @else
                                        Pastikan Anda membawa <span class="font-bold text-gray-900">Kartu Pendaftaran</span> dan berkas asli lainnya sesuai persyaratan saat verifikasi.
                                    @endif
                                </p>
                            </div>

                            <div class="bg-white rounded-[2rem] p-8 shadow-lg border border-gray-100 flex flex-col justify-between">
                                <div>
                                    <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Jalur Terpilih</h4>
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 shadow-sm border border-blue-50">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-gray-900 leading-tight">{{ strtoupper($applicant->pathway->name ?? 'BELUM MEMILIH') }}</p>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase mt-1 tracking-tighter">Jalur Utama Seleksi</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-t border-gray-50 pt-4">
                                     <p class="text-xs text-blue-700 font-bold underline underline-offset-4 decoration-blue-200">Lihat Detail Persyaratan Jalur Ini</p>
                                </div>
                            </div>
                        </div>

                    @else
                        <!-- Pathway Selection State -->
                        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
                            <div class="p-8 md:p-10 border-b border-gray-50 bg-gradient-to-r from-gray-50 to-white">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-green-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-green-100">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Pilih Jalur Pendaftaran</h3>
                                        <p class="text-sm text-gray-500 font-bold uppercase tracking-widest mt-1">Sisa Kuota Terbatas</p>
                                    </div>
                                </div>

                            </div>
                            
                            <div class="divide-y divide-gray-50">
                                @forelse($pathways as $pathway)
                                    <div class="p-8 hover:bg-green-50/30 transition-all group">
                                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                                            <div class="flex-1 space-y-3">
                                                <div class="flex items-center gap-3">
                                                    <h4 class="text-2xl font-black text-gray-900 group-hover:text-green-700 transition">
                                                        {{ $pathway->name }}
                                                    </h4>
                                                    @if($pathway->remaining_quota > 0)
                                                        <span class="px-3 py-1 bg-white border border-green-200 text-green-700 font-black text-[10px] rounded-lg tracking-widest shadow-sm">
                                                            SISA: {{ $pathway->remaining_quota }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <p class="text-sm text-gray-500 font-medium leading-relaxed max-w-lg">{{ $pathway->description }}</p>
                                                
                                                <div class="flex flex-wrap gap-4 pt-2">
                                                    <div class="flex items-center gap-2 text-[10px] font-black uppercase text-gray-400">
                                                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                        BATCH: {{ $pathway->start_date?->format('d M') ?? 'NOW' }} - {{ $pathway->end_date?->format('d M') ?? 'CLOSE' }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="shrink-0 flex items-center">
                                                @if($applicant->ppdb_pathway_id == $pathway->id)
                                                    <a href="{{ route('applicant.registration.step', $applicant->registration_step ?? 1) }}" class="w-full md:w-auto inline-flex items-center justify-center px-10 py-5 bg-green-600 hover:bg-green-700 text-white rounded-[1.5rem] font-black text-sm shadow-xl shadow-green-100 transition-all transform hover:-translate-y-1 active:scale-95 animate-pulse">
                                                        LANJUTKAN
                                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" /></svg>
                                                    </a>
                                                @elseif($applicant->ppdb_pathway_id)
                                                    <span class="inline-flex items-center px-8 py-4 bg-gray-50 border border-gray-100 rounded-[1.5rem] text-xs font-black text-gray-300 uppercase italic opacity-50">Locked</span>
                                                @elseif($pathway->remaining_quota <= 0)
                                                    <span class="inline-flex items-center px-8 py-4 bg-red-50 border border-red-100 rounded-[1.5rem] text-xs font-black text-red-500 uppercase tracking-widest shadow-sm">KUOTA PENUH</span>
                                                @else
                                                     <form action="{{ route('applicant.select-pathway') }}" method="POST" class="w-full md:w-auto">
                                                        @csrf
                                                        <input type="hidden" name="ppdb_pathway_id" value="{{ $pathway->id }}">
                                                        <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center px-12 py-5 bg-white border-2 border-green-600 text-green-700 hover:bg-green-600 hover:text-white rounded-[1.5rem] font-black text-sm shadow-lg shadow-green-50 transition-all transform hover:-translate-y-1 active:scale-95 group">
                                                            PILIH JALUR
                                                            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                                        </button>
                                                     </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-20 text-center">
                                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                            <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                        </div>
                                        <h5 class="text-xl font-black text-gray-900">Belum Ada Jalur Dibuka</h5>
                                        <p class="text-gray-400 font-bold uppercase text-[10px] tracking-[0.2em] mt-2">Mohon Cek Kembali Secara Berkala</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </main>
    
    <!-- Footer Credits -->
    <footer class="py-12 px-4 text-center">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-center md:justify-between gap-6 border-t border-gray-100 pt-12">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">&copy; {{ date('Y') }} MAN 1 PALEMBANG. OFFICIAL PORTAL</p>
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-green-500"></div>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Powered by Sarang Tumbuh</span>
            </div>
        </div>
    </footer>
</div>

<script>
    // Simple script to handle form visual feedback
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', () => {
            const btn = form.querySelector('button[type="submit"]');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-3 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...';
            }
        });
    });
</script>
@endsection

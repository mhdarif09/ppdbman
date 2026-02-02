@extends('applicant.registration.layout')

@section('form')
<form action="{{ route('applicant.registration.save', 1) }}" method="POST" class="animate-fadeIn">
    @csrf
    
    <!-- Section 1: Data Pribadi -->
    <div class="mb-10">
        <div class="section-header">
            <div class="section-number">1</div>
            <h3 class="section-title">Data Identitas Pribadi</h3>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
            <div class="lg:col-span-2 form-group">
                <label class="input-label">Nama Lengkap (Sesuai Ijazah)</label>
                <input type="text" value="{{ $applicant->full_name }}" readonly disabled>
            </div>
            
            <div class="form-group">
                <label class="input-label">NIK (16 Digit)</label>
                <input type="text" name="nik" value="{{ old('nik', $applicant->nik) }}" required maxlength="16" placeholder="Masukkan NIK...">
            </div>

            <div class="form-group">
                <label class="input-label">Nama Panggilan</label>
                <input type="text" name="nickname" value="{{ old('nickname', $applicant->nickname) }}" placeholder="Contoh: Budi">
            </div>
            
            <div class="form-group">
                <label class="input-label">NIS (Nomor Induk Siswa)</label>
                <input type="text" name="nis" value="{{ old('nis', $applicant->nis) }}" placeholder="Nomor dari sekolah asal">
            </div>

            <div class="form-group">
                <label class="input-label">NISN</label>
                <input type="text" value="{{ $applicant->nisn }}" readonly disabled>
            </div>

            <div class="form-group">
                <label class="input-label">Tempat Lahir</label>
                <input type="text" name="birth_place" value="{{ old('birth_place', $applicant->birth_place) }}" required placeholder="Kota Lahir">
            </div>

            <div class="form-group">
                <label class="input-label">Tanggal Lahir</label>
                <input type="date" name="birth_date" value="{{ old('birth_date', $applicant->birth_date ? $applicant->birth_date->format('Y-m-d') : '') }}" required>
            </div>

            <div class="form-group">
                <label class="input-label">Jenis Kelamin</label>
                <input type="text" value="{{ $applicant->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}" readonly disabled>
            </div>

            <div class="form-group">
                <label class="input-label">Agama</label>
                <select name="religion" required>
                    <option value="">Pilih Agama...</option>
                    @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $religion)
                        <option value="{{ $religion }}" {{ old('religion', $applicant->religion) == $religion ? 'selected' : '' }}>{{ $religion }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="input-label">Bahasa Sehari-hari</label>
                <input type="text" name="language" value="{{ old('language', $applicant->language ?? 'Indonesia') }}" placeholder="Contoh: Indonesia, Palembang">
            </div>

            <div class="form-group">
                <label class="input-label">Kewarganegaraan</label>
                <input type="text" name="nationality" value="{{ old('nationality', $applicant->nationality ?? 'Indonesia') }}" required>
            </div>

            <div class="form-group grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="form-group">
                    <label class="input-label">Alamat Email</label>
                    <input type="text" value="{{ $applicant->user->email ?? '-' }}" readonly disabled>
                </div>
                <div class="form-group">
                    <label class="input-label">Nomor HP</label>
                    <input type="text" name="phone" value="{{ old('phone', $applicant->phone) }}" placeholder="08xxx..." required>
                </div>
            </div>

            <div class="form-group">
                <label class="input-label">Nomor WhatsApp</label>
                <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $applicant->whatsapp_number) }}" placeholder="08xxx...">
            </div>

            <div class="lg:col-span-2 form-group">
                <label class="input-label">Alamat Tempat Tinggal (Sesuai KK/KTP)</label>
                <textarea name="address" rows="3" required placeholder="Alamat lengkap sesuai KK/KTP...">{{ old('address', $applicant->address) }}</textarea>
            </div>
            
            <div class="lg:col-span-2 form-group">
                <label class="input-label">Tempat Tinggal Sekarang (Domisili)</label>
                <textarea name="current_address" rows="3" required placeholder="Alamat lengkap tempat tinggal saat ini...">{{ old('current_address', $applicant->current_address) }}</textarea>
            </div>
        </div>
    </div>

    <!-- Section 2: Keluarga -->
    <div class="mb-10">
        <div class="section-header">
            <div class="section-number">2</div>
            <h3 class="section-title">Komposisi Keluarga</h3>
        </div>
        
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="form-group">
                <label class="input-label">Anak Ke-</label>
                <input type="number" name="child_order" value="{{ old('child_order', $applicant->child_order) }}" min="1">
            </div>
            <div class="form-group">
                <label class="input-label">Sdr Kandung</label>
                <input type="number" name="siblings_count" value="{{ old('siblings_count', $applicant->siblings_count) }}" min="0">
            </div>
            <div class="form-group">
                <label class="input-label">Sdr Tiri</label>
                <input type="number" name="half_siblings_count" value="{{ old('half_siblings_count', $applicant->half_siblings_count) }}" min="0">
            </div>
            <div class="form-group">
                <label class="input-label">Sdr Angkat</label>
                <input type="number" name="adopted_siblings_count" value="{{ old('adopted_siblings_count', $applicant->adopted_siblings_count) }}" min="0">
            </div>
        </div>

        <div class="form-group">
            <label class="input-label">Status Keadaan Anak</label>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                @foreach(['lengkap' => 'Lengkap', 'yatim' => 'Yatim', 'piatu' => 'Piatu', 'yatim_piatu' => 'Yatim Piatu'] as $val => $label)
                    <label class="cursor-pointer">
                        <input type="radio" name="child_status" value="{{ $val }}" class="peer hidden" {{ old('child_status', $applicant->child_status) == $val ? 'checked' : '' }}>
                        <div class="card-radio">{{ $label }}</div>
                    </label>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Section 3: Kesehatan -->
    <div class="mb-10">
        <div class="section-header">
            <div class="section-number">3</div>
            <h3 class="section-title">Data Kesehatan & Fisik</h3>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="form-group">
                <label class="input-label">Golongan Darah</label>
                <select name="blood_type">
                    <option value="">Pilih...</option>
                    @foreach(['A', 'B', 'AB', 'O'] as $type)
                        <option value="{{ $type }}" {{ old('blood_type', $applicant->blood_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="input-label">Tinggi Badan (cm)</label>
                <input type="number" name="height" value="{{ old('height', $applicant->height) }}" min="50" max="250" required placeholder="160">
            </div>
            <div class="form-group">
                <label class="input-label">Berat Badan (kg)</label>
                <input type="number" name="weight" value="{{ old('weight', $applicant->weight) }}" min="10" max="200" required placeholder="50">
            </div>
            
            <div class="form-group lg:col-span-3">
                <label class="input-label">Riwayat Penyakit</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach(['TBC', 'Cacar', 'Lever', 'Malaria'] as $disease)
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" name="diseases[]" value="{{ $disease }}" 
                                class="w-5 h-5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                {{ in_array($disease, old('diseases', $applicant->diseases ?? [])) ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-slate-700">{{ $disease }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label class="input-label">Penyakit/Alergi Lainnya (Jika ada)</label>
                <input type="text" name="allergies" value="{{ old('allergies', $applicant->allergies) }}" placeholder="Contoh: Asma, Alergi Dingin">
            </div>

            <div class="form-group">
                <label class="input-label">Kelainan Fisik (Jika ada)</label>
                <input type="text" name="physical_defects" value="{{ old('physical_defects', $applicant->physical_defects) }}" placeholder="Contoh: Mata Minus">
            </div>
        </div>
    </div>

    <!-- Section 4: Psikis & Intellectual -->
    <div class="mb-10">
        <div class="section-header">
            <div class="section-number">4</div>
            <h3 class="section-title">Profil Psikis & Intellectual</h3>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="form-group">
                <label class="input-label">Psikis (Kondisi Psikologis)</label>
                <textarea name="psikis" rows="4" placeholder="Ceritakan kondisi psikologis Anda, misalnya: kepribadian, kelebihan, kelemahan, dll...">{{ old('psikis', $applicant->psikis) }}</textarea>
                <p class="text-xs text-slate-500 mt-1">Tuliskan kondisi psikologis atau karakter diri Anda dengan jujur</p>
            </div>
            
            <div class="form-group">
                <label class="input-label">Intellectual (Kemampuan Intelektual)</label>
                <textarea name="intellectual" rows="4" placeholder="Ceritakan kemampuan intelektual Anda, misalnya: minat akademik, bakat khusus, prestasi intelektual, dll...">{{ old('intellectual', $applicant->intellectual) }}</textarea>
                <p class="text-xs text-slate-500 mt-1">Tuliskan kemampuan intelektual dan minat belajar Anda</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="form-navigation">
        <div></div>
        <button type="submit" class="btn-primary w-full sm:w-auto">
            <span>Simpan & Lanjutkan</span>
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
        </button>
    </div>
</form>
@endsection

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Bukti Pendaftaran</title>
    <style>
        @page {
            size: A4;
            margin: 1cm;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 10pt;
            line-height: 1.3;
            color: #000;
        }
        
        /* Watermark */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            color: rgba(16, 185, 129, 0.1);
            font-weight: bold;
            z-index: -1000;
            white-space: nowrap;
            text-transform: uppercase;
            width: 100%;
            text-align: center;
        }
        
        /* Layout Containers */
        .page-container {
            width: 100%;
            position: relative;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        /* Header */
        .header {
            border-bottom: 3px solid #000;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        
        table.header-table {
            width: 100%;
            border: none;
        }
        
        td.header-logo {
            width: 80px;
            vertical-align: middle;
            text-align: center;
        }
        
        td.header-logo img {
            width: 70px;
            height: auto;
        }
        
        td.header-text {
            vertical-align: middle;
            text-align: center;
        }
        
        .header-text h1 { font-size: 12pt; font-weight: bold; margin: 0; }
        .header-text h2 { font-size: 14pt; font-weight: bold; margin: 2px 0; }
        .header-text .accreditation { font-size: 9pt; font-weight: bold; }
        .header-text .address { font-size: 8pt; }
        
        /* Title Box */
        .title-box {
            text-align: center;
            background: #d1fae5; /* Light Green */
            color: #000;
            font-weight: bold;
            font-size: 11pt;
            padding: 8px;
            margin-bottom: 5px;
            border: 1px solid #10b981; /* Green Border */
        }
        
        .subtitle {
            text-align: center;
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 15px;
            text-transform: uppercase;
        }
        
        /* Identity Layout Table (Data Left, Photo Right) */
        table.identity-layout {
            width: 100%;
            border: none;
            margin-bottom: 10px;
        }
        
        td.identity-data {
            vertical-align: top;
            padding-right: 15px;
        }
        
        td.identity-photo {
            width: 110px;
            vertical-align: top;
            text-align: center;
        }
        
        /* Data Tables */
        .section-header {
            background: #d1fae5; /* Light Green */
            color: #000;
            padding: 3px 10px;
            font-size: 9pt;
            font-weight: bold;
            margin-bottom: 5px;
            text-align: center;
            border: 1px solid #10b981; /* Green Border */
        }
        
        table.data-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table.data-table td {
            vertical-align: top;
            padding: 3px;
            font-size: 9pt;
        }
        
        /* Grades Table */
        table.grades-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            margin-bottom: 15px;
        }
        
        table.grades-table th, table.grades-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            font-size: 9pt;
        }
        
        table.grades-table th {
            background-color: #d1fae5;
            font-weight: bold;
        }
        
        /* Checklist Table */
        table.checklist-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        table.checklist-table th, table.checklist-table td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 9pt;
        }
        
        table.checklist-table th {
            background-color: #d1fae5;
            text-align: center;
            font-weight: bold;
        }
        
        /* Signature */
        .signature-section {
            width: 100%;
            margin-top: 20px;
        }
        
        .signature-box {
            float: right;
            width: 200px;
            text-align: center;
        }
        
        /* Notes */
        .notes-box {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #000;
            background-color: #f0fdf4;
            font-size: 8pt;
            font-style: italic;
            clear: both;
        }
        
        /* Photo Frame */
        .photo-frame {
            width: 3cm; /* 3x4 ratio approx */
            height: 4cm;
            border: 1px solid #000;
            padding: 2px;
            display: inline-block;
        }
        
        .photo-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    @php
        function getBase64($path) {
            $full = public_path($path);
            if (!file_exists($full)) return '';
            $ext = pathinfo($full, PATHINFO_EXTENSION);
            return 'data:image/'.$ext.';base64,'.base64_encode(file_get_contents($full));
        }
        $logoMan = getBase64('images/logo.png');
        $logoKemenag = getBase64('images/logokemenag.jpg');
        $photo = '';
        if ($applicant->photo && file_exists(public_path('storage/'.$applicant->photo))) {
            $photo = getBase64('storage/'.$applicant->photo);
        }
    @endphp

    <div class="watermark">MAN 1 PALEMBANG</div>

    <!-- PAGE 1 -->
    <div class="page-container">
        <!-- Header -->
        <div class="header">
            <table class="header-table">
                <tr>
                    <td class="header-logo"><img src="{{ $logoKemenag }}" alt=""></td>
                    <td class="header-text">
                        <h1>KEMENTERIAN AGAMA REPUBLIK INDONESIA</h1>
                        <h2>MADRASAH ALIYAH NEGERI 1 PALEMBANG</h2>
                        <div class="accreditation">TERAKREDITASI A</div>
                        <div class="address">Jl. Gubernur H. Ahmad Bastari (Rt.Pendidikan) Jakabaring □ FAX. (0711)5820083</div>
                        <div class="address">PALEMBANG 30252 - Website: man1palembang.sch.id</div>
                    </td>
                    <td class="header-logo"><img src="{{ $logoMan }}" alt=""></td>
                </tr>
            </table>
        </div>

        <div class="title-box">
            PANITIA PENERIMAAN MURID BARU (PMB) JALUR {{ strtoupper($applicant->pathway->name ?? 'REGULER') }}<br>
            TAHUN PELAJARAN {{ $applicant->academic_year }}
        </div>

        <div class="subtitle">
            KARTU TANDA DAFTAR PESERTA DIDIK BARU<br>
            <span style="font-weight: normal; font-size: 9pt;">
                NO. DAFTAR : {{ $applicant->registration_number }} &nbsp;|&nbsp; TANGGAL DAFTAR : {{ $applicant->created_at->format('d/m/Y') }}
            </span>
        </div>

        <!-- Layout for Identity & Photo -->
        <table class="identity-layout">
            <tr>
                <td class="identity-data">
                    <div class="section-header">IDENTITAS SISWA</div>
                    <table class="data-table">
                        <tr>
                            <td width="130">NISN / NIS</td>
                            <td width="10">:</td>
                            <td>{{ $applicant->nisn }}</td>
                        </tr>
                        <tr>
                            <td>NIK Siswa</td>
                            <td>:</td>
                            <td>{{ $applicant->nik ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Nama Calon Siswa</td>
                            <td>:</td>
                            <td style="font-weight: bold;">{{ strtoupper($applicant->full_name) }}</td>
                        </tr>
                        <tr>
                            <td>Tempat, Tgl Lahir</td>
                            <td>:</td>
                            <td>{{ $applicant->birth_place }}, {{ $applicant->birth_date ? $applicant->birth_date->format('d/m/Y') : '' }}</td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td>{{ $applicant->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                        <tr>
                            <td>Asal Sekolah</td>
                            <td>:</td>
                            <td>{{ $applicant->education->previous_school_name ?? '-' }}</td>
                        </tr>
                    </table>

                    <div class="section-header" style="margin-top: 10px;">IDENTITAS ORANG TUA/WALI</div>
                    <table class="data-table">
                        <tr>
                            <td width="130">Nama Orang Tua</td>
                            <td width="10">:</td>
                            <td>{{ $applicant->parents->father_name ?? $applicant->parent_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Email / Kontak</td>
                            <td>:</td>
                            <td>{{ $applicant->user->email }}</td>
                        </tr>
                    </table>
                </td>
                <td class="identity-photo">
                    <div class="photo-frame">
                        @if($photo)
                            <img src="{{ $photo }}" alt="Foto">
                        @else
                            <div style="padding-top: 40px; font-size: 8pt;">FOTO<br>3x4</div>
                        @endif
                    </div>
                </td>
            </tr>
        </table>

        <!-- Grades -->
        <div style="margin-top: 10px;">
            <div class="section-header">NILAI RAPOR</div>
            @php
                 $isPmpa = \Illuminate\Support\Str::contains(strtoupper($applicant->pathway->name ?? ''), 'PMPA');
                 $startSem = $isPmpa ? 1 : 3;
                 $labels = [
                     1 => 'Kls 7 Smt 1', 2 => 'Kls 7 Smt 2',
                     3 => 'Kls 8 Smt 1', 4 => 'Kls 8 Smt 2',
                     5 => 'Kls 9 Smt 1'
                 ];
                 $grades = $applicant->grades->groupBy('subject')['average']->pluck('grade', 'semester')->toArray() ?? [];
                 $avg = count($grades) > 0 ? number_format(array_sum($grades)/count($grades), 2) : '0.00';
            @endphp
            <table class="grades-table">
                <tr>
                    @for($s=$startSem; $s<=5; $s++) <th>{{ $labels[$s] }}</th> @endfor
                    <th>Rata-Rata</th>
                </tr>
                <tr>
                    @for($s=$startSem; $s<=5; $s++) <td>{{ isset($grades[$s]) ? number_format($grades[$s], 2) : '-' }}</td> @endfor
                    <td style="font-weight: bold;">{{ $avg }}</td>
                </tr>
            </table>
        </div>

        <!-- Signature -->
        <div class="signature-section">
            <div class="signature-box">
                <p>Palembang, {{ now()->format('d/m/Y') }}</p>
                <p style="margin-bottom: 50px;">Panitia,</p>
            </div>
            <div style="clear: both;"></div>
        </div>

        <div class="notes-box">
            <strong>Catatan:</strong><br>
            1. Kartu ini wajib dibawa saat verifikasi berkas.<br>
            2. Data yang tertera adalah data yang diinput oleh calon siswa dan dapat dipertanggungjawabkan.
        </div>
    </div>

    <!-- PAGE 2 -->
    <div class="page-container page-break">
        <!-- Header Repeat -->
        <div class="header">
            <table class="header-table">
                <tr>
                    <td class="header-logo"><img src="{{ $logoKemenag }}" alt=""></td>
                    <td class="header-text">
                        <h1>KEMENTERIAN AGAMA REPUBLIK INDONESIA</h1>
                        <h2>MADRASAH ALIYAH NEGERI 1 PALEMBANG</h2>
                        <div class="accreditation">TERAKREDITASI A</div>
                        <div class="address">Jl. Gubernur H. Ahmad Bastari (Rt.Pendidikan) Jakabaring □ FAX. (0711)5820083</div>
                        <div class="address">PALEMBANG 30252 - Website: man1palembang.sch.id</div>
                    </td>
                    <td class="header-logo"><img src="{{ $logoMan }}" alt=""></td>
                </tr>
            </table>
        </div>

        <div class="title-box">DAFTAR CHECKLIST DOKUMEN</div>
        
        <table class="data-table" style="margin-bottom: 15px;">
             <tr>
                <td width="100">No. Daftar</td>
                <td width="10">:</td>
                <td style="font-weight: bold;">{{ $applicant->registration_number }}</td>
             </tr>
             <tr>
                <td>Nama Siswa</td>
                <td>:</td>
                <td>{{ strtoupper($applicant->full_name) }}</td>
             </tr>
        </table>

        <table class="checklist-table">
            <thead>
                <tr>
                    <th width="30">No</th>
                    <th>Nama Dokumen</th>
                    <th width="100">Check</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $docs = [
                        'Cetak Kartu Bukti Daftar (2 Rangkap)',
                        'Fotokopi Kartu Keluarga (1 lembar)',
                        'Pas Foto 3x4 (3 lembar)',
                        'Pas Foto 2x3 (3 lembar)',
                        'Rapor Semester 1-5 Dilegalisir',
                    ];
                    
                    if (str_contains(strtoupper($applicant->pathway->name ?? ''), 'TAHFIDZ')) {
                        $docs[] = 'Sertifikat Hafalan / Bukti Hafalan';
                    }
                    
                    $docs[] = 'Dokumen Pendukung Lainnya';

                @endphp
                @foreach($docs as $i => $d)
                <tr>
                    <td style="text-align: center;">{{ $i+1 }}</td>
                    <td>{{ $d }}</td>
                    <td style="text-align: center; color: #ccc;">[ &nbsp;&nbsp;&nbsp; ]</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="notes-box">
            <strong>Instruksi:</strong><br>
            Mohon urutkan berkas sesuai nomor urut di atas. Coret yang tidak perlu.
        </div>

        <table style="width: 100%; margin-top: 50px; text-align: center;">
             <tr>
                 <td width="50%">
                     Verifikator,<br><br><br><br>
                     (___________________)
                 </td>
                 <td width="50%">
                     Siswa,<br><br><br><br>
                     ( {{ $applicant->full_name }} )
                 </td>
             </tr>
        </table>
    </div>
</body>
</html>

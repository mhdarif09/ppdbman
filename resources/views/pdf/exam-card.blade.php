<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Ujian Masuk</title>
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
            font-size: 11pt;
            line-height: 1.3;
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

        .header {
            border-bottom: 3px solid #000;
            padding-bottom: 5px;
            margin-bottom: 20px;
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
        .header-text .address { font-size: 9pt; }

        .card-title {
            text-align: center;
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
            border: 2px solid #000;
            padding: 10px;
            background-color: #f0fdf4;
        }

        .exam-info-table {
            width: 100%;
            margin-bottom: 20px;
            margin-top: 20px;
        }

        .exam-info-table td {
            padding: 8px;
            vertical-align: top;
        }

        .photo-frame {
            width: 3cm;
            height: 4cm;
            border: 1px solid #000;
            padding: 2px;
            margin: 0 auto;
        }

        .photo-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .schedule-box {
            border: 1px solid #000;
            padding: 15px;
            margin-top: 20px;
        }

        .footer {
            margin-top: 50px;
            text-align: right;
            padding-right: 50px;
        }
    </style>
</head>
<body>
    @php
        function getBase64Img($path) {
            $full = public_path($path);
            if (!file_exists($full)) return '';
            $ext = pathinfo($full, PATHINFO_EXTENSION);
            return 'data:image/'.$ext.';base64,'.base64_encode(file_get_contents($full));
        }
        $logoMan = getBase64Img('images/logo.png');
        $logoKemenag = getBase64Img('images/logokemenag.jpg');
        $photo = '';
        if ($applicant->photo && file_exists(public_path('storage/'.$applicant->photo))) {
            $photo = getBase64Img('storage/'.$applicant->photo);
        }
    @endphp

    <div class="watermark">KARTU UJIAN</div>

    <div class="header">
        <table class="header-table">
            <tr>
                <td class="header-logo"><img src="{{ $logoKemenag }}" alt=""></td>
                <td class="header-text">
                    <h1>KEMENTERIAN AGAMA REPUBLIK INDONESIA</h1>
                    <h2>MADRASAH ALIYAH NEGERI 1 PALEMBANG</h2>
                    <div class="address">Jl. Gubernur H. Ahmad Bastari (Rt.Pendidikan) Jakabaring</div>
                </td>
                <td class="header-logo"><img src="{{ $logoMan }}" alt=""></td>
            </tr>
        </table>
    </div>

    <div class="card-title">
        KARTU PESERTA UJIAN MASUK<br>
        TAHUN PELAJARAN {{ $applicant->academic_year }}
    </div>

    <table class="exam-info-table">
        <tr>
            <td width="60%">
                <table style="width: 100%;">
                    <tr>
                        <td width="140"><strong>NOMOR PESERTA</strong></td>
                        <td width="10">:</td>
                        <td style="font-size: 14pt; font-weight: bold;">{{ $applicant->registration_number }}</td>
                    </tr>
                    <tr>
                        <td><strong>NAMA PESERTA</strong></td>
                        <td>:</td>
                        <td>{{ strtoupper($applicant->full_name) }}</td>
                    </tr>
                    <tr>
                        <td><strong>TEMPAT, TGL LAHIR</strong></td>
                        <td>:</td>
                        <td>{{ $applicant->birth_place }}, {{ $applicant->birth_date ? $applicant->birth_date->format('d/m/Y') : '' }}</td>
                    </tr>
                    <tr>
                        <td><strong>JENIS KELAMIN</strong></td>
                        <td>:</td>
                        <td>{{ $applicant->gender == 'L' ? 'LAKI-LAKI' : 'PEREMPUAN' }}</td>
                    </tr>
                    <tr>
                        <td><strong>ASAL SEKOLAH</strong></td>
                        <td>:</td>
                        <td>{{ $applicant->education->previous_school_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>JALUR SELEKSI</strong></td>
                        <td>:</td>
                        <td>{{ strtoupper($applicant->pathway->name ?? '-') }}</td>
                    </tr>
                    <tr>
                        <td><strong>LOKASI TES</strong></td>
                        <td>:</td>
                        <td style="font-weight: bold;">MAN 1 PALEMBANG</td>
                    </tr>
                </table>
            </td>
            <td width="40%" style="text-align: center;">
                <div class="photo-frame">
                    @if($photo)
                        <img src="{{ $photo }}" alt="Foto">
                    @else
                        <div style="padding-top: 50px;">FOTO<br>3x4</div>
                    @endif
                </div>
            </td>
        </tr>
    </table>

    <div class="schedule-box">
        <strong>CATATAN PENTING:</strong>
        <ol style="margin-left: 20px; margin-top: 10px;">
            <li>Kartu ini wajib dibawa saat mengikuti tes seleksi.</li>
            <li>Peserta wajib hadir 30 menit sebelum jadwal tes dimulai.</li>
            <li>Memakai seragam sekolah asal dan bersepatu.</li>
            <li>Membawa alat tulis (Pensil 2B, Penghapus, Pena Hitam, Papan Ujian).</li>
            <li>Dilarang membawa HP/Alat komunikasi ke dalam ruang ujian.</li>
        </ol>
    </div>

    <div class="footer">
        <p>Palembang, {{ now()->format('d F Y') }}</p>
        <p>Panitia PMB,</p>
        <br><br><br>
        <p><strong>TTD / CAP</strong></p>
    </div>
</body>
</html>

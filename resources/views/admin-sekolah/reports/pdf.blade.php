<!DOCTYPE html>
<html>
<head>
    <title>Laporan PPDB - {{ $schoolName }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { bg-color: #f2f2f2; font-weight: bold; }
        .badge { padding: 3px 6px; border-radius: 3px; font-size: 10px; color: white; }
        .badge-pending { background-color: #f59e0b; }
        .badge-verified { background-color: #3b82f6; }
        .badge-accepted { background-color: #10b981; }
        .badge-rejected { background-color: #ef4444; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Pendaftar PPDB</h1>
        <p>{{ $schoolName }}</p>
        <p>Tahun Ajaran {{ $academicYear }}</p>
        <p>Dicetak pada: {{ date('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Pendaftaran</th>
                <th>NISN</th>
                <th>Nama Lengkap</th>
                <th>Jalur</th>
                <th>Status</th>
                <th>Tgl Daftar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applicants as $index => $applicant)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $applicant->registration_number }}</td>
                    <td>{{ $applicant->nisn }}</td>
                    <td>{{ $applicant->full_name }}</td>
                    <td>{{ $applicant->pathway->name ?? '-' }}</td>
                    <td>
                        <span class="badge badge-{{ $applicant->status }}">
                            {{ ucfirst($applicant->status) }}
                        </span>
                    </td>
                    <td>{{ $applicant->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data pendaftar</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>

@extends('layouts.verifikator')

@section('title', 'Riwayat Verifikasi')
@section('page-title', 'Riwayat Verifikasi Saya')

@section('content')
<div class="space-y-6">
    <div class="card overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Waktu Verifikasi</th>
                        <th>No. Reg</th>
                        <th>Nama Siswa</th>
                        <th>Jalur</th>
                        <th>Keputusan</th>
                        <th class="text-right">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applicants as $applicant)
                        <tr>
                            <td class="text-sm text-gray-500">
                                {{ $applicant->verified_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="font-mono text-sm">
                                {{ $applicant->registration_number }}
                            </td>
                            <td class="font-medium">
                                {{ $applicant->full_name }}
                            </td>
                            <td>
                                {{ $applicant->pathway->name }}
                            </td>
                            <td>
                                @if($applicant->status == 'verified')
                                    <span class="badge badge-success">Diterima</span>
                                @else
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <a href="{{ route('verifikator.verification.show', $applicant) }}" class="btn btn-sm btn-secondary">
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-gray-500">
                                Belum ada riwayat verifikasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($applicants->hasPages())
        <div class="flex justify-center">
            {{ $applicants->links() }}
        </div>
    @endif
</div>
@endsection

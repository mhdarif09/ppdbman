<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class KemendikbudService
{
    /**
     * Check NISN from Kemendikbud API (Mock)
     */
    public function checkNisn(string $nisn)
    {
        // Placeholder for actual API call
        // $response = Http::get('https://api.kemendikbud.go.id/nisn', ['nisn' => $nisn]);
        // if ($response->failed()) return null;

        // Mock Logic for Development
        // Simulate valid NISN
        if (strlen($nisn) === 10) {
            return [
                'nisn' => $nisn,
                'nama' => 'Siswa Simulasi ' . substr($nisn, -4),
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2010-01-01',
                'jenis_kelamin' => 'L',
                'nama_ibu_kandung' => 'Ibu Simulasi',
            ];
        }

        return null;
    }
}

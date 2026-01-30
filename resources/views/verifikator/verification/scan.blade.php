@extends('layouts.verifikator')

@section('title', 'Scan QR Code')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Back Button -->
        <a href="{{ route('verifikator.verification.index') }}" class="inline-flex items-center text-green-700 hover:text-green-900 mb-6">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Verifikasi
        </a>

        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-green-700 to-green-900 text-white px-6 py-4">
                <h1 class="text-2xl font-bold">Scan QR Code Pendaftaran</h1>
                <p class="text-green-100 mt-1">Scan kartu bukti pendaftaran siswa untuk verifikasi</p>
            </div>
        </div>

        <!-- QR Scanner -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div id="reader" class="mb-4"></div>
            
            <div id="result" class="hidden">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <p class="text-green-800 font-semibold mb-2">QR Code Terdeteksi!</p>
                    <p class="text-sm text-green-600">Mengalihkan ke halaman verifikasi...</p>
                </div>
            </div>

            <div id="error" class="hidden">
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <p class="text-red-800 font-semibold mb-2">QR Code Tidak Valid</p>
                    <p class="text-sm text-red-600">Silakan scan ulang kartu pendaftaran yang valid.</p>
                </div>
            </div>

            <!-- Instructions -->
            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="font-semibold text-gray-700 mb-2">Petunjuk:</h3>
                <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                    <li>Pastikan QR Code terlihat jelas di kamera</li>
                    <li>QR Code terdapat di pojok kanan bawah kartu pendaftaran</li>
                    <li>Pastikan pencahayaan cukup untuk membaca QR Code</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- HTML5 QR Code Library -->
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Show result
        document.getElementById('result').classList.remove('hidden');
        
        // Check if URL contains /verifikasi/ route
        if (decodedText.includes('/verifikasi/')) {
            // Extract token from URL
            const urlParts = decodedText.split('/verifikasi/');
            if (urlParts.length > 1) {
                const token = urlParts[1].split('?')[0]; // Remove any query params
                
                // Redirect to verification page
                setTimeout(() => {
                    window.location.href = '{{ route("verifikator.verification.by-token", "") }}/' + token;
                }, 1000);
            } else {
                showError();
            }
        } else {
            showError();
        }
    }

    function showError() {
        document.getElementById('result').classList.add('hidden');
        document.getElementById('error').classList.remove('hidden');
        
        setTimeout(() => {
            document.getElementById('error').classList.add('hidden');
        }, 3000);
    }

    function onScanFailure(error) {
        // Handle scan failure silently
        // console.warn(`QR Code scan error: ${error}`);
    }

    // Initialize QR Scanner
    const html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", 
        { 
            fps: 10, 
            qrbox: { width: 250, height: 250 },
            aspectRatio: 1.0
        },
        false
    );
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>

<style>
    #reader {
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        overflow: hidden;
    }
    
    #reader video {
        width: 100% !important;
        border-radius: 0.5rem;
    }
</style>
@endsection

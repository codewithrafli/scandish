@extends('layouts.app')

@section('content')
    <div id="Background"
        class="absolute top-0 w-full h-[300px] rounded-b-[45px] bg-[linear-gradient(90deg,#FF923C_0%,#FF801A_100%)]">
    </div>

    <div id="ScanQR" class="relative flex flex-col items-center justify-center min-h-screen px-5 py-10">
        <div class="flex flex-col items-center gap-6 mt-[60px]">
            <div class="flex flex-col items-center gap-3">
                <h1 class="text-white font-semibold text-3xl text-center">Scan QR Code</h1>
                <p class="text-white text-opacity-90 text-center max-w-sm">
                    Scan QR code untuk mengakses menu toko
                </p>
            </div>

            <div class="relative w-full max-w-[400px] mt-8">
                <div id="qr-reader" class="w-full rounded-[20px] overflow-hidden bg-white p-4 shadow-lg">
                    <div id="qr-reader-results" class="hidden"></div>
                </div>
                <div id="qr-shaded-region" class="absolute inset-0 pointer-events-none">
                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[250px] h-[250px] border-4 border-white rounded-lg"></div>
                </div>
            </div>

            <div class="flex flex-col items-center gap-4 mt-8">
                <p class="text-white text-opacity-80 text-sm text-center max-w-xs">
                    Arahkan kamera ke QR code yang tersedia di meja
                </p>
                <div class="flex items-center gap-2 text-white text-opacity-70 text-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <span>Izinkan akses kamera untuk memulai scan</span>
                </div>
            </div>
        </div>

        <div id="error-message" class="hidden mt-6 p-4 bg-red-500 bg-opacity-20 border border-red-500 rounded-lg text-white text-sm text-center max-w-sm">
            <p id="error-text"></p>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        let html5QrcodeScanner;
        let isScanning = false;

        function onScanSuccess(decodedText, decodedResult) {
            // Stop scanning
            if (html5QrcodeScanner && isScanning) {
                html5QrcodeScanner.clear();
                isScanning = false;
            }

            // Hide error message
            document.getElementById('error-message').classList.add('hidden');

            // Extract username from URL
            // Expected format: http://domain.com/username or /username
            let username = decodedText;
            
            // If it's a full URL, extract the username
            try {
                const url = new URL(decodedText);
                const pathParts = url.pathname.split('/').filter(part => part);
                if (pathParts.length > 0) {
                    username = pathParts[pathParts.length - 1];
                }
            } catch (e) {
                // If it's not a valid URL, try to extract from path
                const pathParts = decodedText.split('/').filter(part => part);
                if (pathParts.length > 0) {
                    username = pathParts[pathParts.length - 1];
                }
            }

            // Redirect to the store page
            if (username) {
                window.location.href = `/${username}`;
            } else {
                showError('QR code tidak valid. Pastikan QR code dari toko yang benar.');
                startScanning();
            }
        }

        function onScanFailure(error) {
            // Handle scan failure, ignore if it's just "NotFoundException"
            if (error && !error.includes('NotFoundException')) {
                console.warn('QR Code scan error:', error);
            }
        }

        function showError(message) {
            const errorDiv = document.getElementById('error-message');
            const errorText = document.getElementById('error-text');
            errorText.textContent = message;
            errorDiv.classList.remove('hidden');
            
            setTimeout(() => {
                errorDiv.classList.add('hidden');
            }, 5000);
        }

        function startScanning() {
            if (isScanning) return;

            html5QrcodeScanner = new Html5Qrcode("qr-reader");
            const qrCodeSuccessCallback = onScanSuccess;
            const qrCodeErrorCallback = onScanFailure;

            const config = {
                fps: 10,
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0,
                disableFlip: false
            };

            html5QrcodeScanner.start(
                { facingMode: "environment" }, // Use back camera
                config,
                qrCodeSuccessCallback,
                qrCodeErrorCallback
            ).then(() => {
                isScanning = true;
            }).catch((err) => {
                console.error('Error starting QR scanner:', err);
                showError('Tidak dapat mengakses kamera. Pastikan Anda memberikan izin akses kamera.');
            });
        }

        // Start scanning when page loads
        document.addEventListener('DOMContentLoaded', () => {
            startScanning();
        });

        // Clean up when page unloads
        window.addEventListener('beforeunload', () => {
            if (html5QrcodeScanner && isScanning) {
                html5QrcodeScanner.clear().catch(err => {
                    console.error('Error stopping QR scanner:', err);
                });
            }
        });
    </script>
@endsection


<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex flex-col items-center justify-center p-4 space-y-4">
            <h2 class="text-lg font-bold text-gray-800 dark:text-white">Store QR Code</h2>
            
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate(url('/' . Auth::user()->username)) !!}
            </div>
            
            <p class="text-sm text-gray-500 dark:text-gray-400 text-center">
                Scan QR code ini untuk mengunjungi toko Anda<br>
                <span class="font-mono text-xs">{{ url('/' . Auth::user()->username) }}</span>
            </p>
            
            <x-filament::button
                tag="a"
                href="{{ route('download-qr') }}"
                target="_blank"
                icon="heroicon-o-arrow-down-tray"
                color="primary"
            >
                Download QR Code
            </x-filament::button>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>

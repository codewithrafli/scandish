<x-filament-widgets::widget>
    <x-filament::section class="h-full">
        <div class="flex flex-col items-center justify-center h-full space-y-6 text-center">
            <div class="space-y-2">
                <h2 class="text-xl font-bold tracking-tight text-gray-950 dark:text-white">
                    QR Code Toko
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Bagikan QR Code ini kepada pelanggan Anda
                </p>
            </div>

            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-primary-600 to-secondary-600 rounded-xl blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                <div class="relative bg-white p-6 rounded-xl shadow-lg ring-1 ring-gray-900/5">
                    <div class="flex flex-col items-center space-y-4">
                        @if(Auth::user()->logo)
                            <img src="{{ asset('storage/' . Auth::user()->logo) }}" alt="Store Logo" class="h-12 w-12 rounded-full object-cover border-2 border-gray-100">
                        @else
                            <div class="h-12 w-12 rounded-full bg-primary-50 flex items-center justify-center text-primary-600 font-bold text-xl">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @endif
                        
                        <div class="bg-white p-2 rounded-lg">
                            {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(180)->margin(1)->generate(url('/' . Auth::user()->username)) !!}
                        </div>

                        <div class="text-center">
                            <h3 class="font-semibold text-gray-900">{{ Auth::user()->name }}</h3>
                            <p class="text-xs text-gray-500 font-mono mt-1">{{ url('/' . Auth::user()->username) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-3 justify-center w-full">
                <x-filament::button
                    tag="a"
                    href="{{ route('download-qr') }}"
                    target="_blank"
                    icon="heroicon-o-arrow-down-tray"
                    color="primary"
                    class="w-full sm:w-auto"
                >
                    Download QR Code
                </x-filament::button>

                <x-filament::button
                    color="gray"
                    icon="heroicon-o-clipboard"
                    class="w-full sm:w-auto"
                    x-on:click="window.navigator.clipboard.writeText('{{ url('/' . Auth::user()->username) }}'); $tooltip('URL Copied!', { theme: 'success' })"
                >
                    Copy URL
                </x-filament::button>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>

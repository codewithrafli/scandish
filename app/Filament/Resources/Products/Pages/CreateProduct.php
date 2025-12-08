<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\Products\Pages; // Namespace untuk pages produk

use App\Filament\Resources\Products\ProductResource; // Import ProductResource
use Filament\Resources\Pages\CreateRecord; // Import CreateRecord base class

class CreateProduct extends CreateRecord // Kelas untuk halaman create produk
{
    protected static string $resource = ProductResource::class; // Set resource yang digunakan

    protected function getRedirectUrl(): string // Method untuk mendapatkan URL redirect setelah create
    {
        return $this->getResource()::getUrl('index'); // Redirect ke halaman index setelah create
    }
}

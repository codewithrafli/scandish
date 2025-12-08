<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\ProductCategories\Pages; // Namespace untuk pages kategori produk

use App\Filament\Resources\ProductCategories\ProductCategoryResource; // Import ProductCategoryResource
use Filament\Resources\Pages\CreateRecord; // Import CreateRecord base class

class CreateProductCategory extends CreateRecord // Kelas untuk halaman create kategori produk
{
    protected static string $resource = ProductCategoryResource::class; // Set resource yang digunakan

    protected function getRedirectUrl(): string // Method untuk mendapatkan URL redirect setelah create
    {
        return $this->getResource()::getUrl('index'); // Redirect ke halaman index setelah create
    }
}

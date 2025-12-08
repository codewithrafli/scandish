<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\ProductCategories\Pages; // Namespace untuk pages kategori produk

use App\Filament\Resources\ProductCategories\ProductCategoryResource; // Import ProductCategoryResource
use Filament\Actions\CreateAction; // Import CreateAction
use Filament\Resources\Pages\ListRecords; // Import ListRecords base class

class ListProductCategories extends ListRecords // Kelas untuk halaman list kategori produk
{
    protected static string $resource = ProductCategoryResource::class; // Set resource yang digunakan

    protected function getHeaderActions(): array // Method untuk mendapatkan header actions
    {
        return [ // Mengembalikan array actions
            CreateAction::make(), // Action untuk create kategori produk baru
        ];
    }
}

<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\Products\Pages; // Namespace untuk pages produk

use App\Filament\Resources\Products\ProductResource; // Import ProductResource
use Filament\Actions\CreateAction; // Import CreateAction
use Filament\Resources\Pages\ListRecords; // Import ListRecords base class

class ListProducts extends ListRecords // Kelas untuk halaman list produk
{
    protected static string $resource = ProductResource::class; // Set resource yang digunakan

    protected function getHeaderActions(): array // Method untuk mendapatkan header actions
    {
        return [ // Mengembalikan array actions
            CreateAction::make(), // Action untuk create produk baru
        ];
    }
}

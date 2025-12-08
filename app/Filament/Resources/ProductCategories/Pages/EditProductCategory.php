<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\ProductCategories\Pages; // Namespace untuk pages kategori produk

use App\Filament\Resources\ProductCategories\ProductCategoryResource; // Import ProductCategoryResource
use Filament\Actions\DeleteAction; // Import DeleteAction
use Filament\Actions\ForceDeleteAction; // Import ForceDeleteAction
use Filament\Actions\RestoreAction; // Import RestoreAction
use Filament\Resources\Pages\EditRecord; // Import EditRecord base class

class EditProductCategory extends EditRecord // Kelas untuk halaman edit kategori produk
{
    protected static string $resource = ProductCategoryResource::class; // Set resource yang digunakan

    protected function getHeaderActions(): array // Method untuk mendapatkan header actions
    {
        return [ // Mengembalikan array actions
            DeleteAction::make(), // Action untuk soft delete
            ForceDeleteAction::make(), // Action untuk force delete
            RestoreAction::make(), // Action untuk restore
        ];
    }

    protected function getRedirectUrl(): string // Method untuk mendapatkan URL redirect setelah edit
    {
        return $this->getResource()::getUrl('index'); // Redirect ke halaman index setelah edit
    }
}

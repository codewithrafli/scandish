<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\Users\Pages; // Namespace untuk pages user

use App\Filament\Resources\Users\UserResource; // Import UserResource
use Filament\Actions\DeleteAction; // Import DeleteAction
use Filament\Resources\Pages\EditRecord; // Import EditRecord base class

class EditUser extends EditRecord // Kelas untuk halaman edit user
{
    protected static string $resource = UserResource::class; // Set resource yang digunakan

    protected function getHeaderActions(): array // Method untuk mendapatkan header actions
    {
        return [ // Mengembalikan array actions
            DeleteAction::make(), // Action untuk delete user
        ];
    }

    protected function getRedirectUrl(): string // Method untuk mendapatkan URL redirect setelah edit
    {
        return $this->getResource()::getUrl('index'); // Redirect ke halaman index setelah edit
    }
}

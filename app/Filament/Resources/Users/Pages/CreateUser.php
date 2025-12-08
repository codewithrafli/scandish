<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\Users\Pages; // Namespace untuk pages user

use App\Filament\Resources\Users\UserResource; // Import UserResource
use Filament\Resources\Pages\CreateRecord; // Import CreateRecord base class

class CreateUser extends CreateRecord // Kelas untuk halaman create user
{
    protected static string $resource = UserResource::class; // Set resource yang digunakan

    protected function getRedirectUrl(): string // Method untuk mendapatkan URL redirect setelah create
    {
        return $this->getResource()::getUrl('index'); // Redirect ke halaman index setelah create
    }
}

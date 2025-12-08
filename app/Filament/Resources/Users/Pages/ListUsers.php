<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\Users\Pages; // Namespace untuk pages user

use App\Filament\Resources\Users\UserResource; // Import UserResource
use Filament\Actions\CreateAction; // Import CreateAction
use Filament\Resources\Pages\ListRecords; // Import ListRecords base class

class ListUsers extends ListRecords // Kelas untuk halaman list user
{
    protected static string $resource = UserResource::class; // Set resource yang digunakan

    protected function getHeaderActions(): array // Method untuk mendapatkan header actions
    {
        return [ // Mengembalikan array actions
            CreateAction::make(), // Action untuk create user baru
        ];
    }
}

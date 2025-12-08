<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\Subscriptions\Pages; // Namespace untuk pages subscription

use App\Filament\Resources\Subscriptions\SubscriptionResource; // Import SubscriptionResource
use Filament\Actions\CreateAction; // Import CreateAction
use Filament\Resources\Pages\ListRecords; // Import ListRecords base class

class ListSubscriptions extends ListRecords // Kelas untuk halaman list subscription
{
    protected static string $resource = SubscriptionResource::class; // Set resource yang digunakan

    protected function getHeaderActions(): array // Method untuk mendapatkan header actions
    {
        return [ // Mengembalikan array actions
            CreateAction::make(), // Action untuk create subscription baru
        ];
    }
}

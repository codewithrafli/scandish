<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\Subscriptions\Pages; // Namespace untuk pages subscription

use App\Filament\Resources\Subscriptions\SubscriptionResource; // Import SubscriptionResource
use Filament\Resources\Pages\CreateRecord; // Import CreateRecord base class

class CreateSubscription extends CreateRecord // Kelas untuk halaman create subscription
{
    protected static string $resource = SubscriptionResource::class; // Set resource yang digunakan

    protected function getRedirectUrl(): string // Method untuk mendapatkan URL redirect setelah create
    {
        return $this->getResource()::getUrl('index'); // Redirect ke halaman index setelah create
    }
}

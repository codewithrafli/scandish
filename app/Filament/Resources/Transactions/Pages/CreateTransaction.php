<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\Transactions\Pages; // Namespace untuk pages transaksi

use App\Filament\Resources\Transactions\TransactionResource; // Import TransactionResource
use Filament\Resources\Pages\CreateRecord; // Import CreateRecord base class

class CreateTransaction extends CreateRecord // Kelas untuk halaman create transaksi
{
    protected static string $resource = TransactionResource::class; // Set resource yang digunakan

    protected function getRedirectUrl(): string // Method untuk mendapatkan URL redirect setelah create
    {
        return $this->getResource()::getUrl('index'); // Redirect ke halaman index setelah create
    }
}

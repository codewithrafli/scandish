<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\Transactions\Pages; // Namespace untuk pages transaksi

use App\Filament\Resources\Transactions\TransactionResource; // Import TransactionResource
use Filament\Actions\CreateAction; // Import CreateAction
use Filament\Resources\Pages\ListRecords; // Import ListRecords base class

class ListTransactions extends ListRecords // Kelas untuk halaman list transaksi
{
    protected static string $resource = TransactionResource::class; // Set resource yang digunakan

    protected function getHeaderActions(): array // Method untuk mendapatkan header actions
    {
        return [ // Mengembalikan array actions
            CreateAction::make(), // Action untuk create transaksi baru
        ];
    }
}

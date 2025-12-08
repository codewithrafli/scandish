<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\Transactions; // Namespace untuk resource transaksi

use App\Filament\Resources\Transactions\Pages\CreateTransaction; // Import CreateTransaction page
use App\Filament\Resources\Transactions\Pages\EditTransaction; // Import EditTransaction page
use App\Filament\Resources\Transactions\Pages\ListTransactions; // Import ListTransactions page
use App\Filament\Resources\Transactions\Schemas\TransactionForm; // Import TransactionForm schema
use App\Filament\Resources\Transactions\Tables\TransactionsTable; // Import TransactionsTable
use App\Models\Transaction; // Import model Transaction
use BackedEnum; // Import BackedEnum type
use Filament\Resources\Resource; // Import Resource base class
use Filament\Schemas\Schema; // Import Schema class
use Filament\Support\Icons\Heroicon; // Import Heroicon untuk icon
use Filament\Tables\Table; // Import Table class
use Illuminate\Database\Eloquent\Builder; // Import Builder untuk query
use Illuminate\Database\Eloquent\Model; // Import Model class
use Illuminate\Database\Eloquent\SoftDeletingScope; // Import SoftDeletingScope
use Illuminate\Support\Facades\Auth; // Import Auth facade untuk autentikasi
use UnitEnum; // Import UnitEnum type

class TransactionResource extends Resource // Kelas resource untuk Transaction
{
    protected static ?string $model = Transaction::class; // Set model yang digunakan

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CurrencyDollar; // Set icon navigasi menjadi CurrencyDollar

    protected static ?int $navigationSort = 3; // Set urutan navigasi menjadi 3 (setelah Product dan Subscriptions)

    public static function getEloquentQuery(): Builder // Method untuk mendapatkan query builder
    {
        $user = Auth::user(); // Ambil user yang sedang login

        if ($user->role === 'admin') { // Jika user adalah admin
            return parent::getEloquentQuery(); // Kembalikan semua query tanpa filter
        }

        return parent::getEloquentQuery()->where('user_id', $user->id); // Jika bukan admin, filter berdasarkan user_id
    }

    public static function form(Schema $schema): Schema // Method untuk mendapatkan form schema
    {
        return TransactionForm::configure($schema); // Kembalikan form yang sudah dikonfigurasi
    }

    public static function table(Table $table): Table // Method untuk mendapatkan table configuration
    {
        return TransactionsTable::configure($table); // Kembalikan table yang sudah dikonfigurasi
    }

    public static function getRelations(): array // Method untuk mendapatkan relasi
    {
        return [ // Mengembalikan array relasi
            // Tidak ada relasi yang didefinisikan
        ];
    }

    public static function getPages(): array // Method untuk mendapatkan pages
    {
        return [ // Mengembalikan array pages
            'index' => ListTransactions::route('/'), // Route untuk list page
            'create' => CreateTransaction::route('/create'), // Route untuk create page
            'edit' => EditTransaction::route('/{record}/edit'), // Route untuk edit page
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder // Method untuk query route binding
    {
        return parent::getRecordRouteBindingEloquentQuery() // Ambil query dari parent
            ->withoutGlobalScopes([ // Tanpa global scopes
                SoftDeletingScope::class, // Termasuk soft deleted records
            ]);
    }

    public static function getGloballySearchableAttributes(): array // Method untuk menentukan atribut yang bisa dicari di global search
    {
        return ['code', 'name', 'phone_number']; // Atribut yang bisa dicari: kode, nama, dan nomor telepon
    }

    public static function getGlobalSearchResultTitle(Model $record): string // Method untuk menampilkan title di global search results
    {
        /** @var Transaction $record */ // Type hint untuk IDE
        return $record->code . ' - ' . $record->name; // Tampilkan kode dan nama transaksi
    }

    public static function getGlobalSearchResultDetails(Model $record): array // Method untuk menampilkan detail di global search results
    {
        /** @var Transaction $record */ // Type hint untuk IDE
        return [ // Mengembalikan array detail
            'Status' => ucfirst($record->status), // Tampilkan status
            'Total' => 'Rp ' . number_format($record->total_price), // Tampilkan total harga
            'Tanggal' => $record->created_at->format('d/m/Y H:i'), // Tampilkan tanggal
        ];
    }
}

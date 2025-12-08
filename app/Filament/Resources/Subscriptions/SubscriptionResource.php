<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\Subscriptions; // Namespace untuk resource subscription

use App\Filament\Resources\Subscriptions\Pages\CreateSubscription; // Import CreateSubscription page
use App\Filament\Resources\Subscriptions\Pages\EditSubscription; // Import EditSubscription page
use App\Filament\Resources\Subscriptions\Pages\ListSubscriptions; // Import ListSubscriptions page
use App\Filament\Resources\Subscriptions\Schemas\SubscriptionForm; // Import SubscriptionForm schema
use App\Filament\Resources\Subscriptions\Tables\SubscriptionsTable; // Import SubscriptionsTable
use App\Models\Subscription; // Import model Subscription
use BackedEnum; // Import BackedEnum type
use Filament\Resources\Resource; // Import Resource base class
use Filament\Schemas\Schema; // Import Schema class
use Filament\Support\Icons\Heroicon; // Import Heroicon untuk icon
use Filament\Tables\Table; // Import Table class
use Illuminate\Database\Eloquent\Builder; // Import Builder untuk query
use Illuminate\Database\Eloquent\SoftDeletingScope; // Import SoftDeletingScope
use Illuminate\Support\Facades\Auth; // Import Auth facade untuk autentikasi
use Illuminate\Database\Eloquent\Model; // Import Model class

class SubscriptionResource extends Resource // Kelas resource untuk Subscription
{
    protected static ?string $model = Subscription::class; // Set model yang digunakan

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Banknotes; // Set icon navigasi menjadi Banknotes

    public static function getEloquentQuery(): Builder // Method untuk mendapatkan query builder
    {
        $user = Auth::user(); // Ambil user yang sedang login

        if ($user->role === 'admin') { // Jika user adalah admin
            return parent::getEloquentQuery(); // Kembalikan semua query tanpa filter
        }

        return parent::getEloquentQuery()->where('user_id', $user->id); // Jika bukan admin, filter berdasarkan user_id
    }

    public static function canEdit(Model $record): bool // Method untuk menentukan apakah user bisa edit record
    {
        if (Auth::user()->role === 'admin') { // Jika user adalah admin
            return true; // Admin selalu bisa edit
        }

        return $record->user_id === Auth::user()->id; // Store hanya bisa edit subscription miliknya sendiri
    }

    public static function form(Schema $schema): Schema // Method untuk mendapatkan form schema
    {
        return SubscriptionForm::configure($schema); // Kembalikan form yang sudah dikonfigurasi
    }

    public static function table(Table $table): Table // Method untuk mendapatkan table configuration
    {
        return SubscriptionsTable::configure($table); // Kembalikan table yang sudah dikonfigurasi
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
            'index' => ListSubscriptions::route('/'), // Route untuk list page
            'create' => CreateSubscription::route('/create'), // Route untuk create page
            'edit' => EditSubscription::route('/{record}/edit'), // Route untuk edit page
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder // Method untuk query route binding
    {
        return parent::getRecordRouteBindingEloquentQuery() // Ambil query dari parent
            ->withoutGlobalScopes([ // Tanpa global scopes
                SoftDeletingScope::class, // Termasuk soft deleted records
            ]);
    }
}

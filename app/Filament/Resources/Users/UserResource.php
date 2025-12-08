<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\Users; // Namespace untuk resource user

use App\Filament\Resources\Users\Pages\CreateUser; // Import CreateUser page
use App\Filament\Resources\Users\Pages\EditUser; // Import EditUser page
use App\Filament\Resources\Users\Pages\ListUsers; // Import ListUsers page
use App\Filament\Resources\Users\Schemas\UserForm; // Import UserForm schema
use App\Filament\Resources\Users\Tables\UsersTable; // Import UsersTable
use App\Models\User; // Import model User
use BackedEnum; // Import BackedEnum type
use Filament\Resources\Resource; // Import Resource base class
use Filament\Schemas\Schema; // Import Schema class
use Filament\Support\Icons\Heroicon; // Import Heroicon untuk icon
use Filament\Tables\Table; // Import Table class
use Illuminate\Support\Facades\Auth; // Import Auth facade untuk autentikasi

class UserResource extends Resource // Kelas resource untuk User
{
    protected static ?string $model = User::class; // Set model yang digunakan

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users; // Set icon navigasi menjadi Users

    public static function canViewAny(): bool // Method untuk menentukan apakah user bisa melihat resource
    {
        return Auth::user()->role === 'admin'; // Hanya admin yang bisa melihat resource ini
    }

    public static function form(Schema $schema): Schema // Method untuk mendapatkan form schema
    {
        return UserForm::configure($schema); // Kembalikan form yang sudah dikonfigurasi
    }

    public static function table(Table $table): Table // Method untuk mendapatkan table configuration
    {
        return UsersTable::configure($table); // Kembalikan table yang sudah dikonfigurasi
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
            'index' => ListUsers::route('/'), // Route untuk list page
            'create' => CreateUser::route('/create'), // Route untuk create page
            'edit' => EditUser::route('/{record}/edit'), // Route untuk edit page
        ];
    }
}

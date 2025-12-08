<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\ProductCategories; // Namespace untuk resource kategori produk

use App\Filament\Resources\ProductCategories\Pages\CreateProductCategory; // Import CreateProductCategory page
use App\Filament\Resources\ProductCategories\Pages\EditProductCategory; // Import EditProductCategory page
use App\Filament\Resources\ProductCategories\Pages\ListProductCategories; // Import ListProductCategories page
use App\Filament\Resources\ProductCategories\Schemas\ProductCategoryForm; // Import ProductCategoryForm schema
use App\Filament\Resources\ProductCategories\Tables\ProductCategoriesTable; // Import ProductCategoriesTable
use App\Models\ProductCategory; // Import model ProductCategory
use BackedEnum; // Import BackedEnum type
use Filament\Resources\Resource; // Import Resource base class
use Filament\Schemas\Schema; // Import Schema class
use Filament\Support\Icons\Heroicon; // Import Heroicon untuk icon
use Filament\Tables\Table; // Import Table class
use Illuminate\Database\Eloquent\Builder; // Import Builder untuk query
use Illuminate\Database\Eloquent\SoftDeletingScope; // Import SoftDeletingScope
use Illuminate\Support\Facades\Auth; // Import Auth facade untuk autentikasi
use UnitEnum; // Import UnitEnum type

class ProductCategoryResource extends Resource // Kelas resource untuk ProductCategory
{
    protected static ?string $model = ProductCategory::class; // Set model yang digunakan

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Tag; // Set icon navigasi menjadi Tag

    protected static string | UnitEnum | null $navigationGroup = 'Manajemen Menu'; // Set group navigasi menjadi 'Manajemen Menu'

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
        return ProductCategoryForm::configure($schema); // Kembalikan form yang sudah dikonfigurasi
    }

    public static function table(Table $table): Table // Method untuk mendapatkan table configuration
    {
        return ProductCategoriesTable::configure($table); // Kembalikan table yang sudah dikonfigurasi
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
            'index' => ListProductCategories::route('/'), // Route untuk list page
            'create' => CreateProductCategory::route('/create'), // Route untuk create page
            'edit' => EditProductCategory::route('/{record}/edit'), // Route untuk edit page
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

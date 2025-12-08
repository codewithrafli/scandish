<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\Products; // Namespace untuk resource produk

use App\Filament\Resources\Products\Pages\CreateProduct; // Import CreateProduct page
use App\Filament\Resources\Products\Pages\EditProduct; // Import EditProduct page
use App\Filament\Resources\Products\Pages\ListProducts; // Import ListProducts page
use App\Filament\Resources\Products\Schemas\ProductForm; // Import ProductForm schema
use App\Filament\Resources\Products\Tables\ProductsTable; // Import ProductsTable
use App\Models\Product; // Import model Product
use App\Models\Subscription; // Import model Subscription
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

class ProductResource extends Resource // Kelas resource untuk Product
{
    protected static ?string $model = Product::class; // Set model yang digunakan

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ShoppingBag; // Set icon navigasi menjadi ShoppingBag

    protected static string | UnitEnum | null $navigationGroup = 'Manajemen Menu'; // Set group navigasi menjadi 'Manajemen Menu'

    protected static ?int $navigationSort = 2; // Set urutan navigasi menjadi 2 (setelah Product Category)

    public static function getEloquentQuery(): Builder // Method untuk mendapatkan query builder
    {
        $user = Auth::user(); // Ambil user yang sedang login

        if (!$user) { // Jika user tidak ditemukan
            return parent::getEloquentQuery()->whereRaw('1 = 0'); // Return query kosong (tidak ada data)
        }

        if ($user->role === 'admin') { // Jika user adalah admin
            return parent::getEloquentQuery(); // Kembalikan semua query tanpa filter
        }

        return parent::getEloquentQuery()->where('user_id', $user->id); // Jika bukan admin, filter berdasarkan user_id
    }

    public static function canCreate(): bool // Method untuk menentukan apakah user bisa create
    {
        $user = Auth::user(); // Ambil user yang sedang login

        if (!$user) { // Jika user tidak ditemukan
            return false; // Tidak bisa create
        }

        if ($user->role === 'admin') { // Jika user adalah admin
            return true; // Admin selalu bisa create
        }

        $subcription = Subscription::where('user_id', $user->id) // Cari subscription user
            ->where('end_date', '>', now()) // Yang masih aktif (end_date > sekarang)
            ->where('is_active', true) // Dan is_active = true
            ->latest() // Ambil yang terbaru
            ->first(); // Ambil pertama

        $countProduct = Product::where('user_id', $user->id)->count(); // Hitung jumlah produk user

        // Bisa create jika: (jumlah produk < 1) ATAU (ada subscription aktif)
        return !($countProduct >= 1 && !$subcription); // Return true jika bisa create, false jika tidak
    }

    public static function form(Schema $schema): Schema // Method untuk mendapatkan form schema
    {
        return ProductForm::configure($schema); // Kembalikan form yang sudah dikonfigurasi
    }

    public static function table(Table $table): Table // Method untuk mendapatkan table configuration
    {
        return ProductsTable::configure($table); // Kembalikan table yang sudah dikonfigurasi
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
            'index' => ListProducts::route('/'), // Route untuk list page
            'create' => CreateProduct::route('/create'), // Route untuk create page
            'edit' => EditProduct::route('/{record}/edit'), // Route untuk edit page
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder // Method untuk query route binding
    {
        return parent::getRecordRouteBindingEloquentQuery() // Ambil query dari parent
            ->withoutGlobalScopes([ // Tanpa global scopes
                SoftDeletingScope::class, // Termasuk soft deleted records
            ]);
    }

    public static function getGlobalSearchResultDetails(Model $record): array // Method untuk menampilkan detail di global search results
    {
        /** @var Product $record */ // Type hint untuk IDE
        return [ // Mengembalikan array detail
            'Kategori' => $record->productCategory->name ?? 'N/A', // Tampilkan kategori
            'Harga' => 'Rp ' . number_format($record->price), // Tampilkan harga
        ];
    }
}

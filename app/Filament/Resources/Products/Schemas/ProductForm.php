<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\Products\Schemas; // Namespace untuk schema form produk

use App\Models\ProductCategory; // Import model ProductCategory
use Filament\Forms\Components\FileUpload; // Import FileUpload component
use Filament\Forms\Components\Repeater; // Import Repeater component
use Filament\Forms\Components\Select; // Import Select component
use Filament\Forms\Components\Textarea; // Import Textarea component
use Filament\Forms\Components\TextInput; // Import TextInput component
use Filament\Forms\Components\Toggle; // Import Toggle component
use Filament\Schemas\Schema; // Import Schema class
use Illuminate\Support\Facades\Auth; // Import Auth facade untuk autentikasi

class ProductForm // Kelas untuk konfigurasi form produk
{
    public static function configure(Schema $schema): Schema // Method static untuk mengkonfigurasi form
    {
        return $schema // Mengembalikan schema yang sudah dikonfigurasi
            ->components([ // Mendefinisikan komponen-komponen form
                Select::make('user_id') // Membuat select untuk user_id
                    ->label('Toko') // Set label menjadi 'Toko'
                    ->relationship('user', 'name') // Set relasi ke user dengan field name
                    ->required() // Field wajib diisi
                    ->reactive() // Field reactive (akan trigger update pada field lain)
                    ->hidden(fn() => Auth::user()->role === 'store'), // Sembunyikan jika user adalah store
                Select::make('product_category_id') // Membuat select untuk product_category_id (untuk admin)
                    ->label('Kategori Produk') // Set label menjadi 'Kategori Produk'
                    ->required() // Field wajib diisi
                    ->relationship('productCategory', 'name') // Set relasi ke productCategory dengan field name
                    ->disabled(fn(callable $get) => $get('user_id') == null) // Disable jika user_id null
                    ->options(function (callable $get) { // Set opsi dengan fungsi callback
                        $userId = $get('user_id'); // Ambil user_id dari form

                        if (!$userId) { // Jika user_id tidak ada
                            return []; // Kembalikan array kosong
                        }

                        return ProductCategory::where('user_id', $userId) // Cari kategori berdasarkan user_id
                            ->pluck('name', 'id'); // Ambil name dan id sebagai array
                    })
                    ->hidden(fn() => Auth::user()->role === 'store'), // Sembunyikan jika user adalah store
                Select::make('product_category_id') // Membuat select untuk product_category_id (untuk store)
                    ->label('Kategori Produk') // Set label menjadi 'Kategori Produk'
                    ->required() // Field wajib diisi
                    ->relationship('productCategory', 'name') // Set relasi ke productCategory dengan field name
                    ->options(function (callable $get) { // Set opsi dengan fungsi callback
                        return ProductCategory::where('user_id', Auth::user()->id) // Cari kategori milik user yang login
                            ->pluck('name', 'id'); // Ambil name dan id sebagai array
                    })
                    ->hidden(fn() => Auth::user()->role === 'admin'), // Sembunyikan jika user adalah admin
                FileUpload::make('image') // Membuat file upload untuk image
                    ->label('Foto Menu') // Set label menjadi 'Foto Menu'
                    ->disk('public') // Set disk penyimpanan menjadi 'public'
                    ->image() // Hanya terima file gambar
                    ->required(), // Field wajib diisi
                TextInput::make('name') // Membuat text input untuk name
                    ->label('Nama Menu') // Set label menjadi 'Nama Menu'
                    ->required(), // Field wajib diisi
                Textarea::make('description') // Membuat textarea untuk description
                    ->label('Deskripsi Menu') // Set label menjadi 'Deskripsi Menu'
                    ->required(), // Field wajib diisi
                TextInput::make('price') // Membuat text input untuk price
                    ->label('Harga Menu') // Set label menjadi 'Harga Menu'
                    ->numeric() // Hanya terima angka
                    ->required(), // Field wajib diisi
                TextInput::make('rating') // Membuat text input untuk rating
                    ->label('Rating Menu') // Set label menjadi 'Rating Menu'
                    ->numeric() // Hanya terima angka
                    ->required(), // Field wajib diisi
                Toggle::make('is_popular') // Membuat toggle untuk is_popular
                    ->label('Populer Menu') // Set label menjadi 'Populer Menu'
                    ->required(), // Field wajib diisi
                Repeater::make('productIngredients') // Membuat repeater untuk productIngredients
                    ->label('Bahan Baku Menu') // Set label menjadi 'Bahan Baku Menu'
                    ->relationship('productIngredients') // Set relasi ke productIngredients
                    ->schema([ // Schema untuk setiap item repeater
                        TextInput::make('name') // Membuat text input untuk name
                            ->label('Nama Bahan') // Set label menjadi 'Nama Bahan'
                            ->required(), // Field wajib diisi
                    ])->columnSpanFull() // Repeater mengambil full width
            ]);
    }
}

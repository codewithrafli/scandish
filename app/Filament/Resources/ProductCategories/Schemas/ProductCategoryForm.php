<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\ProductCategories\Schemas; // Namespace untuk schema form kategori produk

use Filament\Forms\Components\FileUpload; // Import FileUpload component
use Filament\Forms\Components\Select; // Import Select component
use Filament\Forms\Components\TextInput; // Import TextInput component
use Filament\Schemas\Schema; // Import Schema class
use Illuminate\Support\Facades\Auth; // Import Auth facade untuk autentikasi

class ProductCategoryForm // Kelas untuk konfigurasi form kategori produk
{
    public static function configure(Schema $schema): Schema // Method static untuk mengkonfigurasi form
    {
        return $schema // Mengembalikan schema yang sudah dikonfigurasi
            ->components([ // Mendefinisikan komponen-komponen form
                Select::make('user_id') // Membuat select untuk user_id
                    ->label('Toko') // Set label menjadi 'Toko'
                    ->relationship('user', 'name') // Set relasi ke user dengan field name
                    ->required() // Field wajib diisi
                    ->hidden(fn() => Auth::user()->role === 'store'), // Sembunyikan jika user adalah store
                TextInput::make('name') // Membuat text input untuk name
                    ->label('Nama Kategori') // Set label menjadi 'Nama Kategori'
                    ->required(), // Field wajib diisi
                FileUpload::make('icon') // Membuat file upload untuk icon
                    ->label('Ikon Kategori') // Set label menjadi 'Ikon Kategori'
                    ->disk('public') // Set disk penyimpanan menjadi 'public'
                    ->image() // Hanya terima file gambar dan tampilkan preview
                    ->visibility('public') // Set visibility menjadi public agar bisa diakses
                    ->required(), // Field wajib diisi
            ]);
    }
}

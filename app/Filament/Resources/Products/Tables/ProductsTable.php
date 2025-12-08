<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\Products\Tables; // Namespace untuk kelas ProductsTable

use App\Models\ProductCategory; // Import model ProductCategory untuk digunakan di kelas ini
use Filament\Actions\BulkActionGroup; // Import BulkActionGroup untuk mengelompokkan aksi bulk
use Filament\Actions\DeleteAction; // Import DeleteAction untuk aksi hapus per record
use Filament\Actions\DeleteBulkAction; // Import DeleteBulkAction untuk aksi hapus bulk
use Filament\Actions\EditAction; // Import EditAction untuk aksi edit per record
use Filament\Actions\ForceDeleteBulkAction; // Import ForceDeleteBulkAction untuk aksi force delete bulk
use Filament\Actions\RestoreBulkAction; // Import RestoreBulkAction untuk aksi restore bulk
use Filament\Actions\ViewAction; // Import ViewAction untuk aksi lihat per record
use Filament\Tables\Columns\ImageColumn; // Import ImageColumn untuk menampilkan kolom gambar
use Filament\Tables\Columns\TextColumn; // Import TextColumn untuk menampilkan kolom teks
use Filament\Tables\Columns\ToggleColumn; // Import ToggleColumn untuk menampilkan kolom toggle
use Filament\Tables\Filters\SelectFilter; // Import SelectFilter untuk filter dropdown
use Filament\Tables\Filters\TrashedFilter; // Import TrashedFilter untuk filter soft deleted
use Filament\Tables\Table; // Import Table class dari Filament
use Illuminate\Support\Facades\Auth; // Import Auth facade untuk autentikasi

class ProductsTable // Kelas untuk konfigurasi tabel produk
{
    public static function configure(Table $table): Table // Method static untuk mengkonfigurasi tabel produk
    {
        return $table // Mengembalikan instance tabel yang sudah dikonfigurasi
            ->columns([ // Mendefinisikan kolom-kolom yang akan ditampilkan di tabel
                TextColumn::make('user.name') // Membuat kolom teks untuk nama user/toko
                    ->label('Nama Toko') // Set label kolom menjadi 'Nama Toko'
                    ->hidden(fn() => Auth::user()->role === 'store'), // Sembunyikan kolom jika user adalah store
                TextColumn::make('name') // Membuat kolom teks untuk nama produk
                    ->label('Nama Menu'), // Set label kolom menjadi 'Nama Menu'
                TextColumn::make('productCategory.name') // Membuat kolom teks untuk nama kategori produk
                    ->label('Kategori Menu'), // Set label kolom menjadi 'Kategori Menu'
                ImageColumn::make('image') // Membuat kolom gambar untuk foto produk
                    ->label('Foto Menu') // Set label kolom menjadi 'Foto Menu'
                    ->disk('public'), // Set disk penyimpanan menjadi 'public'
                TextColumn::make('price') // Membuat kolom teks untuk harga produk
                    ->label('Harga Menu') // Set label kolom menjadi 'Harga Menu'
                    ->formatStateUsing(function (string $state) { // Format nilai state dengan fungsi callback
                        return 'Rp ' . number_format($state); // Mengembalikan format harga dengan prefix 'Rp' dan number_format
                    }),
                TextColumn::make('rating') // Membuat kolom teks untuk rating produk
                    ->label('Rating Menu'), // Set label kolom menjadi 'Rating Menu'
                ToggleColumn::make('is_popular') // Membuat kolom toggle untuk status populer
                    ->label('Populer Menu'), // Set label kolom menjadi 'Populer Menu'
            ])
            ->filters([ // Mendefinisikan filter-filter yang tersedia di tabel
                SelectFilter::make('user') // Membuat filter dropdown untuk user
                    ->relationship('user', 'name') // Set relasi ke model user dengan field name
                    ->label('Toko') // Set label filter menjadi 'Toko'
                    ->hidden(fn() => Auth::user()->role === 'store'), // Sembunyikan filter jika user adalah store
                SelectFilter::make('product_category_id') // Membuat filter dropdown untuk kategori produk
                    ->options(function () { // Set opsi filter dengan fungsi callback
                        if (Auth::user()->role === 'admin') { // Jika user adalah admin
                            return ProductCategory::pluck('name', 'id'); // Kembalikan semua kategori produk
                        }

                        return ProductCategory::where('user_id', Auth::user()->id) // Jika bukan admin, filter berdasarkan user_id
                            ->pluck('name', 'id'); // Kembalikan kategori produk milik user tersebut
                    })
                    ->label('Kategori Menu'), // Set label filter menjadi 'Kategori Menu'
            ])
            ->recordActions([ // Mendefinisikan aksi-aksi yang tersedia per record
                ViewAction::make(), // Membuat aksi untuk melihat detail record
                EditAction::make(), // Membuat aksi untuk mengedit record
                DeleteAction::make(), // Membuat aksi untuk menghapus record
            ])
            ->toolbarActions([ // Mendefinisikan aksi-aksi yang tersedia di toolbar
                BulkActionGroup::make([ // Membuat grup aksi bulk
                    DeleteBulkAction::make(), // Membuat aksi hapus bulk
                    ForceDeleteBulkAction::make(), // Membuat aksi force delete bulk
                    RestoreBulkAction::make(), // Membuat aksi restore bulk
                ]),
            ]);
    }
}

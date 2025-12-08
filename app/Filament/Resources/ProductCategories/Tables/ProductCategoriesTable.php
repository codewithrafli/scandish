<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\ProductCategories\Tables; // Namespace untuk kelas ProductCategoriesTable

use Filament\Actions\BulkActionGroup; // Import BulkActionGroup untuk mengelompokkan aksi bulk
use Filament\Actions\DeleteAction; // Import DeleteAction untuk aksi hapus per record
use Filament\Actions\DeleteBulkAction; // Import DeleteBulkAction untuk aksi hapus bulk
use Filament\Actions\EditAction; // Import EditAction untuk aksi edit per record
use Filament\Actions\ForceDeleteBulkAction; // Import ForceDeleteBulkAction untuk aksi force delete bulk
use Filament\Actions\RestoreBulkAction; // Import RestoreBulkAction untuk aksi restore bulk
use Filament\Actions\ViewAction; // Import ViewAction untuk aksi lihat per record
use Filament\Tables\Columns\ImageColumn; // Import ImageColumn untuk menampilkan kolom gambar
use Filament\Tables\Columns\TextColumn; // Import TextColumn untuk menampilkan kolom teks
use Filament\Tables\Filters\SelectFilter; // Import SelectFilter untuk filter dropdown
use Filament\Tables\Filters\TrashedFilter; // Import TrashedFilter untuk filter soft deleted
use Filament\Tables\Table; // Import Table class dari Filament
use Illuminate\Support\Facades\Auth; // Import Auth facade untuk autentikasi

class ProductCategoriesTable // Kelas untuk konfigurasi tabel kategori produk
{
    public static function configure(Table $table): Table // Method static untuk mengkonfigurasi tabel kategori produk
    {
        return $table // Mengembalikan instance tabel yang sudah dikonfigurasi
            ->columns([ // Mendefinisikan kolom-kolom yang akan ditampilkan di tabel
                TextColumn::make('user.name') // Membuat kolom teks untuk nama user/toko
                    ->label('Nama Toko') // Set label kolom menjadi 'Nama Toko'
                    ->hidden(fn() => Auth::user()->role === 'store'), // Sembunyikan kolom jika user adalah store
                TextColumn::make('name') // Membuat kolom teks untuk nama kategori
                    ->label('Nama Kategori'), // Set label kolom menjadi 'Nama Kategori'
                ImageColumn::make('icon') // Membuat kolom gambar untuk ikon kategori
                    ->label('Ikon Kategori') // Set label kolom menjadi 'Ikon Kategori'
                    ->disk('public') // Set disk penyimpanan menjadi 'public'
                    ->url(fn($record) => $record->icon ? asset('storage/' . $record->icon) : null), // Generate URL untuk gambar menggunakan asset helper
            ])
            ->filters([ // Mendefinisikan filter-filter yang tersedia di tabel
                TrashedFilter::make(), // Membuat filter untuk menampilkan data yang dihapus (soft delete)
                SelectFilter::make('user') // Membuat filter dropdown untuk user
                    ->relationship('user', 'name') // Set relasi ke model user dengan field name
                    ->label('Toko') // Set label filter menjadi 'Toko'
                    ->hidden(fn() => Auth::user()->role === 'store'), // Sembunyikan filter jika user adalah store
            ])
            ->recordActions([ // Mendefinisikan aksi-aksi yang tersedia per record
                ViewAction::make(), // Membuat aksi untuk melihat detail record
                EditAction::make(), // Membuat aksi untuk mengedit record
                DeleteAction::make() // Membuat aksi untuk menghapus record
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

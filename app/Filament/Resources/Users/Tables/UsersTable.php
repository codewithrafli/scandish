<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\Users\Tables; // Namespace untuk kelas UsersTable

use Filament\Actions\BulkActionGroup; // Import BulkActionGroup untuk mengelompokkan aksi bulk
use Filament\Actions\DeleteAction; // Import DeleteAction untuk aksi hapus per record
use Filament\Actions\DeleteBulkAction; // Import DeleteBulkAction untuk aksi hapus bulk
use Filament\Actions\EditAction; // Import EditAction untuk aksi edit per record
use Filament\Actions\ViewAction; // Import ViewAction untuk aksi lihat per record
use Filament\Tables\Columns\ImageColumn; // Import ImageColumn untuk menampilkan kolom gambar
use Filament\Tables\Columns\TextColumn; // Import TextColumn untuk menampilkan kolom teks
use Filament\Tables\Table; // Import Table class dari Filament

class UsersTable // Kelas untuk konfigurasi tabel user
{
    public static function configure(Table $table): Table // Method static untuk mengkonfigurasi tabel user
    {
        return $table // Mengembalikan instance tabel yang sudah dikonfigurasi
            ->columns([ // Mendefinisikan kolom-kolom yang akan ditampilkan di tabel
                ImageColumn::make('logo') // Membuat kolom gambar untuk logo toko
                    ->label('Logo Toko'), // Set label kolom menjadi 'Logo Toko'
                TextColumn::make('name') // Membuat kolom teks untuk nama toko
                    ->label('Nama Toko'), // Set label kolom menjadi 'Nama Toko'
                TextColumn::make('username') // Membuat kolom teks untuk username
                    ->label('Username'), // Set label kolom menjadi 'Username'
                TextColumn::make('email') // Membuat kolom teks untuk email
                    ->label('Email'), // Set label kolom menjadi 'Email'
                TextColumn::make('role') // Membuat kolom teks untuk peran/role
                    ->label('Peran'), // Set label kolom menjadi 'Peran'
                TextColumn::make('created_at') // Membuat kolom teks untuk tanggal dibuat
                    ->dateTime() // Format kolom sebagai dateTime
                    ->label('Tanggal Mendaftar'), // Set label kolom menjadi 'Tanggal Mendaftar'
            ])
            ->filters([ // Mendefinisikan filter-filter yang tersedia di tabel
                // Tidak ada filter yang didefinisikan
            ])
            ->recordActions([ // Mendefinisikan aksi-aksi yang tersedia per record
                ViewAction::make(), // Membuat aksi untuk melihat detail record
                EditAction::make(), // Membuat aksi untuk mengedit record
                DeleteAction::make(), // Membuat aksi untuk menghapus record
            ])
            ->toolbarActions([ // Mendefinisikan aksi-aksi yang tersedia di toolbar
                BulkActionGroup::make([ // Membuat grup aksi bulk
                    DeleteBulkAction::make(), // Membuat aksi hapus bulk
                ]),
            ]);
    }
}

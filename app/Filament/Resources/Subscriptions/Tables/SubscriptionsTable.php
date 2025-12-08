<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\Subscriptions\Tables; // Namespace untuk kelas SubscriptionsTable

use Filament\Actions\BulkActionGroup; // Import BulkActionGroup untuk mengelompokkan aksi bulk
use Filament\Actions\DeleteAction; // Import DeleteAction untuk aksi hapus per record
use Filament\Actions\DeleteBulkAction; // Import DeleteBulkAction untuk aksi hapus bulk
use Filament\Actions\EditAction; // Import EditAction untuk aksi edit per record
use Filament\Actions\ForceDeleteBulkAction; // Import ForceDeleteBulkAction untuk aksi force delete bulk
use Filament\Actions\RestoreBulkAction; // Import RestoreBulkAction untuk aksi restore bulk
use Filament\Tables\Columns\ImageColumn; // Import ImageColumn untuk menampilkan kolom gambar
use Filament\Tables\Columns\TextColumn; // Import TextColumn untuk menampilkan kolom teks
use Filament\Tables\Filters\TrashedFilter; // Import TrashedFilter untuk filter soft deleted
use Filament\Tables\Table; // Import Table class dari Filament
use Illuminate\Support\Facades\Auth; // Import Auth facade untuk autentikasi

class SubscriptionsTable // Kelas untuk konfigurasi tabel subscription
{
    public static function configure(Table $table): Table // Method static untuk mengkonfigurasi tabel subscription
    {
        return $table // Mengembalikan instance tabel yang sudah dikonfigurasi
            ->columns([ // Mendefinisikan kolom-kolom yang akan ditampilkan di tabel
                TextColumn::make('user.name') // Membuat kolom teks untuk nama user/toko
                    ->label('Nama Toko') // Set label kolom menjadi 'Nama Toko'
                    ->hidden(fn() => Auth::user()->role === 'store'), // Sembunyikan kolom jika user adalah store
                TextColumn::make('created_at') // Membuat kolom teks untuk tanggal dibuat
                    ->dateTime() // Format kolom sebagai dateTime
                    ->label('Tanggal Mulai'), // Set label kolom menjadi 'Tanggal Mulai'
                TextColumn::make('end_date') // Membuat kolom teks untuk tanggal berakhir
                    ->dateTime() // Format kolom sebagai dateTime
                    ->label('Tanggal Berakhir'), // Set label kolom menjadi 'Tanggal Berakhir'
                ImageColumn::make('subscriptionPayment.proof') // Membuat kolom gambar untuk bukti pembayaran
                    ->label('Bukti Pembayaran'), // Set label kolom menjadi 'Bukti Pembayaran'
                TextColumn::make('subscriptionPayment.status') // Membuat kolom teks untuk status pembayaran
                    ->label('Status Pembayaran'), // Set label kolom menjadi 'Status Pembayaran'
            ])
            ->filters([ // Mendefinisikan filter-filter yang tersedia di tabel
                TrashedFilter::make(), // Membuat filter untuk menampilkan data yang dihapus (soft delete)
            ])
            ->recordActions([ // Mendefinisikan aksi-aksi yang tersedia per record
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

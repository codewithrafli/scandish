<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\Transactions\Tables; // Namespace untuk kelas TransactionsTable

use Filament\Actions\BulkActionGroup; // Import BulkActionGroup untuk mengelompokkan aksi bulk
use Filament\Actions\DeleteAction; // Import DeleteAction untuk aksi hapus per record
use Filament\Actions\DeleteBulkAction; // Import DeleteBulkAction untuk aksi hapus bulk
use Filament\Actions\EditAction; // Import EditAction untuk aksi edit per record
use Filament\Actions\ForceDeleteBulkAction; // Import ForceDeleteBulkAction untuk aksi force delete bulk
use Filament\Actions\RestoreBulkAction; // Import RestoreBulkAction untuk aksi restore bulk
use Filament\Actions\ViewAction; // Import ViewAction untuk aksi lihat per record
use Filament\Tables\Columns\TextColumn; // Import TextColumn untuk menampilkan kolom teks
use Filament\Tables\Filters\SelectFilter; // Import SelectFilter untuk filter dropdown
use Filament\Tables\Filters\TrashedFilter; // Import TrashedFilter untuk filter soft deleted
use Filament\Tables\Table; // Import Table class dari Filament
use Illuminate\Support\Facades\Auth; // Import Auth facade untuk autentikasi

class TransactionsTable // Kelas untuk konfigurasi tabel transaksi
{
    public static function configure(Table $table): Table // Method static untuk mengkonfigurasi tabel transaksi
    {
        return $table // Mengembalikan instance tabel yang sudah dikonfigurasi
            ->columns([ // Mendefinisikan kolom-kolom yang akan ditampilkan di tabel
                TextColumn::make('user.name') // Membuat kolom teks untuk nama user/toko
                    ->label('Nama Toko') // Set label kolom menjadi 'Nama Toko'
                    ->hidden(fn() => Auth::user()->role === 'store'), // Sembunyikan kolom jika user adalah store
                TextColumn::make('code') // Membuat kolom teks untuk kode transaksi
                    ->label('Kode Transaksi'), // Set label kolom menjadi 'Kode Transaksi'
                TextColumn::make('name') // Membuat kolom teks untuk nama customer
                    ->label('Nama Customer'), // Set label kolom menjadi 'Nama Customer'
                TextColumn::make('phone_number') // Membuat kolom teks untuk nomor HP customer
                    ->label('Nomor HP Customer'), // Set label kolom menjadi 'Nomor HP Customer'
                TextColumn::make('table_number') // Membuat kolom teks untuk nomor meja
                    ->label('Nomor Meja'), // Set label kolom menjadi 'Nomor Meja'
                TextColumn::make('payment_method') // Membuat kolom teks untuk metode pembayaran
                    ->label('Metode Pembayaran'), // Set label kolom menjadi 'Metode Pembayaran'
                TextColumn::make('total_price') // Membuat kolom teks untuk total harga
                    ->label('Total Pembayaran') // Set label kolom menjadi 'Total Pembayaran'
                    ->formatStateUsing(function (string $state) { // Format nilai state dengan fungsi callback
                        return 'Rp ' . number_format($state); // Mengembalikan format harga dengan prefix 'Rp' dan number_format
                    }),
                TextColumn::make('status') // Membuat kolom teks untuk status pembayaran
                    ->label('Status Pembayaran'), // Set label kolom menjadi 'Status Pembayaran'
                TextColumn::make('created_at') // Membuat kolom teks untuk tanggal dibuat
                    ->label('Tanggal Transaksi') // Set label kolom menjadi 'Tanggal Transaksi'
                    ->dateTime(), // Format kolom sebagai dateTime
            ])
            ->filters([ // Mendefinisikan filter-filter yang tersedia di tabel
                SelectFilter::make('user') // Membuat filter dropdown untuk user
                    ->relationship('user', 'name') // Set relasi ke model user dengan field name
                    ->label('Toko') // Set label filter menjadi 'Toko'
                    ->hidden(fn() => Auth::user()->role === 'store'), // Sembunyikan filter jika user adalah store
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

<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\Users\Schemas; // Namespace untuk schema form user

use Filament\Forms\Components\FileUpload; // Import FileUpload component
use Filament\Forms\Components\Select; // Import Select component
use Filament\Forms\Components\TextInput; // Import TextInput component
use Filament\Schemas\Schema; // Import Schema class

class UserForm // Kelas untuk konfigurasi form user
{
    public static function configure(Schema $schema): Schema // Method static untuk mengkonfigurasi form
    {
        return $schema // Mengembalikan schema yang sudah dikonfigurasi
            ->components([ // Mendefinisikan komponen-komponen form
                FileUpload::make('logo') // Membuat file upload untuk logo
                    ->label('Logo Toko') // Set label menjadi 'Logo Toko'
                    ->image() // Hanya terima file gambar
                    ->required(), // Field wajib diisi
                TextInput::make('name') // Membuat text input untuk name
                    ->label('Nama Toko') // Set label menjadi 'Nama Toko'
                    ->required(), // Field wajib diisi
                TextInput::make('username') // Membuat text input untuk username
                    ->label('username') // Set label menjadi 'username'
                    ->hint('Minimal 5 karakter, tidak boleh ada spasi') // Set hint/placeholder
                    ->minLength(5) // Minimum panjang 5 karakter
                    ->required() // Field wajib diisi
                    ->unique(ignoreRecord: true), // Harus unique, ignore record saat edit
                TextInput::make('email') // Membuat text input untuk email
                    ->label('Email') // Set label menjadi 'Email'
                    ->email() // Validasi format email
                    ->required() // Field wajib diisi
                    ->unique(ignoreRecord: true), // Harus unique, ignore record saat edit
                TextInput::make('password') // Membuat text input untuk password
                    ->label('Password') // Set label menjadi 'Password'
                    ->password() // Tipe input password (disembunyikan)
                    ->required(), // Field wajib diisi
                Select::make('role') // Membuat select untuk role
                    ->label('Peran') // Set label menjadi 'Peran'
                    ->options([ // Set opsi role
                        'admin' => 'Admin', // Opsi admin
                        'store' => 'Toko' // Opsi store
                    ])
                    ->required(), // Field wajib diisi
            ]);
    }
}

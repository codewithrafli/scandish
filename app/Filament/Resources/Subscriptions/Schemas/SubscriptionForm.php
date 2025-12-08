<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\Subscriptions\Schemas; // Namespace untuk schema form subscription

use App\Models\User; // Import model User
use Filament\Forms\Components\FileUpload; // Import FileUpload component
use Filament\Forms\Components\Repeater; // Import Repeater component
use Filament\Forms\Components\Select; // Import Select component
use Filament\Forms\Components\Toggle; // Import Toggle component
use Filament\Schemas\Schema; // Import Schema class
use Illuminate\Support\Facades\Auth; // Import Auth facade untuk autentikasi

class SubscriptionForm // Kelas untuk konfigurasi form subscription
{
    public static function configure(Schema $schema): Schema // Method static untuk mengkonfigurasi form
    {
        return $schema // Mengembalikan schema yang sudah dikonfigurasi
            ->components([ // Mendefinisikan komponen-komponen form
                Select::make('user_id') // Membuat select untuk user_id
                    ->label('Toko') // Set label menjadi 'Toko'
                    ->options(User::all()->pluck('name', 'id')->toArray()) // Set opsi dari semua user
                    ->required() // Field wajib diisi
                    ->hidden(fn() => Auth::user()->role === 'store'), // Sembunyikan jika user adalah store
                Toggle::make('is_active') // Membuat toggle untuk is_active
                    ->required() // Field wajib diisi
                    ->hidden(fn() => Auth::user()->role === 'store'), // Sembunyikan jika user adalah store
                Repeater::make('subscriptionPayment') // Membuat repeater untuk subscriptionPayment
                    ->relationship() // Set relasi ke subscriptionPayment
                    ->schema([ // Schema untuk setiap item repeater
                        FileUpload::make('proof') // Membuat file upload untuk proof
                            ->label('Bukti Transfer Ke Rekening 21321312312 (BCA) A/N Rafli Sebesar Rp. 50.000') // Set label dengan instruksi transfer
                            ->required() // Field wajib diisi
                            ->columnSpanFull(), // File upload mengambil full width
                        Select::make('status') // Membuat select untuk status
                            ->options([ // Set opsi status
                                'pending' => 'Pending', // Opsi pending
                                'success' => 'Success', // Opsi success
                                'failed' => 'Failed', // Opsi failed
                            ])
                            ->required() // Field wajib diisi
                            ->label('Status Pembayaran') // Set label menjadi 'Status Pembayaran'
                            ->columnSpanFull() // Select mengambil full width
                            ->hidden(fn() => Auth::user()->role === 'store'), // Sembunyikan jika user adalah store
                    ])
                    ->columnSpanFull() // Repeater mengambil full width
                    ->addable(false) // Tidak bisa menambah item baru
            ]);
    }
}

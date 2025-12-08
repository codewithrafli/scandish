<?php // Tag pembuka PHP untuk file ini

namespace App\Filament\Resources\Transactions\Schemas; // Namespace untuk schema form transaksi

use App\Models\Product; // Import model Product
use Filament\Forms\Components\Repeater; // Import Repeater component
use Filament\Forms\Components\Select; // Import Select component
use Filament\Forms\Components\TextInput; // Import TextInput component
use Filament\Schemas\Components\Utilities\Get; // Import Get utility untuk mendapatkan nilai form
use Filament\Schemas\Components\Utilities\Set; // Import Set utility untuk set nilai form
use Filament\Schemas\Schema; // Import Schema class
use Illuminate\Support\Facades\Auth; // Import Auth facade untuk autentikasi

class TransactionForm // Kelas untuk konfigurasi form transaksi
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
                TextInput::make('code') // Membuat text input untuk code
                    ->label('Kode Transaksi') // Set label menjadi 'Kode Transaksi'
                    ->default(fn(): string => 'TRX-' . mt_rand(10000, 99999)) // Set default value dengan random code
                    ->readOnly() // Field hanya bisa dibaca, tidak bisa diedit
                    ->required(), // Field wajib diisi
                TextInput::make('name') // Membuat text input untuk name
                    ->label('Nama Customer') // Set label menjadi 'Nama Customer'
                    ->required(), // Field wajib diisi
                TextInput::make('phone_number') // Membuat text input untuk phone_number
                    ->label('Nomer HP Customer') // Set label menjadi 'Nomer HP Customer'
                    ->required(), // Field wajib diisi
                TextInput::make('table_number') // Membuat text input untuk table_number
                    ->label('Nomer Meja') // Set label menjadi 'Nomer Meja'
                    ->required(), // Field wajib diisi
                Select::make('payment_method') // Membuat select untuk payment_method
                    ->label('Metode Pembayaran') // Set label menjadi 'Metode Pembayaran'
                    ->options([ // Set opsi metode pembayaran
                        'cash' => 'Tunai', // Opsi cash
                        'midtrans' => 'Midtrans' // Opsi midtrans
                    ])
                    ->required(), // Field wajib diisi
                Select::make('status') // Membuat select untuk status
                    ->label('Status Pembayaran') // Set label menjadi 'Status Pembayaran'
                    ->options([ // Set opsi status
                        'pending' => 'Tertunda', // Opsi pending
                        'success' => 'Berhasil', // Opsi success
                        'failed' => 'Gagal' // Opsi failed
                    ])
                    ->required(), // Field wajib diisi
                Repeater::make('transactionDetails') // Membuat repeater untuk transactionDetails
                    ->relationship() // Set relasi ke transactionDetails
                    ->schema([ // Schema untuk setiap item repeater
                        Select::make('product_id') // Membuat select untuk product_id
                            ->relationship('product', 'name') // Set relasi ke product dengan field name
                            ->options(function (callable $get) { // Set opsi dengan fungsi callback
                                if (Auth::user()->role === 'admin') { // Jika user adalah admin
                                    return Product::all()->mapWithKeys(function ($product) { // Ambil semua produk
                                        return [$product->id => "$product->name (Rp " . number_format($product->price) . ")"]; // Format: nama (harga)
                                    });
                                }
                                return Product::where('user_id', Auth::user()->id)->get()->mapWithKeys(function ($product) { // Ambil produk milik user
                                    return [$product->id => "$product->name (Rp " . number_format($product->price) . ")"]; // Format: nama (harga)
                                });
                            })
                            ->required(), // Field wajib diisi
                        TextInput::make('quantity') // Membuat text input untuk quantity
                            ->required() // Field wajib diisi
                            ->numeric() // Hanya terima angka
                            ->minValue(1) // Minimum value 1
                            ->default(1), // Default value 1
                        TextInput::make('note'), // Membuat text input untuk note
                    ])->columnSpanFull() // Repeater mengambil full width
                    ->live() // Field live (update real-time)
                    ->afterStateUpdated(function (Get $get, Set $set) { // Callback setelah state diupdate
                        self::updateTotals($get, $set); // Panggil method updateTotals
                    })
                    ->reorderable(false), // Tidak bisa di-reorder
                TextInput::make('total_price') // Membuat text input untuk total_price
                    ->required() // Field wajib diisi
                    ->readOnly(), // Field hanya bisa dibaca, tidak bisa diedit
            ]);
    }

    public static function updateTotals(Get $get, Set $set): void // Method untuk update total harga
    {
        $selectedProducts = collect($get('transactionDetails'))->filter(fn($item) => !empty($item['product_id']) && !empty($item['quantity'])); // Filter produk yang sudah dipilih dan ada quantity

        $prices = Product::find($selectedProducts->pluck('product_id'))->pluck('price', 'id'); // Ambil harga produk berdasarkan ID

        $total = $selectedProducts->reduce(function ($total, $product) use ($prices) { // Hitung total dengan reduce
            return $total + ($prices[$product['product_id']] * $product['quantity']); // Tambahkan harga * quantity ke total
        }, 0); // Start dari 0

        $set('total_price', (string) $total); // Set total_price dengan nilai total yang sudah dihitung
    }
}

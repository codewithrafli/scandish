<?php

namespace App\Filament\Resources\Transactions\Schemas;

use App\Models\Product;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Toko')
                    ->relationship('user', 'name')
                    ->required()
                    ->reactive()
                    ->hidden(fn() => Auth::user()->role === 'store'),
                TextInput::make('code')
                    ->label('Kode Transaksi')
                    ->default(fn(): string => 'TRX-' . mt_rand(10000, 99999))
                    ->readOnly()
                    ->required(),
                TextInput::make('name')
                    ->label('Nama Customer')
                    ->required(),
                TextInput::make('phone_number')
                    ->label('Nomer HP Customer')
                    ->required(),
                TextInput::make('table_number')
                    ->label('Nomer Meja')
                    ->required(),
                Select::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'cash' => 'Tunai',
                        'midtrans' => 'Midtrans'
                    ])
                    ->required(),
                Select::make('status')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending' => 'Tertunda',
                        'success' => 'Berhasil',
                        'failed' => 'Gagal'
                    ])
                    ->required(),
                Repeater::make('transactionDetails')
                    ->relationship()
                    ->schema([
                        Select::make('product_id')
                            ->relationship('product', 'name')
                            ->options(function (callable $get) {
                                if (Auth::user()->role === 'admin') {
                                    return Product::all()->mapWithKeys(function ($product) {
                                        return [$product->id => "$product->name (Rp " . number_format($product->price) . ")"];
                                    });
                                }
                                return Product::where('user_id', Auth::user()->id)->get()->mapWithKeys(function ($product) {
                                    return [$product->id => "$product->name (Rp " . number_format($product->price) . ")"];
                                });
                            })
                            ->required(),
                        TextInput::make('quantity')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->default(1),
                        TextInput::make('note'),
                    ])->columnSpanFull()
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        self::updateTotals($get, $set);
                    })
                    ->reorderable(false),
                TextInput::make('total_price')
                    ->required()
                    ->readOnly(),
            ]);
    }

    public static function updateTotals(Get $get, Set $set): void
    {
        $selectedProducts = collect($get('transactionDetails'))->filter(fn($item) => !empty($item['product_id']) && !empty($item['quantity']));

        $prices = Product::find($selectedProducts->pluck('product_id'))->pluck('price', 'id');

        $total = $selectedProducts->reduce(function ($total, $product) use ($prices) {
            return $total + ($prices[$product['product_id']] * $product['quantity']);
        }, 0);

        $set('total_price', (string) $total);
    }
}

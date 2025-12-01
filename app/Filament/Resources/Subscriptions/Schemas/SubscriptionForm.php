<?php

namespace App\Filament\Resources\Subscriptions\Schemas;

use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class SubscriptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Toko')
                    ->options(User::all()->pluck('name', 'id')->toArray())
                    ->required()
                    ->hidden(fn() => Auth::user()->role === 'store'),
                Toggle::make('is_active')
                    ->required()
                    ->hidden(fn() => Auth::user()->role === 'store'),
                Repeater::make('subscriptionPayment')
                    ->relationship()
                    ->schema([
                        FileUpload::make('proof')
                            ->label('Bukti Transfer Ke Rekening 21321312312 (BCA) A/N Rafli Sebesar Rp. 50.000')
                            ->required()
                            ->columnSpanFull(),
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'success' => 'Success',
                                'failed' => 'Failed',
                            ])
                            ->required()
                            ->label('Status Pembayaran')
                            ->columnSpanFull()
                            ->hidden(fn() => Auth::user()->role === 'store'),
                    ])
                    ->columnSpanFull()
                    ->addable(false)
            ]);
    }
}

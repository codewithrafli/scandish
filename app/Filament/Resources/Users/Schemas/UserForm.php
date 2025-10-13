<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('logo')
                    ->label('Logo Toko')
                    ->image()
                    ->required(),
                TextInput::make('name')
                    ->label('Nama Toko')
                    ->required(),
                TextInput::make('username')
                    ->label('username')
                    ->hint('Minimal 5 karakter, tidak boleh ada spasi')
                    ->minLength(5)
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required(),
                Select::make('role')
                    ->label('Peran')
                    ->options([
                        'admin' => 'Admin',
                        'store' => 'Toko'
                    ])
                    ->required(),
            ]);
    }
}

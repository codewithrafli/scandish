<?php

namespace App\Filament\Resources\ProductCategories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class ProductCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Toko')
                    ->relationship('user', 'name')
                    ->required()
                    ->hidden(fn() => Auth::user()->role === 'store'),
                TextInput::make('name')
                    ->label('Nama Kategori')
                    ->required(),
                FileUpload::make('icon')
                    ->label('Ikon Kategori')
<<<<<<< HEAD
=======
                    ->disk('public')
>>>>>>> 4db5b90489ccb9bfcfbb2296fd5b8e4010f67f7e
                    ->required(),
            ]);
    }
}

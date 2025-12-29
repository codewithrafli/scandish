<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class StoreQrCodeWidget extends Widget
{
    protected static string $view = 'filament.widgets.store-qr-code-widget';

    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        return Auth::check() && Auth::user()->role === 'store';
    }
}

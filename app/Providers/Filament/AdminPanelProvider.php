<?php // Tag pembuka PHP untuk file ini

namespace App\Providers\Filament; // Namespace untuk Filament providers

use App\Filament\Pages\Auth\Register; // Import Register page untuk registration
use Filament\Http\Middleware\Authenticate; // Import Authenticate middleware
use Filament\Http\Middleware\AuthenticateSession; // Import AuthenticateSession middleware
use Filament\Http\Middleware\DisableBladeIconComponents; // Import DisableBladeIconComponents middleware
use Filament\Http\Middleware\DispatchServingFilamentEvent; // Import DispatchServingFilamentEvent middleware
use Filament\Pages\Dashboard; // Import Dashboard page
use Filament\Panel; // Import Panel class
use Filament\PanelProvider; // Import PanelProvider base class
use Filament\Support\Colors\Color; // Import Color untuk warna theme
use Filament\Widgets\AccountWidget; // Import AccountWidget
use Filament\Widgets\FilamentInfoWidget; // Import FilamentInfoWidget
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse; // Import AddQueuedCookiesToResponse middleware
use Illuminate\Cookie\Middleware\EncryptCookies; // Import EncryptCookies middleware
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken; // Import VerifyCsrfToken middleware
use Illuminate\Routing\Middleware\SubstituteBindings; // Import SubstituteBindings middleware
use Illuminate\Session\Middleware\StartSession; // Import StartSession middleware
use Illuminate\View\Middleware\ShareErrorsFromSession; // Import ShareErrorsFromSession middleware

class AdminPanelProvider extends PanelProvider // Kelas provider untuk admin panel Filament
{
    public function panel(Panel $panel): Panel // Method untuk mengkonfigurasi panel
    {
        return $panel // Mengembalikan panel yang sudah dikonfigurasi
            ->default() // Set sebagai panel default
            ->id('admin') // Set ID panel menjadi 'admin'
            ->path('admin') // Set path URL menjadi '/admin'
            ->login() // Enable login page
            ->registration(Register::class) // Set custom registration page
            ->colors([ // Set warna theme
                'primary' => Color::Amber, // Set warna primary menjadi Amber
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources') // Auto-discover resources di folder Filament/Resources
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages') // Auto-discover pages di folder Filament/Pages
            ->pages([ // Set pages manual
                Dashboard::class, // Tambahkan Dashboard page
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets') // Auto-discover widgets di folder Filament/Widgets
            ->widgets([ // Set widgets manual
                AccountWidget::class, // Tambahkan AccountWidget
                FilamentInfoWidget::class, // Tambahkan FilamentInfoWidget
            ])
            ->middleware([ // Set middleware yang akan digunakan
                EncryptCookies::class, // Encrypt cookies
                AddQueuedCookiesToResponse::class, // Add queued cookies ke response
                StartSession::class, // Start session
                AuthenticateSession::class, // Authenticate session
                ShareErrorsFromSession::class, // Share errors dari session
                VerifyCsrfToken::class, // Verify CSRF token
                SubstituteBindings::class, // Substitute route bindings
                DisableBladeIconComponents::class, // Disable blade icon components
                DispatchServingFilamentEvent::class, // Dispatch serving Filament event
            ])
            ->authMiddleware([ // Set authentication middleware
                Authenticate::class, // Authenticate middleware
            ]);
    }
}

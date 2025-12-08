<?php // Tag pembuka PHP untuk file ini

namespace App\Providers; // Namespace untuk service providers

use Illuminate\Support\ServiceProvider; // Import ServiceProvider base class

class AppServiceProvider extends ServiceProvider // Kelas service provider utama aplikasi
{
    /**
     * Register any application services.
     */
    public function register(): void // Method untuk register service ke container
    {
        // Tidak ada service yang di-register
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void // Method untuk bootstrap service setelah semua service ter-register
    {
        // Tidak ada service yang di-bootstrap
    }
}

<?php // Tag pembuka PHP untuk file ini

use Illuminate\Foundation\Inspiring; // Import Inspiring class
use Illuminate\Support\Facades\Artisan; // Import Artisan facade

Artisan::command('inspire', function () { // Mendefinisikan command 'inspire'
    $this->comment(Inspiring::quote()); // Menampilkan quote yang inspiring
})->purpose('Display an inspiring quote'); // Set purpose/deskripsi command

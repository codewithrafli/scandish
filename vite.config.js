import { defineConfig } from 'vite'; // Import defineConfig dari vite
import laravel from 'laravel-vite-plugin'; // Import laravel vite plugin
import tailwindcss from '@tailwindcss/vite'; // Import tailwindcss vite plugin

export default defineConfig({ // Export konfigurasi vite
    plugins: [ // Array plugin yang digunakan
        laravel({ // Plugin Laravel Vite
            input: ['resources/css/app.css', 'resources/js/app.js'], // File input yang akan di-compile
            refresh: true, // Enable hot refresh untuk development
        }),
        tailwindcss(), // Plugin Tailwind CSS
    ],
});

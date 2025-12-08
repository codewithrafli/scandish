import axios from 'axios'; // Import library axios untuk HTTP requests
window.axios = axios; // Set axios ke window object agar bisa diakses global

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'; // Set default header untuk semua axios request agar Laravel mengenali sebagai AJAX request

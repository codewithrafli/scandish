<?php // Tag pembuka PHP untuk file ini

use App\Http\Controllers\FrontendController; // Import FrontendController
use App\Http\Controllers\ProductController; // Import ProductController
use App\Http\Controllers\TransactionController; // Import TransactionController
use Illuminate\Support\Facades\Route; // Import Route facade

Route::get('/', [FrontendController::class, 'scanQR'])->name('scan-qr'); // Route untuk halaman scan QR
Route::get('/{username}', [FrontendController::class, 'index'])->name('index'); // Route untuk halaman index/home dengan parameter username

Route::get('/{username}/find-product', [ProductController::class, 'find'])->name('product.find'); // Route untuk halaman pencarian produk
Route::get('/{username}/find-product/results', [ProductController::class, 'findResults'])->name('product.find-results'); // Route untuk hasil pencarian produk
Route::get('/{username}/product/{id}', [ProductController::class, 'show'])->name('product.show'); // Route untuk detail produk dengan parameter id

Route::get('/{username}/cart', [TransactionController::class, 'cart'])->name('cart'); // Route untuk halaman cart
Route::get('/{username}/customer-information', [TransactionController::class, 'customerInformation'])->name('customer-information'); // Route untuk halaman informasi customer
Route::post('/{username}/checkout', [TransactionController::class, 'checkout'])->name('payment'); // Route untuk proses checkout (POST)
Route::get('/transaction/success', [TransactionController::class, 'success'])->name('success'); // Route untuk halaman success setelah transaksi

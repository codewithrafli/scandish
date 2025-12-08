<?php // Tag pembuka PHP untuk file ini

namespace App\Http\Controllers; // Namespace untuk controller-controller aplikasi

use App\Models\Product; // Import model Product
use App\Models\User; // Import model User
use Illuminate\Http\Request; // Import Request class untuk handle HTTP request

class FrontendController extends Controller // Kelas controller untuk frontend
{
    public function scanQR() // Method untuk menampilkan halaman scan QR
    {
        return view('pages.scan-qr'); // Mengembalikan view scan-qr
    }

    public function index(Request $request) // Method untuk menampilkan halaman index/home
    {
        $store = User::where('username', $request->username)->first(); // Mencari user berdasarkan username

        if (!$store) { // Jika store tidak ditemukan
            abort(404); // Tampilkan error 404
        }

        $populars = Product::where('user_id', $store->id)->where('is_popular', true)->get(); // Ambil produk populer milik store
        $products = Product::where('user_id', $store->id)->where('is_popular', false)->get(); // Ambil produk biasa milik store

        return view('pages.index', compact('store', 'populars', 'products')); // Mengembalikan view index dengan data store, populars, dan products
    }
}

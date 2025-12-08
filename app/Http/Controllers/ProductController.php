<?php // Tag pembuka PHP untuk file ini

namespace App\Http\Controllers; // Namespace untuk controller-controller aplikasi

use App\Models\Product; // Import model Product
use App\Models\ProductCategory; // Import model ProductCategory
use App\Models\User; // Import model User
use Illuminate\Http\Request; // Import Request class untuk handle HTTP request

class ProductController extends Controller // Kelas controller untuk product
{
    public function find(Request $request) // Method untuk menampilkan halaman pencarian produk
    {
        $store = User::where('username', $request->username)->first(); // Mencari user berdasarkan username

        if (!$store) { // Jika store tidak ditemukan
            abort(404); // Tampilkan error 404
        }

        return view('pages.find', compact('store')); // Mengembalikan view find dengan data store
    }

    public function findResults(Request $request) // Method untuk menampilkan hasil pencarian produk
    {
        $store = User::where('username', $request->username)->first(); // Mencari user berdasarkan username

        if (!$store) { // Jika store tidak ditemukan
            abort(404); // Tampilkan error 404
        }

        $products = Product::where('user_id', $store->id); // Query awal untuk produk milik store

        if (isset($request->category)) { // Jika parameter category ada
            $category = ProductCategory::where('user_id', $store->id) // Cari kategori berdasarkan user_id
                ->where('slug', $request->category) // Dan slug
                ->first(); // Ambil pertama

            $products = $products->where('product_category_id', $category->id); // Filter produk berdasarkan kategori
        }

        if (isset($request->search)) { // Jika parameter search ada
            $products = $products->where('name', 'like', '%' . $request->search . '%'); // Filter produk berdasarkan nama (like search)
        }

        $products = $products->get(); // Eksekusi query dan ambil hasil

        return view('pages.result', compact('store', 'products')); // Mengembalikan view result dengan data store dan products
    }

    public function show(Request $request) // Method untuk menampilkan detail produk
    {
        $store = User::where('username', $request->username)->first(); // Mencari user berdasarkan username

        if (!$store) { // Jika store tidak ditemukan
            abort(404); // Tampilkan error 404
        }

        $product = Product::where('id', $request->id)->first(); // Mencari produk berdasarkan ID

        if (!$product) { // Jika produk tidak ditemukan
            abort(404); // Tampilkan error 404
        }

        return view('pages.product', compact('store', 'product')); // Mengembalikan view product dengan data store dan product
    }
}

<?php // Tag pembuka PHP untuk file ini

namespace App\Http\Controllers; // Namespace untuk controller-controller aplikasi

use App\Models\Product; // Import model Product
use App\Models\Transaction; // Import model Transaction
use App\Models\User; // Import model User
use Illuminate\Http\Request; // Import Request class untuk handle HTTP request

class TransactionController extends Controller // Kelas controller untuk transaction
{
    public function cart(Request $request) // Method untuk menampilkan halaman cart
    {
        $store = User::where('username', $request->username)->first(); // Mencari user berdasarkan username

        if (!$store) { // Jika store tidak ditemukan
            abort(404); // Tampilkan error 404
        }

        return view('pages.cart', compact('store')); // Mengembalikan view cart dengan data store
    }

    public function customerInformation(Request $request) // Method untuk menampilkan halaman informasi customer
    {
        $store = User::where('username', $request->username)->first(); // Mencari user berdasarkan username

        if (!$store) { // Jika store tidak ditemukan
            abort(404); // Tampilkan error 404
        }

        return view('pages.customer-information', compact('store')); // Mengembalikan view customer-information dengan data store
    }

    public function checkout(Request $request) // Method untuk proses checkout
    {
        $store = User::where('username', $request->username)->first(); // Mencari user berdasarkan username

        if (!$store) { // Jika store tidak ditemukan
            abort(404); // Tampilkan error 404
        }

        $carts = json_decode($request->cart, true); // Decode JSON cart menjadi array

        $totalPrice = 0; // Inisialisasi total harga dengan 0

        foreach ($carts as $cart) { // Loop setiap item di cart
            $product = Product::where('id', $cart['id'])->first(); // Cari produk berdasarkan ID
            $totalPrice += $product->price * $cart['qty']; // Tambahkan harga produk dikali quantity ke total
        }

        $transaction = $store->transactions()->create([ // Buat transaksi baru untuk store
            'code' => 'TRX-' . mt_rand(10000, 99999), // Generate kode transaksi random
            'name' => $request->name, // Nama customer
            'phone_number' => $request->phone_number, // Nomor HP customer
            'table_number' => $request->table_number, // Nomor meja
            'payment_method' => $request->payment_method, // Metode pembayaran
            'total_price' => $totalPrice, // Total harga
            'status' => 'pending' // Status awal pending
        ]);

        foreach ($carts as $cart) { // Loop setiap item di cart
            $product = Product::where('id', $cart['id'])->first(); // Cari produk berdasarkan ID

            $transaction->transactionDetails()->create([ // Buat detail transaksi
                'product_id' => $product->id, // ID produk
                'quantity' => $cart['qty'], // Quantity
                'note' => $cart['notes'], // Catatan
            ]);
        }

        if ($request->payment_method == 'cash') { // Jika metode pembayaran adalah cash
            return redirect()->route('success', ['username' => $store->username, 'order_id' => $transaction->code]); // Redirect ke halaman success
        } else { // Jika metode pembayaran bukan cash (online)
            // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = config('midtrans.serverKey'); // Set server key dari config
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = config('midtrans.isProduction'); // Set environment production/sandbox
            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = config('midtrans.isSanitized'); // Set sanitization
            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = config('midtrans.is3ds'); // Set 3DS untuk credit card

            $params = [ // Parameter untuk Midtrans
                'transaction_details' => [ // Detail transaksi
                    'order_id' => $transaction->code, // Kode transaksi
                    'gross_amount' => $totalPrice, // Total harga
                ],
                'customer_details' => [ // Detail customer
                    'name' => $request->name, // Nama customer
                    'phone' => $request->phone_number, // Nomor HP customer
                ],
            ];

            $paymentUrl = \Midtrans\Snap::createTransaction($params)->redirect_url; // Buat transaksi Midtrans dan ambil redirect URL

            return redirect($paymentUrl); // Redirect ke halaman pembayaran Midtrans
        }
    }

    public function success(Request $request) // Method untuk menampilkan halaman success
    {
        $transaction = Transaction::where('code', $request->order_id)->first(); // Cari transaksi berdasarkan kode
        $store = User::where('id', $transaction->user_id)->first(); // Cari store berdasarkan user_id transaksi

        if (!$store) { // Jika store tidak ditemukan
            abort(404); // Tampilkan error 404
        }

        return view('pages.success', compact('store', 'transaction')); // Mengembalikan view success dengan data store dan transaction
    }
}

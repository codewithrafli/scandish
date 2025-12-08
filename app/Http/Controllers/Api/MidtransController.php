<?php // Tag pembuka PHP untuk file ini

namespace App\Http\Controllers\Api; // Namespace untuk API controllers

use App\Http\Controllers\Controller; // Import base Controller class
use App\Models\Transaction; // Import model Transaction
use Illuminate\Http\Request; // Import Request class untuk handle HTTP request

class MidtransController extends Controller // Kelas controller untuk handle callback Midtrans
{
    public function callback(Request $request) // Method untuk handle callback dari Midtrans
    {
        $serverKey = config('midtrans.serverKey'); // Ambil server key dari config
        $hashedKey = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey); // Generate hash key untuk validasi

        if ($hashedKey !== $request->signature_key) { // Jika hash key tidak sama dengan signature_key
            return response()->json(['message' => 'Invalid signature key'], 403); // Kembalikan error 403
        }

        $transactionStatus = $request->transaction_status; // Ambil status transaksi dari request
        $orderId = $request->order_id; // Ambil order ID dari request
        $transaction = Transaction::where('code', $orderId)->first(); // Cari transaksi berdasarkan kode

        if (!$transaction) { // Jika transaksi tidak ditemukan
            return response()->json(['message' => 'Transaction not found'], 404); // Kembalikan error 404
        }


        switch ($transactionStatus) { // Switch berdasarkan status transaksi
            case 'capture': // Jika status adalah capture
                if ($request->payment_type == 'credit_card') { // Jika tipe pembayaran adalah credit card
                    if ($request->fraud_status == 'challenge') { // Jika fraud status adalah challenge
                        $transaction->update(['status' => 'pending']); // Update status menjadi pending
                    } else { // Jika fraud status bukan challenge
                        $transaction->update(['status' => 'success']); // Update status menjadi success
                    }
                }
                break; // Keluar dari case
            case 'settlement': // Jika status adalah settlement
                $transaction->update(['status' => 'success']); // Update status menjadi success
                break; // Keluar dari case
            case 'pending': // Jika status adalah pending
                $transaction->update(['status' => 'pending']); // Update status menjadi pending
                break; // Keluar dari case
            case 'deny': // Jika status adalah deny
                $transaction->update(['status' => 'failed']); // Update status menjadi failed
                break; // Keluar dari case
            case 'expire': // Jika status adalah expire
                $transaction->update(['status' => 'failed']); // Update status menjadi failed
                break; // Keluar dari case
            case 'cancel': // Jika status adalah cancel
                $transaction->update(['status' => 'failed']); // Update status menjadi failed
                break; // Keluar dari case
            default: // Default case
                $transaction->update(['status' => 'failed']); // Update status menjadi failed
                break; // Keluar dari case
        }

        return response()->json(['message' => 'Callback received successfully']); // Kembalikan response sukses
    }
}

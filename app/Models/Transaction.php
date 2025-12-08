<?php // Tag pembuka PHP untuk file ini

namespace App\Models; // Namespace untuk model-model aplikasi

use Illuminate\Database\Eloquent\Model; // Import Model class dari Eloquent
use Illuminate\Database\Eloquent\SoftDeletes; // Import SoftDeletes trait untuk soft delete
use Illuminate\Support\Facades\Auth; // Import Auth facade untuk autentikasi

class Transaction extends Model // Kelas model untuk Transaction
{
    use SoftDeletes; // Menggunakan trait SoftDeletes untuk soft delete functionality

    protected $fillable = [ // Array field yang dapat diisi secara mass assignment
        'user_id', // ID user/toko pemilik transaksi
        'code', // Kode transaksi
        'name', // Nama customer
        'phone_number', // Nomor HP customer
        'table_number', // Nomor meja
        'payment_method', // Metode pembayaran
        'total_price', // Total harga transaksi
        'status' // Status transaksi
    ];

    public static function boot() // Method boot yang dipanggil saat model di-boot
    {
        parent::boot(); // Memanggil method boot dari parent class

        if (Auth::check()) { // Jika user sedang login
            static::creating(function ($model) { // Event listener saat model sedang dibuat
                if (Auth::user()->role === 'store') { // Jika role user adalah 'store'
                    $model->user_id = Auth::user()->id; // Set user_id dengan ID user yang sedang login
                }
            });

            static::updating(function ($model) { // Event listener saat model sedang diupdate
                if (Auth::user()->role === 'store') { // Jika role user adalah 'store'
                    $model->user_id = Auth::user()->id; // Set user_id dengan ID user yang sedang login
                }
            });
        }
    }

    public function user() // Method untuk relasi belongsTo ke model User
    {
        return $this->belongsTo(User::class); // Mengembalikan relasi belongsTo ke User
    }

    public function transactionDetails() // Method untuk relasi hasMany ke model TransactionDetail
    {
        return $this->hasMany(TransactionDetail::class); // Mengembalikan relasi hasMany ke TransactionDetail
    }
}

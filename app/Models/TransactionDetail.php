<?php // Tag pembuka PHP untuk file ini

namespace App\Models; // Namespace untuk model-model aplikasi

use Illuminate\Database\Eloquent\Model; // Import Model class dari Eloquent
use Illuminate\Database\Eloquent\SoftDeletes; // Import SoftDeletes trait untuk soft delete

class TransactionDetail extends Model // Kelas model untuk TransactionDetail
{
    use SoftDeletes; // Menggunakan trait SoftDeletes untuk soft delete functionality

    protected $fillable = [ // Array field yang dapat diisi secara mass assignment
        'transaction_id', // ID transaksi yang terkait dengan detail ini
        'product_id', // ID produk yang dibeli
        'quantity', // Jumlah produk yang dibeli
        'note' // Catatan khusus untuk produk ini
    ];

    public function transaction() // Method untuk relasi belongsTo ke model Transaction
    {
        return $this->belongsTo(Transaction::class); // Mengembalikan relasi belongsTo ke Transaction
    }

    public function product() // Method untuk relasi belongsTo ke model Product
    {
        return $this->belongsTo(Product::class); // Mengembalikan relasi belongsTo ke Product
    }
}

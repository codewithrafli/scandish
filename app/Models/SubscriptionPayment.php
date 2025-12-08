<?php // Tag pembuka PHP untuk file ini

namespace App\Models; // Namespace untuk model-model aplikasi

use Illuminate\Database\Eloquent\Model; // Import Model class dari Eloquent
use Illuminate\Database\Eloquent\SoftDeletes; // Import SoftDeletes trait untuk soft delete

class SubscriptionPayment extends Model // Kelas model untuk SubscriptionPayment
{
    use SoftDeletes; // Menggunakan trait SoftDeletes untuk soft delete functionality

    protected $fillable = [ // Array field yang dapat diisi secara mass assignment
        'subscription_id', // ID subscription yang terkait dengan pembayaran ini
        'proof', // Path bukti pembayaran
        'status' // Status pembayaran
    ];

    public function subscription() // Method untuk relasi belongsTo ke model Subscription
    {
        return $this->belongsTo(Subscription::class); // Mengembalikan relasi belongsTo ke Subscription
    }
}

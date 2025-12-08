<?php // Tag pembuka PHP untuk file ini

namespace App\Models; // Namespace untuk model-model aplikasi

use Illuminate\Database\Eloquent\Model; // Import Model class dari Eloquent
use Illuminate\Database\Eloquent\SoftDeletes; // Import SoftDeletes trait untuk soft delete
use Illuminate\Support\Facades\Auth; // Import Auth facade untuk autentikasi

class Subscription extends Model // Kelas model untuk Subscription
{
    use SoftDeletes; // Menggunakan trait SoftDeletes untuk soft delete functionality

    protected $fillable = [ // Array field yang dapat diisi secara mass assignment
        'user_id', // ID user/toko pemilik subscription
        'end_date', // Tanggal berakhir subscription
        'is_active' // Status apakah subscription aktif atau tidak
    ];

    public static function boot() // Method boot yang dipanggil saat model di-boot
    {
        parent::boot(); // Memanggil method boot dari parent class

        static::creating(function ($model) { // Event listener saat model sedang dibuat
            $model->user_id = Auth::user()->id; // Set user_id dengan ID user yang sedang login
            $model->end_date = now()->addDays(30); // Set end_date menjadi 30 hari dari sekarang
        });
    }

    public function user() // Method untuk relasi belongsTo ke model User
    {
        return $this->belongsTo(User::class); // Mengembalikan relasi belongsTo ke User
    }

    public function subscriptionPayment() // Method untuk relasi hasOne ke model SubscriptionPayment
    {
        return $this->hasOne(SubscriptionPayment::class); // Mengembalikan relasi hasOne ke SubscriptionPayment
    }
}

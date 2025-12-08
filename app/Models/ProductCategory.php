<?php // Tag pembuka PHP untuk file ini

namespace App\Models; // Namespace untuk model-model aplikasi

use Illuminate\Database\Eloquent\Model; // Import Model class dari Eloquent
use Illuminate\Database\Eloquent\SoftDeletes; // Import SoftDeletes trait untuk soft delete
use Illuminate\Support\Facades\Auth; // Import Auth facade untuk autentikasi
use Illuminate\Support\Str; // Import Str helper untuk string manipulation

class ProductCategory extends Model // Kelas model untuk ProductCategory
{
    use SoftDeletes; // Menggunakan trait SoftDeletes untuk soft delete functionality

    protected $fillable = [ // Array field yang dapat diisi secara mass assignment
        'user_id', // ID user/toko pemilik kategori
        'name', // Nama kategori
        'slug', // Slug kategori (URL-friendly)
        'icon' // Path ikon kategori
    ];

    public static function boot() // Method boot yang dipanggil saat model di-boot
    {
        parent::boot(); // Memanggil method boot dari parent class

        static::creating(function ($model) { // Event listener saat model sedang dibuat
            if (Auth::user()->role === 'store') { // Jika role user adalah 'store'
                $model->user_id = Auth::user()->id; // Set user_id dengan ID user yang sedang login
            }

            $model->slug = Str::slug($model->name); // Generate slug dari nama kategori
        });

        static::updating(function ($model) { // Event listener saat model sedang diupdate
            if (Auth::user()->role === 'store') { // Jika role user adalah 'store'
                $model->user_id = Auth::user()->id; // Set user_id dengan ID user yang sedang login
            }

            $model->slug = Str::slug($model->name); // Generate slug dari nama kategori
        });
    }

    public function user() // Method untuk relasi belongsTo ke model User
    {
        return $this->belongsTo(User::class); // Mengembalikan relasi belongsTo ke User
    }

    public function products() // Method untuk relasi hasMany ke model Product
    {
        return $this->hasMany(Product::class); // Mengembalikan relasi hasMany ke Product
    }
}

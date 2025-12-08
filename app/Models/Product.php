<?php // Tag pembuka PHP untuk file ini

namespace App\Models; // Namespace untuk model-model aplikasi

use Illuminate\Database\Eloquent\Model; // Import Model class dari Eloquent
use Illuminate\Database\Eloquent\SoftDeletes; // Import SoftDeletes trait untuk soft delete
use Illuminate\Support\Facades\Auth; // Import Auth facade untuk autentikasi

class Product extends Model // Kelas model untuk Product
{
    use SoftDeletes; // Menggunakan trait SoftDeletes untuk soft delete functionality

    protected $fillable = [ // Array field yang dapat diisi secara mass assignment
        'user_id', // ID user/toko pemilik produk
        'product_category_id', // ID kategori produk
        'image', // Path gambar produk
        'name', // Nama produk
        'description', // Deskripsi produk
        'price', // Harga produk
        'rating', // Rating produk
        'is_popular' // Status apakah produk populer atau tidak
    ];

    protected $casts = [ // Array untuk casting tipe data
        'price' => 'decimal:2', // Cast price menjadi decimal dengan 2 digit di belakang koma
    ];

    public static function boot() // Method boot yang dipanggil saat model di-boot
    {
        parent::boot(); // Memanggil method boot dari parent class

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

    public function user() // Method untuk relasi belongsTo ke model User
    {
        return $this->belongsTo(User::class); // Mengembalikan relasi belongsTo ke User
    }

    public function productCategory() // Method untuk relasi belongsTo ke model ProductCategory
    {
        return $this->belongsTo(ProductCategory::class); // Mengembalikan relasi belongsTo ke ProductCategory
    }

    public function productIngredients() // Method untuk relasi hasMany ke model ProductIngredient
    {
        return $this->hasMany(ProductIngredient::class); // Mengembalikan relasi hasMany ke ProductIngredient
    }

    public function transactionDetails() // Method untuk relasi hasMany ke model TransactionDetail
    {
        return $this->hasMany(TransactionDetail::class); // Mengembalikan relasi hasMany ke TransactionDetail
    }
}

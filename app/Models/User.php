<?php // Tag pembuka PHP untuk file ini

namespace App\Models; // Namespace untuk model-model aplikasi

// use Illuminate\Contracts\Auth\MustVerifyEmail; // Comment: Import untuk email verification (tidak digunakan)
use Illuminate\Database\Eloquent\Factories\HasFactory; // Import HasFactory trait untuk factory
use Illuminate\Foundation\Auth\User as Authenticatable; // Import Authenticatable class sebagai base class
use Illuminate\Notifications\Notifiable; // Import Notifiable trait untuk notifikasi
use Illuminate\Support\Facades\Auth; // Import Auth facade untuk autentikasi

class User extends Authenticatable // Kelas model User yang extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */ // PHPDoc comment untuk IDE support
    use HasFactory, Notifiable; // Menggunakan trait HasFactory dan Notifiable

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [ // Array field yang dapat diisi secara mass assignment
        'logo', // Path logo toko
        'name', // Nama toko/user
        'username', // Username untuk login
        'email', // Email user
        'password', // Password user (akan di-hash)
        'role' // Role user (admin/store)
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [ // Array field yang disembunyikan saat serialization
        'password', // Sembunyikan password
        'remember_token', // Sembunyikan remember token
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array // Method untuk mendefinisikan casting tipe data
    {
        return [ // Mengembalikan array casting
            'email_verified_at' => 'datetime', // Cast email_verified_at menjadi datetime
            'password' => 'hashed', // Cast password menjadi hashed
        ];
    }
    public static function boot() // Method boot yang dipanggil saat model di-boot
    {
        parent::boot(); // Memanggil method boot dari parent class

        if (!Auth::check()) { // Jika user tidak sedang login
            static::creating(function ($model) { // Event listener saat model sedang dibuat
                $model->role = 'store'; // Set default role menjadi 'store'
            });
        }
    }

    public function productCategories() // Method untuk relasi hasMany ke model ProductCategory
    {
        return $this->hasMany(ProductCategory::class); // Mengembalikan relasi hasMany ke ProductCategory
    }

    public function products() // Method untuk relasi hasMany ke model Product
    {
        return $this->hasMany(Product::class); // Mengembalikan relasi hasMany ke Product
    }

    public function transactions() // Method untuk relasi hasMany ke model Transaction
    {
        return $this->hasMany(Transaction::class); // Mengembalikan relasi hasMany ke Transaction
    }

    public function subscriptions() // Method untuk relasi hasMany ke model Subscription
    {
        return $this->hasMany(Subscription::class); // Mengembalikan relasi hasMany ke Subscription
    }
}

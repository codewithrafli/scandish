<?php // Tag pembuka PHP untuk file ini

namespace App\Models; // Namespace untuk model-model aplikasi

use Illuminate\Database\Eloquent\Model; // Import Model class dari Eloquent
use Illuminate\Database\Eloquent\SoftDeletes; // Import SoftDeletes trait untuk soft delete

class ProductIngredient extends Model // Kelas model untuk ProductIngredient
{
    protected $fillable = [ // Array field yang dapat diisi secara mass assignment
        'product_id', // ID produk yang memiliki ingredient ini
        'name' // Nama ingredient/bahan
    ];

    public function product() // Method untuk relasi belongsTo ke model Product
    {
        return $this->belongsTo(Product::class); // Mengembalikan relasi belongsTo ke Product
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product'; // Jika nama tabel tidak jamak (bukan 'products')

    protected $fillable = [
        'name',
        'slug',
        'description',
        'sku',
        'price',
        'stock',
        'product_category_id',
        'image_url',
        'is_active',
    ];

    // Relasi ke kategori produk
    public function category()
    {
        return $this->belongsTo(Categories::class, 'product_category_id');
    }
}

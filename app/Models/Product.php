<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'material_size',
        'price',
        'image_path',
        'stock',
    ];

    /**
     * Relasi ke tabel Cart (Satu produk bisa ada di banyak keranjang user).
     */
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }
}
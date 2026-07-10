<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    /**
     * Relasi balik ke User (Setiap baris keranjang dimiliki oleh satu user).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Product (Setiap item di keranjang merujuk pada satu produk).
     * Relasi ini yang dipanggil oleh Cart::with('product') di Controller.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
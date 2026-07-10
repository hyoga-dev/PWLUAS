<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_price',
        'shipping_address',
        'status',
        'tracking_number',
    ];

    /**
     * Relasi balik ke User (Setiap pesanan dimiliki oleh satu user).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
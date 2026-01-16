<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'book_id',
        'book_title',
        'book_price',
        'quantity',
        'subtotal',
    ];

    protected $casts = [
        'book_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Relación con el pedido
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relación con el libro
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'stripe_session_id',
        'order_number',
        'status',
        'total',
        'shipping_amount',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'customer_city',
        'customer_postal_code',
        'customer_province',
        'customer_country',
        'notes',
        'shipped',
        'shipped_at',
        'refunded',
        'refunded_at',
        'refund_amount',
        'refund_reason',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'shipped' => 'boolean',
        'shipped_at' => 'datetime',
        'refunded' => 'boolean',
        'refunded_at' => 'datetime',
        'refund_amount' => 'decimal:2',
    ];

    /**
     * Generar número de pedido único
     */
    public static function generateOrderNumber(): string
    {
        do {
            $number = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
        } while (self::where('order_number', $number)->exists());

        return $number;
    }

    /**
     * Relación con el usuario
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con los items del pedido
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Obtener el nombre del cliente (del usuario o del pedido)
     */
    public function getCustomerNameAttribute($value)
    {
        return $value ?? $this->user?->name;
    }

    /**
     * Obtener el email del cliente (del usuario o del pedido)
     */
    public function getCustomerEmailAttribute($value)
    {
        return $value ?? $this->user?->email;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
     * Relación con las reseñas
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Obtener la valoración promedio (solo de reseñas aprobadas)
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->where('approved', true)->avg('rating') ? round($this->reviews()->where('approved', true)->avg('rating'), 1) : 0;
    }

    /**
     * Obtener el total de reseñas (solo aprobadas)
     */
    public function getReviewsCountAttribute()
    {
        return $this->reviews()->where('approved', true)->count();
    }

    protected $fillable = [
        'title',
        'description',
        'long_description',
        'price',
        'cover_image',
        'stripe_price_id',
        'active',
        'order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'active' => 'boolean',
    ];
}

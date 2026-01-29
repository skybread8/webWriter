<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'photo',
        'photo_alt',
        'review',
        'rating',
        'active',
        'order',
    ];

    protected $casts = [
        'active' => 'boolean',
        'rating' => 'integer',
    ];

    /**
     * Obtener la URL de la foto o un placeholder
     */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            // Si es una URL externa (empieza con http), devolverla directamente
            if (str_starts_with($this->photo, 'http://') || str_starts_with($this->photo, 'https://')) {
                return $this->photo;
            }
            // Usar la función helper que funciona con S3 y local
            return get_image_url($this->photo) ?? asset('storage/'.$this->photo);
        }

        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=27272a&color=fff';
    }
}

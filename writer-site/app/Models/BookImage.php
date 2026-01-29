<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookImage extends Model
{
    protected $fillable = [
        'book_id',
        'image_path',
        'alt',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Relación con el libro
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Obtener la URL de la imagen
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->image_path) {
            return get_image_url($this->image_path);
        }
        return null;
    }
}

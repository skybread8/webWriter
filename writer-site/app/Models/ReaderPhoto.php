<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReaderPhoto extends Model
{
    protected $fillable = [
        'book_id',
        'photo',
        'reader_name',
        'caption',
        'active',
        'order',
    ];

    /**
     * Relación con el libro
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    protected $casts = [
        'active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Obtener la URL de la foto
     */
    public function getPhotoUrlAttribute(): ?string
    {
        if ($this->photo) {
            return get_image_url($this->photo);
        }
        return null;
    }
}

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
     * Relación con las fotos de lectores
     */
    public function readerPhotos()
    {
        return $this->hasMany(ReaderPhoto::class);
    }

    /**
     * Relación con las imágenes del libro
     */
    public function images()
    {
        return $this->hasMany(BookImage::class)->orderBy('order')->orderBy('created_at');
    }

    /**
     * Obtener la valoración promedio (solo de reseñas aprobadas)
     * Usa los datos precargados con withAvg si están disponibles
     */
    public function getAverageRatingAttribute()
    {
        // Si ya se cargó con withAvg, Laravel lo almacena en attributes
        // Verificar si existe en attributes (cuando se usa withAvg)
        if (array_key_exists('average_rating', $this->attributes)) {
            $avg = $this->attributes['average_rating'];
            return $avg !== null ? round((float)$avg, 1) : 0;
        }
        
        // Si no, calcularlo
        $avg = $this->reviews()->where('approved', true)->avg('rating');
        return $avg ? round($avg, 1) : 0;
    }

    /**
     * Obtener el total de reseñas (solo aprobadas)
     * Usa los datos precargados con withCount si están disponibles
     */
    public function getReviewsCountAttribute()
    {
        // Si ya se cargó con withCount, Laravel lo almacena en attributes
        // Verificar si existe en attributes (cuando se usa withCount)
        if (array_key_exists('reviews_count', $this->attributes)) {
            return (int)($this->attributes['reviews_count'] ?? 0);
        }
        
        // Si no, calcularlo
        return $this->reviews()->where('approved', true)->count();
    }

    /**
     * Scope para cargar estadísticas de reseñas eficientemente
     */
    public function scopeWithReviewStats($query)
    {
        return $query->withCount([
            'reviews as reviews_count' => function($query) {
                $query->where('approved', true);
            }
        ])->withAvg([
            'reviews as average_rating' => function($query) {
                $query->where('approved', true);
            }
        ], 'rating');
    }

    /**
     * Obtener todas las imágenes del libro (incluyendo cover_image)
     * Retorna una colección con todas las imágenes ordenadas
     */
    public function getAllImages()
    {
        $allImages = collect();
        
        // Primero añadir cover_image si existe (para que aparezca primero)
        if ($this->cover_image) {
            $coverUrl = get_image_url($this->cover_image);
            if ($coverUrl) {
                $allImages->push([
                    'url' => $coverUrl,
                    'alt' => $this->cover_image_alt ?: "Portada del libro {$this->title}",
                    'is_cover' => true,
                ]);
            }
        }
        
        // Luego añadir todas las imágenes de BookImage
        if ($this->relationLoaded('images')) {
            foreach ($this->images as $image) {
                if ($image->image_url) {
                    $allImages->push([
                        'url' => $image->image_url,
                        'alt' => $image->alt ?: "Imagen del libro {$this->title}",
                        'is_cover' => false,
                    ]);
                }
            }
        } else {
            $images = $this->images()->orderBy('order')->orderBy('created_at')->get();
            foreach ($images as $image) {
                if ($image->image_url) {
                    $allImages->push([
                        'url' => $image->image_url,
                        'alt' => $image->alt ?: "Imagen del libro {$this->title}",
                        'is_cover' => false,
                    ]);
                }
            }
        }
        
        return $allImages;
    }

    /**
     * Obtener la primera imagen disponible (para listados)
     */
    public function getFirstImageUrlAttribute()
    {
        $firstImage = $this->images()->orderBy('order')->orderBy('created_at')->first();
        if ($firstImage) {
            return $firstImage->image_url;
        }
        
        // Fallback a cover_image si existe
        if ($this->cover_image) {
            return get_image_url($this->cover_image);
        }
        
        return null;
    }

    protected $fillable = [
        'title',
        'description',
        'long_description',
        'price',
        'cover_image',
        'cover_image_alt',
        'stripe_price_id',
        'active',
        'stock',
        'order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'active' => 'boolean',
        'stock' => 'integer',
    ];

    /**
     * Indica si el libro tiene control de stock (stock no es null)
     */
    public function hasStockControl(): bool
    {
        return $this->stock !== null;
    }

    /**
     * Indica si hay unidades disponibles para comprar
     */
    public function isInStock(): bool
    {
        if ($this->stock === null) {
            return true; // Sin control = siempre disponible
        }
        return $this->stock > 0;
    }

    /**
     * Unidades disponibles (null = ilimitado)
     */
    public function availableStock(): ?int
    {
        return $this->stock;
    }
}

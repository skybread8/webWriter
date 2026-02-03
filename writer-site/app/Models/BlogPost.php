<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'featured_image_alt',
        'published',
        'published_at',
        'order',
    ];

    protected $casts = [
        'published' => 'boolean',
        'published_at' => 'datetime',
        'order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            if (empty($post->slug)) {
                $post->slug = 'post-' . uniqid();
            }
            // Asegurar unicidad: si ya existe ese slug, añadir sufijo
            $base = $post->slug;
            $n = 0;
            while (static::where('slug', $post->slug)->exists()) {
                $n++;
                $post->slug = $base . '-' . $n;
            }
        });

        static::updating(function ($post) {
            if ($post->isDirty('title')) {
                $post->slug = Str::slug($post->title);
                if (empty($post->slug)) {
                    $post->slug = 'post-' . uniqid();
                }
                // Asegurar unicidad (excluir el propio registro)
                $base = $post->slug;
                $n = 0;
                while (static::where('slug', $post->slug)->where('id', '!=', $post->id)->exists()) {
                    $n++;
                    $post->slug = $base . '-' . $n;
                }
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Resolver en rutas: si el valor es numérico (admin usa id), buscar por id; si no, por slug (página pública).
     */
    public function resolveRouteBinding($value, $field = null)
    {
        if (is_numeric($value)) {
            return static::find($value);
        }

        return static::where('slug', $value)->first();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'tagline',
        'hero_text',
        'hero_image',
        'contact_email',
        'instagram_url',
        'facebook_url',
        'tiktok_url',
    ];
}

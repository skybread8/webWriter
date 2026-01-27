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
        'shipping_price',
        'stripe_shipping_price_id',
        'instagram_url',
        'facebook_url',
        'tiktok_url',
        'twitter_url',
        'youtube_url',
        'linkedin_url',
        'pinterest_url',
        'privacy_policy',
        'terms_of_service',
        'legal_notice',
        'cookie_policy',
        'cookies_enabled',
    ];

    protected $casts = [
        'cookies_enabled' => 'boolean',
        'shipping_price' => 'decimal:2',
    ];
}

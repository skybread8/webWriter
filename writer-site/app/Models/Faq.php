<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'question',
        'answer',
        'active',
        'order',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}


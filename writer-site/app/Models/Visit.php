<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'path',
        'referer',
        'method',
        'status_code',
        'visited_at',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
        'status_code' => 'integer',
    ];
}

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'twitter',
        'instagram',
        'twitch',
        'avatar',
        'visible',
        'position',
        'age',
        'victory',
        'team'
    ];

    protected $casts = [
        'age' => 'integer',
        'visible' => 'boolean'
    ];
}

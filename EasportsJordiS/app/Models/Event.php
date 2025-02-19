<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'location',
        'date',
        'hour',
        'type',
        'tags',
        'visible'
    ];

    protected $casts = [
        'date' => 'date',
        'hour' => 'datetime',
        'visible' => 'boolean'
    ];

    public function usersWhoLiked(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user')->withTimestamps();
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'event_user', 'event_id', 'user_id');
    }
}

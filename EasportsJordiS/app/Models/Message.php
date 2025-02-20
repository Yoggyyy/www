<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subject',
        'text',
        'readed'
    ];

    protected $casts = [
        'readed' => 'boolean'
    ];

    // Relación uno a muchos 
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

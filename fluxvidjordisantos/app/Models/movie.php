<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $data = ['title', 'year', 'plot', 'rating', 'visibility', 'director_id'];

    //Relación: una película pertenece a un director.
    public function director()
    {
        return $this->belongsTo(Director::class);
    }
}

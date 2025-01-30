<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    use HasFactory;

    protected $data = ['name', 'birthday', 'nacionality'];

    //Relación: un director tiene muchas películas.
    public function movies()
    {
        return $this->hasMany(Movie::class);
    }
}


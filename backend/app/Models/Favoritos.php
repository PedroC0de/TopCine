<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favoritos extends Model
{
    protected $table = 'favoritos'; 

    protected $fillable = [
        'id_tmdb',
        'titulo',
        'genero',
        'sinopse',
        'avaliacao',
        'data',
        'poster_path',
    ];


}
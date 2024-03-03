<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredientes extends Model
{
    protected $fillable = [
        'ingredientes',
        'peso',
    ];
    public function comida()
    {
        return $this->belongsTo('Comida');

    }
}

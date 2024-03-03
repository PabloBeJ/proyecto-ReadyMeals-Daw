<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngreNutri extends Model
{
    use HasFactory;
    protected $fillable=[
        'ingredientes','peso',
    ];
}

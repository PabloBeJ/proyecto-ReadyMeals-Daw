<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comida extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titulo', 'slug', 'entradilla', 'descripcion', 'fecha', 'autor', 'imagen','url',
        'tiempo','personas','contador',
    ];

    public function ingredientes()
    {
        return $this->belongsToMany(Ingredientes::class,);
    }
}

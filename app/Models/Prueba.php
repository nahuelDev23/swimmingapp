<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prueba extends Model
{
    use HasFactory;

    public function categoria()
    {
        return $this->belongsTo(Categoria::class); # una Prueba pertenece a una categoria
    }

    public function serie()
    {
        return $this->hasMany(Serie::class); # una Prueba pertenece a muchas series
    }

    public function inscripcionPrueba()
    {
        return $this->hasMany(InscripcionPrueba::class); 
    }
}

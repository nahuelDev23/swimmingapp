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

    public function competencia()
    {
        return $this->belongsTo(Competencia::class); # una Prueba pertenece a una competencia
    }

    public function serie()
    {
        return $this->hasMany(Serie::class); # una Prueba pertenece a muchas series
    }

    public function inscripcionPrueba()
    {
        return $this->hasMany(InscripcionPrueba::class); 
    }

    public function competidor()
    {
        return $this->hasMany(Competidor::class); 
    }

    public function getSexoPrueba($prueba_id) : object
    {
        return Prueba::where('id',$prueba_id)->select('sexo')->first();
    }

    public function getCategoryIdOfPrueba($prueba_id) : object
    {
        return self::where('id', $prueba_id)->select('categoria_id')->first();
    }
   
}

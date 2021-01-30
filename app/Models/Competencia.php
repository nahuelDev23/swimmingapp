<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competencia extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function series()
    {
        return $this->hasMany(Serie::class); # una Competencia tiene muchas series
    }
    public function cancheos()
    {
        return $this->hasMany(Cancheo::class); # una Competencia tiene muchas cancheos
    }

    public function resultados()
    {
        return $this->hasMany(Resultado::class); # un Competidor pertenece a muchos cancheos
    }
    public function competidores()
    {
        return $this->hasMany(Competidor::class); # una Competencia tiene muchas competidores
    }

    public function inscripcionPrueba()
    {
        return $this->hasMany(InscripcionPrueba::class); 
    }

    public function pruebas()
    {
        return $this->hasMany(Prueba::class); 
    }
    
}

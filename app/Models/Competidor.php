<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competidor extends Model
{
    use HasFactory;

    // public function categoria()
    // {
    //     return $this->belongsTo(Categoria::class); # un Competidor pertenece a una categoria
    // }

    // public function club()
    // {
    //     return $this->belongsTo(Club::class); # un Competidor pertenece a un club
    // }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class); # un Competidor/tiempo tiene un alumno
    }
    public function competencia()
    {
        return $this->belongsTo(Competencia::class); # un Competidor/tiempo pertenece a una competencia
    }

    public function cancheos()
    {
        return $this->hasMany(Cancheo::class); # un Competidor pertenece a muchos cancheos
    }

    public function inscripcionPrueba()
    {
        return $this->hasMany(InscripcionPrueba::class); 
    }
    public function prueba()
    {
        return $this->belongsTo(Prueba::class); 
    }

    /**
     * este es el nievo
    */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class); # un alumno pertenece a una categoria
    }
}

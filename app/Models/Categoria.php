<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    public function competidores()
    {
        return $this->hasMany(Competidor::class); # una Categoria tiene muchos competidores
    }

    public function alumnos()
    {
        return $this->hasMany(Alumno::class);
    }

    public function pruebas()
    {
        return $this->hasMany(Prueba::class); # una Categoria tiene muchas pruebas
    }
}

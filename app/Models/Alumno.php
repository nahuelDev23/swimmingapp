<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    public function categoria()
    {
        return $this->belongsTo(Categoria::class); # un alumno pertenece a una categoria
    }

    public function competidores()
    {
        return $this->hasMany(Competidor::class); 
    }

    public function competencia()
    {
        return $this->belongsTo(Competencia::class); # un Competidor pertenece a una competencia
    }

    public function club()
    {
        return $this->belongsTo(Club::class); 
    }
}

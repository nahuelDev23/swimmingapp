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

    public function club()
    {
        return $this->belongsTo(Club::class); # un alumno pertenece a un club
    }
}

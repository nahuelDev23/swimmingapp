<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    public function competidores()
    {
        return $this->hasMany(Competidor::class); # un Club tiene muchos competidores
    }

    public function alumnos()
    {
        return $this->hasMany(Alumnos::class);
    }
    
    public function users()
    {
        return $this->hasMany(User::class); # un club tiene muchos usuarios
    }
}

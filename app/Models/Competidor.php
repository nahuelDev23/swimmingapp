<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competidor extends Model
{
    use HasFactory;

    public function categoria()
    {
        return $this->belongsTo(Categoria::class); # un Competidor pertenece a una categoria
    }

    public function club()
    {
        return $this->belongsTo(Club::class); # un Competidor pertenece a un club
    }

    public function cancheos()
    {
        return $this->hasMany(Cancheo::class); # un Competidor pertenece a muchos cancheos
    }
}

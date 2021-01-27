<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    use HasFactory;

    public function prueba()
    {
        return $this->belongsTo(Prueba::class); # una Serie pertenece a una prueba
    }

    public function cancheos()
    {
        return $this->hasMany(Cancheo::class); # una Serie pertenece a muchos cancheos
    }
    public function resultados()
    {
        return $this->hasMany(Resultado::class); # una Serie pertenece a muchos cancheos
    }

    public function competencia()
    {
        return $this->belongsTo(Competencia::class); # una Serie pertenece a una competencia
    }
}

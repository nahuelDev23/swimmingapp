<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    use HasFactory;

    public function competidor()
    {
        return $this->belongsTo(Competidor::class); # un Cancheo pertenece a un competidor
    }

    public function competencia()
    {
        return $this->belongsTo(Competencia::class); # un Cancheo pertenece a una competencia
    }
    public function serie()
    {
        return $this->belongsTo(Serie::class); # un Cancheo pertenece a una serie
    }
}


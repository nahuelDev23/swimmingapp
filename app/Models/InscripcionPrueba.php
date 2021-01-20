<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InscripcionPrueba extends Model
{
    use HasFactory;

    public function competidor()
    {
        return $this->belongsTo(Competidor::class); # un Cancheo pertenece a un competidor
    }
    
    public function competencia()
    {
        return $this->belongsTo(Competencia::class); 
    }

    public function prueba()
    {
        return $this->belongsTo(Prueba::class); 
    }
}

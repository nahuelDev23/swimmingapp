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

    public function whereCompetenciaAndTiempoAndPrueba($request)
    {
        return self::where('competencia_id', $request->competencia_id)
        ->where('competidor_id', $request->competidor_id)
        ->where('prueba_id', $request->prueba_id)
        ->first();
    }
}

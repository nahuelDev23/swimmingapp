<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Competidor extends Model
{
    use HasFactory;

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

    public function resultados()
    {
        return $this->hasMany(Resultado::class); # un Competidor pertenece a muchos cancheos
    }

    public function inscripcionPrueba()
    {
        return $this->hasMany(InscripcionPrueba::class);
    }
    public function prueba()
    {
        return $this->belongsTo(Prueba::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class); # un alumno pertenece a una categoria
    }


    public function ByIfIsAdminOrUserAllAlumnoWithTiempoAndPruebaRegister($competencia_id)
    {
        if(Auth::user()->is_admin == 1){
            return $this->getAllAlumnoWithTiempoAndPruebaRegister($competencia_id);
        }else{
            return $this->getAllAlumnoWithTiempoAndPruebaRegisterBySelfClubOfUser($competencia_id);
        }
    }

    public function getAllAlumnoWithTiempoAndPruebaRegister($competencia_id)
    {
        return self::join('alumnos', 'competidors.alumno_id', '=', 'alumnos.id')
            ->join('pruebas', 'competidors.prueba_id', '=', 'pruebas.id')
            ->where('competidors.competencia_id', $competencia_id)
            ->selectTiempoRegistedIdWithDataAlumnos()
            ->pluck('nombre', 'id');
    }

    public function getAllAlumnoWithTiempoAndPruebaRegisterBySelfClubOfUser($competencia_id)
    {
        return self::join('alumnos', 'competidors.alumno_id', '=', 'alumnos.id')
            ->join('pruebas', 'competidors.prueba_id', '=', 'pruebas.id')
            ->where('alumnos.club_id', Auth::user()->club->id)
            ->where('competidors.competencia_id', $competencia_id)
            ->selectTiempoRegistedIdWithDataAlumnos()
            ->pluck('nombre', 'id');
    }

    public function scopeSelectTiempoRegistedIdWithDataAlumnos(Builder $query):Builder
    {
        return $query->selectRaw(
            'competidors.id,
            CONCAT(alumnos.nombre," ",alumnos.apellido," - ",alumnos.dni," - ",pruebas.nombre_prueba," - ",competidor_tiempo) as nombre');
    }

    public function getAlumnoSexoInTableCompetidors($competido_id): object
    {
        return self::join('alumnos','competidors.alumno_id','=','alumnos.id')
        ->where('competidors.id',$competido_id)
        ->select('alumnos.sexo')
        ->first();
    }
}

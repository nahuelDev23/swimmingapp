<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

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

    public function byIfIsAdminOrUserListAlumnosByPrueba(Collection $pruebas_de_la_competencia,int $competencia_id) :array
    {
        if(Auth::user()->is_admin == 1){
            return $this->getListAlumnosByPrueba($pruebas_de_la_competencia,$competencia_id);
        }else{
            return $this->getListAlumnosByPruebaWhereClubIsSameThatUserAuth($pruebas_de_la_competencia,$competencia_id);
        }
    }

    public function getListAlumnosByPruebaWhereClubIsSameThatUserAuth(Collection $pruebas_de_la_competencia,int  $competencia_id):array
    {
        $lista_alumnos_inscriptos_por_prueba = [];

        foreach($pruebas_de_la_competencia as $p){
            array_push($lista_alumnos_inscriptos_por_prueba, self::where('inscripcion_pruebas.competencia_id',$competencia_id)
            ->where('inscripcion_pruebas.prueba_id',$p->id)
            ->join('competidors','inscripcion_pruebas.competidor_id','=','competidors.id')
            ->join('alumnos','competidors.alumno_id','=','alumnos.id')
            ->where('alumnos.club_id', Auth::user()->club->id)
            ->get());
        }
        return $lista_alumnos_inscriptos_por_prueba;
    }

    public function getListAlumnosByPrueba(Collection $pruebas_de_la_competencia,int  $competencia_id):array
    {
        $lista_alumnos_inscriptos_por_prueba = [];

        foreach($pruebas_de_la_competencia as $prueba){
            array_push($lista_alumnos_inscriptos_por_prueba, self::where('inscripcion_pruebas.competencia_id',$competencia_id)
            ->where('inscripcion_pruebas.prueba_id',$prueba->id)
            ->join('competidors','inscripcion_pruebas.competidor_id','=','competidors.id')
            ->join('alumnos','competidors.alumno_id','=','alumnos.id')
            ->get());
        }
        return $lista_alumnos_inscriptos_por_prueba;
    }

    public function getInscriptosPruebaFitForEachPruebaInCompetenciaOrderByTiempo($prueba,$sexo,$competenciaId)
    {
        return self::join('competidors', 'inscripcion_pruebas.competidor_id', '=', 'competidors.id')
        ->where('inscripcion_pruebas.prueba_id', $prueba->id)
        ->where('competidors.competencia_id', $competenciaId)
        ->join('alumnos','competidors.alumno_id','=','alumnos.id')
        ->where('alumnos.categoria_id', $prueba->categoria_id)
        ->CheckIfSexoOfPruebaIsMixtoOrNot($sexo)
        ->orderBy('competidors.competidor_tiempo', 'asc')
        ->get();

    }

    public function scopeCheckIfSexoOfPruebaIsMixtoOrNot(Builder $query, $sexo): Builder
    {
        if($sexo != '')
        {
            return $query->where('alumnos.sexo', $sexo);
        }

        return $query;

    }
}

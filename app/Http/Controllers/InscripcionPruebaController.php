<?php

namespace App\Http\Controllers;

use App\Models\Competencia;
use App\Models\Competidor;
use App\Models\Prueba;
use App\Repositories\InscripcionPruebaRepository;

use Illuminate\Http\Request;

class InscripcionPruebaController extends Controller
{
    public function create(Competencia $competencia,InscripcionPruebaRepository $inscripcionPruebaRepository)
    {
        $pruebas_select = Prueba::where('competencia_id', $competencia->id)->orderBy('nombre_prueba', 'asc')->pluck('nombre_prueba', 'id');
        $competidor_select = $inscripcionPruebaRepository->fill_competidor_select($competencia->id);
        $tiempo_competidores = Competidor::where('competencia_id', $competencia->id)->orderBy('competidor_tiempo', 'asc')->get();
        $pruebas_de_la_competencia = Prueba::where('competencia_id', $competencia->id)->orderBy('nombre_prueba', 'asc')->get();
        $lista_alumnos_inscriptos_por_prueba = $inscripcionPruebaRepository->list_alumno_for_prueba($pruebas_de_la_competencia,$competencia->id);
        
        return view('inscripciones/create', [
            'pruebas_select' => $pruebas_select,
            'competencia_id' => $competencia->id,
            'competidor_select' => $competidor_select,
            'tiempo_competidores' => $tiempo_competidores,
            'pruebas_de_la_competencia' => $pruebas_de_la_competencia,
            'lista_alumnos_inscriptos_por_prueba'=>$lista_alumnos_inscriptos_por_prueba,
        ]);
    }

    public function store(Request $request,InscripcionPruebaRepository $inscripcionPruebaRepository)
    {
        return $inscripcionPruebaRepository->validate_conditions_init($request);
    }
}

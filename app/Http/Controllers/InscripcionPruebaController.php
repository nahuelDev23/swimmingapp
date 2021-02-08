<?php

namespace App\Http\Controllers;

use App\Models\Competencia;
use App\Repositories\InscripcionPruebaRepository;
use App\Repositories\PruebaRepository;

use Illuminate\Http\Request;

class InscripcionPruebaController extends Controller
{
    public function create(Competencia $competencia,InscripcionPruebaRepository $inscripcionPruebaRepository,PruebaRepository $pruebaRepository)
    {
        $pruebas_de_la_competencia =  $pruebaRepository->getAllPruebasOfCompetenciaOrderByNombrePrueba($competencia->id);
       
        return view('inscripciones/create', [
            'pruebas_select' => $pruebaRepository->getAllPruebasOfCompetenciaOrderByNombrePruebaListForSelectInput($competencia->id),
            'competencia_id' => $competencia->id,
            'competidor_select' => $inscripcionPruebaRepository->fill_competidor_select($competencia->id),
            'pruebas_de_la_competencia' =>  $pruebaRepository->getAllPruebasOfCompetenciaOrderByNombrePrueba($competencia->id),
            'lista_alumnos_inscriptos_por_prueba_table'=>$inscripcionPruebaRepository->list_alumno_for_prueba($pruebas_de_la_competencia,$competencia->id),
        ]);
    }

    public function store(Request $request,InscripcionPruebaRepository $inscripcionPruebaRepository)
    {
        return $inscripcionPruebaRepository->validate_conditions_init($request);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Cancheo;
use App\Models\Competencia;
use App\Models\Competidor;
use App\Models\InscripcionPrueba;
use App\Models\Prueba;
use App\Models\Serie;
use Illuminate\Http\Request;

class SerieController extends Controller
{

    public function create(Competencia $competencia)
    {
        $pruebas = Prueba::pluck('nombre_prueba', 'id');
        return view('series/create', [
            'pruebas' => $pruebas,
            'competencia_id' => $competencia->id,

        ]);
    }
    // public function store(Request $request)
    // {

    //     $serie = new Serie;
    //     $serie->nombre_serie = $request->nombre_serie;
    //     $serie->prueba_id = $request->prueba_id;
    //     $serie->competencia_id = $request->competencia_id;
    //     $serie->save();

    //     return redirect('competencias/' . $request->competencia_id);
    // }

    public function show(Serie $serie)
    {

        $cancheo = Cancheo::where('serie_id', $serie->id)->with('competidor')->orderBy('carril', 'asc')->get();
        /*
        * hacer relacion de muchos a muchos con tiempos y alumnos
        */
        $competidor = Alumno::with('competidores')->get();
        return view('series/show', [
            'serie' => $serie,
            'cancheo' => $cancheo,
            'competidor' => $competidor,
        ]);
    }

}

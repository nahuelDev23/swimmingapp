<?php

namespace App\Http\Controllers;

use App\Models\Competencia;
use App\Models\Prueba;
use Illuminate\Http\Request;

class CompetenciaController extends Controller
{
    public function index()
    {
        $competencias = Competencia::select('id','nombre_competencia','detalle','fecha_competencia')->get();
        return view('dashboard',[
            'competencias' => $competencias,
        ]);
    }

    public function show(Competencia $competencia)
    {
      
        $series = $competencia->series;
        $pruebas = Prueba::all();
        return view('competencias/show',[
            'competencia' => $competencia,
            'series' => $series,
            'pruebas'=>$pruebas,
        ]);
    }
}

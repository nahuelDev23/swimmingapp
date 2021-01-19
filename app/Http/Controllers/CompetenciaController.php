<?php

namespace App\Http\Controllers;

use App\Models\Competencia;
use Illuminate\Http\Request;

class CompetenciaController extends Controller
{
    public function index()
    {
        $competencias = Competencia::select('id','nombre_competencia','detalle','created_at')->get();
        return view('dashboard',[
            'competencias' => $competencias,
        ]);
    }

    public function show(Competencia $competencia)
    {
        $series = $competencia->series;
        return view('competencias/show',[
            'competencia' => $competencia,
            'series' => $series,
        ]);
    }
}

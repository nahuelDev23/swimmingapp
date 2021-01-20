<?php

namespace App\Http\Controllers;

use App\Models\Cancheo;
use App\Models\Competencia;
use App\Models\Competidor;
use App\Models\Serie;
use Illuminate\Http\Request;

class SerieController extends Controller
{

    public function create(Competencia $competencia)
    {
        return view('series/create');
    }
    public function store(Request $request)
    {
        return view('series/create');
    }

    public function show(Serie $serie)
    {
        $cancheo = Cancheo::where('serie_id',$serie->id)->with('competidor')->get();
        return view('series/show',[
            'serie' => $serie,
            'cancheo'=>$cancheo,
        ]);
    }
}


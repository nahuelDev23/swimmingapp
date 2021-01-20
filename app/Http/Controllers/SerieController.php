<?php

namespace App\Http\Controllers;

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
        $pruebas = Prueba::pluck('nombre_prueba','id');
        return view('series/create',[
            'pruebas' => $pruebas,
            'competencia_id'=>$competencia->id,
            
        ]);
    }
    public function store(Request $request)
    {
        $serie = new Serie;
        $serie->nombre_serie=$request->nombre_serie;
        $serie->prueba_id=$request->prueba_id;
        $serie->competencia_id=$request->competencia_id;
        $serie->save();

        return redirect('competencias/'.$request->competencia_id);
    }

    public function show(Serie $serie)
    {
        /**
         * cambiar esto por los de inscripcion prueba
         */
        // $competidoresAptos = Competidor::where('categoria_id',$serie->prueba->id)
        // ->where('competencia_id',$serie->competencia_id)
        // ->where('tiempo_competidor','!=','00:00:00')
        // ->orderBy('tiempo_competidor','asc')
        // ->get();

        $competidoresAptos = InscripcionPrueba::with('prueba','competidor')
        ->whereHas('competidor',function($query) use ($serie){
            return $query
            ->where('prueba_id', $serie->prueba_id)
            ->where('competencia_id',$serie->competencia_id)
            ->where('categoria_id',$serie->prueba->categoria_id);
       })
        ->get();
        
        $cancheo = Cancheo::where('serie_id',$serie->id)->with('competidor')->get();
        return view('series/show',[
            'serie' => $serie,
            'cancheo'=>$cancheo,
            'competidoresAptos'=>$competidoresAptos,
        ]);
    }
}


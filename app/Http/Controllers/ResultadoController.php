<?php

namespace App\Http\Controllers;

use App\Models\Cancheo;
use App\Models\Competencia;
use Illuminate\Http\Request;

class ResultadoController extends Controller
{
    public function show(Competencia $competencia){
       $resultadoPreInfantilesPrueba1 = Cancheo::with('competidor','serie')
       ->where('competencia_id',$competencia->id)
       ->whereHas('competidor',function($query){
            return $query->where('categoria_id', 1);
       })
       ->whereHas('serie',function($query){
            return $query->where('prueba_id', '1');
        })
        ->orderBy('tiempo','asc')
       ->get();

       return view('resultados/show',[
           'resultadoPreInfantilesPrueba1' => $resultadoPreInfantilesPrueba1
       ]);
    }
}

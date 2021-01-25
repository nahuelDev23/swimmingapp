<?php

namespace App\Http\Controllers;

use App\Models\Cancheo;
use App\Models\Categoria;
use App\Models\Competencia;
use App\Models\Prueba;
use Illuminate\Http\Request;

class ResultadoController extends Controller
{
    public function show(Competencia $competencia){
        $pruebas = Prueba::all();
        $categorias = Categoria::all();
        $resultado = [];
        foreach($pruebas as $prueba){
            foreach($categorias as  $categoria){
                array_push($resultado, $this->makeResultados($categoria->id,$prueba->id,$competencia->id));
            }
        }
        return view('resultados/show',[ 'resultado' => $resultado]);

    }

    public function makeResultados($categoria_id,$prueba_id,$competencia){
        $resultado = Cancheo::with('competidor','serie')
        ->where('competencia_id',$competencia)
        ->whereHas('competidor',function($query) use ($categoria_id){
            $query->join('alumnos','competidors.alumno_id','=','alumnos.id');
             return $query->where('alumnos.categoria_id', $categoria_id);
        })
        ->whereHas('serie',function($query) use ($prueba_id) {
             return $query->where('prueba_id', $prueba_id);
         })
         ->orderBy('tiempo','asc')
        ->get();
        
        return $resultado;
        }  
}

    


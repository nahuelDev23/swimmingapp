<?php

namespace App\Http\Controllers;

use App\Models\Cancheo;
use App\Models\Categoria;
use App\Models\Competencia;
use App\Models\Prueba;
use App\Models\Club;
use App\Models\Resultado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ResultadoController extends Controller
{
    public function show(Competencia $competencia){
        $pruebas = Prueba::all();
        $categorias = Categoria::all();
        $sexos = ['M','F'];
        $resultado = [];
        
        foreach($pruebas as $prueba){

            if($prueba->sexo == 'MIXTO'){
                foreach($categorias as  $categoria){
                    foreach($sexos as  $sexo){
                        array_push($resultado, $this->makeResultadosMixto($categoria->id,$prueba->id,$competencia->id,$sexo));
                    }
                }
            } 
            foreach($categorias as  $categoria){
                    array_push($resultado, $this->makeResultados($categoria->id,$prueba->id,$competencia->id));
            }
        }
       
        return view('resultados/show',[
             'resultado' => $resultado,
             ]);
    }


    public function store(Competencia $competencia)
    {
        $this->deleteResultadosPorCompetencia($competencia->id);

        $pruebas = Prueba::all();
        $cancheos = Cancheo::where('competencia_id',$competencia->id)->get();
        
        foreach($cancheos as $cancheo){
            $resultado = new Resultado();
            $resultado->competencia_id = $cancheo->competencia_id;
            $resultado->competidor_id = $cancheo->competidor_id;
            $resultado->serie_id = $cancheo->serie_id;
            $resultado->tiempo = $cancheo->tiempo != null ? $cancheo->tiempo : '23:59:59';
            $resultado->save();
        }

        $puntaje_por_prueba=[];

        foreach($pruebas as $prueba){
            array_push($puntaje_por_prueba,  $this->makePuntajePorPrueba($prueba->id,$competencia->id));  
        }

        $puntos = [10,9,8,7,6,5,4,3,2,1];

        foreach($puntaje_por_prueba as  $puntaje_prueba)
        {
            foreach($puntaje_prueba as $index =>  $prueba){
                $puntaje = Resultado::find($prueba->id);
                $puntaje->puntaje = $puntos[$index];
                $puntaje->update();
            } 
        }

        $cerrar_competencia = Competencia::find($competencia->id);
        if($cerrar_competencia->estado == 1){
            $cerrar_competencia->estado = 0;
        }
        $cerrar_competencia->update();
        return back();
    }

    public function makePuntajePorPrueba($prueba_id,$competencia){
        $resultado = Resultado::with('competidor','serie')
        ->where('competencia_id',$competencia)
        ->whereHas('serie',function($query) use ($prueba_id) {
             return $query->where('prueba_id', $prueba_id);
         })
         ->orderBy('tiempo','asc')
         ->take(10)
        ->get();
        
        return $resultado;
        }  

    public function makeResultadosMixto($categoria_id,$prueba_id,$competencia,$sexo){
        $resultado = Resultado::with('competidor','serie')
        ->where('competencia_id',$competencia)
        ->whereHas('competidor',function($query) use ($categoria_id,$sexo){
            $query->join('alumnos','competidors.alumno_id','=','alumnos.id');
             return $query->where('alumnos.categoria_id', $categoria_id)->where('alumnos.sexo',$sexo);
        })
        ->whereHas('serie',function($query) use ($prueba_id) {
             return $query->where('prueba_id', $prueba_id);
         })
         ->orderBy('tiempo','asc')
        ->get();
        
        return $resultado;
        }  

        public function makeResultados($categoria_id,$prueba_id,$competencia){
            $resultado = Resultado::with('competidor','serie')
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

            public function deleteResultadosPorCompetencia($competencia_id){
                Resultado::where('competencia_id',$competencia_id)->delete();
        }

        public function puntuacionGeneral()
        {
            $rs = [];
            $club = Club::all();
            foreach($club as $c){
                array_push($rs, 
            
                Resultado::join('competidors','resultados.competidor_id','competidors.id')
                ->join('alumnos','competidors.alumno_id','alumnos.id')
                ->join('clubs','alumnos.club_id','clubs.id')
                ->select('clubs.nombre_club', DB::raw('SUM(resultados.puntaje) AS resultados_puntaje'))
                ->where('clubs.id',$c->id)
                ->get()
            );

            
            }

            return view('resultados/general',[
                'puntajes' => $rs,
            ]);
        }
}

    


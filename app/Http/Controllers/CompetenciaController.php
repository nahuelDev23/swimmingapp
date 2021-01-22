<?php

namespace App\Http\Controllers;

use App\Models\Competencia;
use App\Models\Prueba;
use Illuminate\Http\Request;
use App\Models\InscripcionPrueba;
use App\Models\Cancheo;
use App\Models\Serie;

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

    public function generarSeriesCancheos(Competencia $competencia){
        $sexo = '';
        /**
         * pruebas tiene q tener competencia_id
         * por ahora uso todas las pruebas
         */
        $pruebas = Prueba::all();
        foreach($pruebas as $prueba){
        foreach($competencia->series as $serie){
            if($serie->prueba->sexo == 'VARONES'){
                $sexo = 'M';
            }else if($serie->prueba->sexo == 'MUJERES'){
                $sexo = 'F';
            }else{
                $sexo = '';
            };
 
            if($sexo != ''){
                $competidoresAptos2 = InscripcionPrueba::join('competidors','inscripcion_pruebas.competidor_id','=','competidors.id')
                ->where('inscripcion_pruebas.prueba_id',$prueba->id)
                ->where('competidors.competencia_id',$competencia->id)
                ->where('competidors.categoria_id',$prueba->categoria_id)
                ->where('competidors.sexo',$sexo)
                ->orderBy('competidors.tiempo_competidor','asc')
                ->get();
            }else{
                $competidoresAptos2 = InscripcionPrueba::join('competidors','inscripcion_pruebas.competidor_id','=','competidors.id')
                ->where('inscripcion_pruebas.prueba_id',$prueba->id)
                ->where('competidors.competencia_id',$competencia->id)
                ->where('competidors.categoria_id',$prueba->categoria_id)
                ->orderBy('competidors.tiempo_competidor','asc')
                ->get();
            }
            #CON 5 NO ANDA
            $cancha = 6;
           
            $rs = [];
            foreach($competidoresAptos2 as $item){
                array_push($rs,$item);
            }
            /**
             * array chunk tiene que recibit un array , si pongo $competidoresAptos2 al ser una coleccion no es valido
             * por eso lo paso a rs , para que sea array..
             */
            $cantidad_series = round($competidoresAptos2->count()/$cancha) == 0 ? 1 : round($competidoresAptos2->count()/$cancha);
            $cantidad_competidores =  round($competidoresAptos2->count()/round($cantidad_series));
            $cancheo_creacion = [];
           if($cantidad_competidores >= 7){
    
            $cancheo_creacion =array_chunk($rs,($cantidad_competidores-2));
    
           }else if($cantidad_competidores <= 4){
    
            $cancheo_creacion =$this->partition($rs,$cantidad_series);
            
           }
            $carriles = ['4','3','5','2','1','6'];
            /**
             * 
             *!INSERTA 2 VECES LO MISMOS 3  SERIES PERO LE CAMBIA EL NOMBRE DE PRUEBA 1 - P2
             */
            
                foreach($cancheo_creacion as $index => $can){
               
                    $s = new Serie;
                    $s->nombre_serie='Serie '.$index;
                    $s->prueba_id=$prueba->id;
                    $s->competencia_id=$competencia->id;
                    $s->save();
                   
                  
                   foreach($can as  $index =>$c){
                        $canch = new Cancheo;
                        $canch->carril = $carriles[$index];
                        $canch->competidor_id = $c->competidor_id;
                        $canch->serie_id = $s->id;
                        $canch->competencia_id=$competencia->id;
                        $canch->save();
                   }  
               }
            
          
        }
    }
        }
        
    public function partition( $list, $p ) {
        $listlen = count( $list );
        $partlen = floor( $listlen / $p );
        $partrem = $listlen % $p;
        $partition = array();
        $mark = 0;
        for ($px = 0; $px < $p; $px++) {
            $incr = ($px < $partrem) ? $partlen + 1 : $partlen;
            $partition[$px] = array_slice( $list, $mark, $incr );
            $mark += $incr;
        }
        return $partition;
    }

}

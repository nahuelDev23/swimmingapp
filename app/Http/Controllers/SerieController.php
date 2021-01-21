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
        $sexo = '';

        if($serie->prueba->sexo == 'VARONES'){
            $sexo = 'M';
        }else if($serie->prueba->sexo == 'MUJERES'){
            $sexo = 'F';
        }else{
            $sexo = '';
        };

        if($sexo != ''){
            $competidoresAptos2 = InscripcionPrueba::join('competidors','inscripcion_pruebas.competidor_id','=','competidors.id')
            ->where('inscripcion_pruebas.prueba_id',$serie->prueba_id)
            ->where('competidors.competencia_id',$serie->competencia_id)
            ->where('competidors.categoria_id',$serie->prueba->categoria_id)
            ->where('competidors.sexo',$sexo)
            ->orderBy('competidors.tiempo_competidor','asc')
            ->get();
        }else{
            $competidoresAptos2 = InscripcionPrueba::join('competidors','inscripcion_pruebas.competidor_id','=','competidors.id')
            ->where('inscripcion_pruebas.prueba_id',$serie->prueba_id)
            ->where('competidors.competencia_id',$serie->competencia_id)
            ->where('competidors.categoria_id',$serie->prueba->categoria_id)
            ->orderBy('competidors.tiempo_competidor','asc')
            ->get();
        }
        $cancha = 6;
       
        $rs = [];
        foreach($competidoresAptos2 as $item){
            array_push($rs,$item);
        }
        /**
         * array chunk tiene que recibit un array , si pongo $competidoresAptos2 al ser una coleccion no es valido
         * por eso lo paso a rs , para que sea array..
         */
        $cantidad_series = round($competidoresAptos2->count()/$cancha);
        $cantidad_competidores =  round($competidoresAptos2->count()/round($cantidad_series));
        $cancheo_creacion = [];
       if($cantidad_competidores >= 7){

        $cancheo_creacion =array_chunk($rs,($cantidad_competidores-2));

       }else if($cantidad_competidores <= 4){

        $cancheo_creacion =$this->partition($rs,$cantidad_series);
        
       }
        
        $carriles = ['4','3','5','2','1','6'];
    //    foreach($cancheo_creacion as $index => $can){
    //         $s = new Serie;
    //         $s->nombre_serie='Serie '.$index;
    //         $s->prueba_id=$can[0]->prueba_id;
    //         $s->competencia_id=$can[0]->competencia_id;
    //         $s->save();
    //        foreach($can as  $index =>$c){

              

    //             $canch = new Cancheo;
    //             $canch->carril = $carriles[$index];
    //             $canch->competidor_id = $c->competidor_id;
    //             $canch->serie_id = $s->id;
    //             $canch->save();
    //        }  
    //    }
       $cancheo = Cancheo::where('serie_id',$serie->id)->with('competidor')->get();
        return view('series/show',[
            'serie' => $serie,
            'cancheo'=>$cancheo,
            'competidoresAptos'=>$competidoresAptos2,
            'cancheo_creacion' => $cancheo_creacion,
            'carriles' => $carriles,
        ]);
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


<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Competencia;
use App\Models\Competidor;
use App\Models\Prueba;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompetidorController extends Controller
{
    public function create(Competencia $competencia)
    {
        $tiempo_competidores = Competidor::where('competencia_id',$competencia->id)->orderBy('competidor_tiempo','asc')->get();
        $pruebas_select = Prueba::where('competencia_id',$competencia->id)->pluck('nombre_prueba','id');
        $alumnos_select = Alumno::where('club_id',Auth::user()->club->id)->selectRaw('id,CONCAT(nombre," ",apellido," - ",dni) as nombre' )->pluck('nombre','id');
        $pruebas_de_la_competencia = Prueba::where('competencia_id',$competencia->id)->orderBy('nombre_prueba','asc')->get();

        $rs = [];
        
        foreach($pruebas_de_la_competencia as $p){
            array_push($rs, Competidor::where('competencia_id',$competencia->id)
            ->where('prueba_id',$p->id)
            ->orderBy('competidor_tiempo','asc')
            ->get());
        }
       
        return view('competidores/create',[
            'pruebas_select'=> $pruebas_select,
            'competencia_id'=> $competencia->id,
            'alumnos_select' => $alumnos_select,
            'tiempo_competidores' => $tiempo_competidores,
            'pruebas_de_la_competencia'=>$pruebas_de_la_competencia,
            'rs'=>$rs,
        ]);
    }


    public function store(Request $request)
    {
        $sexo = '';
        /**
         * ?un competidor no puede estar dos veces en la misma prueba
         * ?la categoria de la prueba y la categoria del alumno tienen que ser las mismas para poder anotarse
         */
        

        $checker_if_alumno_already_exist_in_competidor = Competidor::where('competencia_id',$request->competencia_id)
        ->where('alumno_id', $request->alumno_id)
        ->where('prueba_id', $request->prueba_id)
        ->get();

        $checker_alumno_category = Alumno::where('id',$request->alumno_id)->select('categoria_id')->first();
        $checker_prueba_category = Prueba::where('id',$request->prueba_id)->select('categoria_id')->first();

        $checker_alumno_sexo = Alumno::where('id',$request->alumno_id)->select('sexo')->first();
        $checker_prueba_sexo = Prueba::where('id',$request->prueba_id)->select('sexo')->first();
        
        if ($checker_prueba_sexo->sexo == 'VARONES') {
            $sexo = 'M';
        } else if ($checker_prueba_sexo->sexo == 'MUJERES') {
            $sexo = 'F';
        } else {
            $sexo = '';
        };

        if($sexo != $checker_alumno_sexo->sexo && strlen($sexo) != 0){
            return back()->with('message','El alumno que estás intentando anotar no es del  mismo sexo que requiere la prueba');
        }

        if($checker_alumno_category->categoria_id != $checker_prueba_category->categoria_id){
            return back()->with('message','El alumno que estás intentando anotar no es de la misma categoria que requiere la prueba');
        }

        if($checker_if_alumno_already_exist_in_competidor->count() > 0 ){
            return back()->with('message','El alumno que estás intentando anotar ya esta registrado');
        }else{
            $competidor = new Competidor;
            $competidor->competencia_id = $request->competencia_id;
            $competidor->alumno_id = $request->alumno_id;
            $competidor->prueba_id = $request->prueba_id;
            $competidor->competidor_tiempo = $request->competidor_tiempo;
            $competidor->save();
            return back()->with('message','el alumno se registro en la prueba correctamente');
        }
       
    }

}

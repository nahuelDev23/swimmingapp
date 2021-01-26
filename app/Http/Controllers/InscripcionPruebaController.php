<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Competencia;
use App\Models\Competidor;
use App\Models\Prueba;
use App\Models\Categoria;
use App\Models\InscripcionPrueba;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class InscripcionPruebaController extends Controller
{
    public function create(Competencia $competencia)
    {

        $tiempo_competidores = Competidor::where('competencia_id', $competencia->id)->orderBy('competidor_tiempo', 'asc')->get();
        $pruebas_select = Prueba::where('competencia_id', $competencia->id)->orderBy('nombre_prueba', 'asc')->pluck('nombre_prueba', 'id');
        $competidor_select = Competidor::join('alumnos','competidors.alumno_id','=','alumnos.id')
        ->join('pruebas','competidors.prueba_id','=','pruebas.id')
        ->where('alumnos.club_id', Auth::user()->club->id)
        ->selectRaw('competidors.id,CONCAT(alumnos.nombre," ",alumnos.apellido," - ",alumnos.dni," - ",pruebas.nombre_prueba," - ",competidor_tiempo) as nombre')->pluck('nombre', 'id');

        $pruebas_de_la_competencia = Prueba::where('competencia_id', $competencia->id)->orderBy('nombre_prueba', 'asc')->get();

        $rs = [];
        
        foreach($pruebas_de_la_competencia as $p){
            array_push($rs, InscripcionPrueba::where('inscripcion_pruebas.competencia_id',$competencia->id)
            ->where('inscripcion_pruebas.prueba_id',$p->id)
            // ->join('competidors','inscripcion_pruebas.competidor_id','=','competidors.id')
            // ->orderBy('competidors.competidor_tiempo','asc')
            ->get());
        }

        return view('inscripciones/create', [
            'pruebas_select' => $pruebas_select,
            'competencia_id' => $competencia->id,
            'competidor_select' => $competidor_select,
            'tiempo_competidores' => $tiempo_competidores,
            'pruebas_de_la_competencia' => $pruebas_de_la_competencia,
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
        

        $checker_if_alumno_already_exist_in_competidor = InscripcionPrueba::where('competencia_id',$request->competencia_id)
        ->where('competidor_id', $request->competidor_id)
        ->where('prueba_id', $request->prueba_id)
        ->get();

        $checker_alumno_category = Competidor::join('alumnos','competidors.alumno_id','=','alumnos.id')
        ->where('competidors.id',$request->competidor_id)
        ->select('alumnos.categoria_id')->first();

        $checker_prueba_category = Prueba::where('id',$request->prueba_id)->select('categoria_id')->first();

        /**
         * chekear si el competidor que se va a inscribir tiene  registrado tiempo en la prueba 
         */
        $checker_prueba_competidor = Competidor::where('id',$request->competidor_id)->select('prueba_id')->first();
 
        if($checker_prueba_competidor->prueba_id != $request->prueba_id){
            return back()->with('message','El alumno que estás intentando anotar no tiene  tiempo registrado para la prueba');
        }
        $checker_alumno_sexo = Competidor::join('alumnos','competidors.alumno_id','=','alumnos.id')
        ->where('competidors.id',$request->competidor_id)
        ->select('alumnos.sexo')
        ->first();

     

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
            $competidor = new InscripcionPrueba;
            $competidor->competencia_id = $request->competencia_id;
            $competidor->competidor_id = $request->competidor_id;
            $competidor->prueba_id = $request->prueba_id;
            $competidor->save();
            return back()->with('message','el alumno se registro en la prueba correctamente');
        }
       
    }
}

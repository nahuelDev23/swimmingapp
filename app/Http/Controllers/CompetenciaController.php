<?php

namespace App\Http\Controllers;

use App\Models\Competencia;
use App\Models\Prueba;
use App\Models\Serie;
use Illuminate\Http\Request;
use App\Models\InscripcionPrueba;
use App\Models\Cancheo;
use Illuminate\Support\Facades\Auth;

class CompetenciaController extends Controller
{
    public function index()
    {
        if ((Auth::user()->password_changed_at == null)) {
            return view('users/reset-password');
         }
         else{
            $competencias = Competencia::select('id', 'nombre_competencia', 'detalle', 'fecha_competencia')->get();
            return view('dashboard', [
                'competencias' => $competencias,
            ]);
         }
       
    }

    public function show(Competencia $competencia)
    {

        $series = $competencia->series;
        $pruebas = Prueba::where('competencia_id',$competencia->id)->get();
        return view('competencias/show', [
            'competencia' => $competencia,
            'series' => $series,
            'pruebas' => $pruebas,
        ]);
    }

    public function generarSeriesCancheos(Competencia $competencia)
    {
        $this->deleteSeriesPorCompetencia($competencia->id);
       
        $sexo = '';
    
        foreach ($competencia->pruebas as $prueba) {
            if ($prueba->sexo == 'VARONES') {
                $sexo = 'M';
            } else if ($prueba->sexo == 'MUJERES') {
                $sexo = 'F';
            } else {
                $sexo = '';
            };

            if ($sexo != '') {
                $competidoresAptos = InscripcionPrueba::join('competidors', 'inscripcion_pruebas.competidor_id', '=', 'competidors.id')
                    ->where('inscripcion_pruebas.prueba_id', $prueba->id)
                    ->where('competidors.competencia_id', $competencia->id)
                    ->where('competidors.categoria_id', $prueba->categoria_id)
                    ->where('competidors.sexo', $sexo)
                    ->orderBy('competidors.tiempo_competidor', 'asc')
                    ->get();
            } else {
                $competidoresAptos = InscripcionPrueba::join('competidors', 'inscripcion_pruebas.competidor_id', '=', 'competidors.id')
                    ->where('inscripcion_pruebas.prueba_id', $prueba->id)
                    ->where('competidors.competencia_id', $competencia->id)
                    ->join('alumnos','competidors.alumno_id','=','alumnos.id')
                    ->where('alumnos.categoria_id', $prueba->categoria_id)
                    ->orderBy('competidors.competidor_tiempo', 'asc')
                    ->get();
            }

            /**
             * !agregar  ala tabla competencias la cantidad de carriles que va a tener la competencia
             * !y que este valor sea esa calumna
             */
            $cancha = 6;

            $rs = [];
            foreach ($competidoresAptos as $item) {
                array_push($rs, $item);
            }
            /**
             * ?array chunk tiene que recibit un array , si pongo $competidoresAptos al ser una coleccion no es valido
             * ?por eso lo paso a rs , para que sea array..
             */
            $cantidad_series = round($competidoresAptos->count() / $cancha) == 0 ? 1 : round($competidoresAptos->count() / $cancha);
            $cantidad_competidores =  round($competidoresAptos->count() / round($cantidad_series));
            $cancheo_creacion = [];
            if ($cantidad_competidores >= 7) {

                $cancheo_creacion = array_chunk($rs, ($cantidad_competidores - 2));
            } else if ($cantidad_competidores <= 4) {

                $cancheo_creacion = $this->partition($rs, $cantidad_series);
            }
            $carriles = ['4', '3', '5', '2', '1', '6'];

            foreach ($cancheo_creacion as $index => $can) {

                $s = new Serie;
                $s->nombre_serie = 'Serie ' . $index;
                $s->prueba_id = $prueba->id;
                $s->competencia_id = $competencia->id;
                $s->save();


                foreach ($can as  $index => $c) {
                    $canch = new Cancheo;
                    $canch->carril = $carriles[$index];
                    $canch->competidor_id = $c->competidor_id;
                    $canch->serie_id = $s->id;
                    $canch->competencia_id = $competencia->id;
                    $canch->save();
                }
            }
        }
    }

    public function partition($list, $p)
    {
        $listlen = count($list);
        $partlen = floor($listlen / $p);
        $partrem = $listlen % $p;
        $partition = array();
        $mark = 0;
        for ($px = 0; $px < $p; $px++) {
            $incr = ($px < $partrem) ? $partlen + 1 : $partlen;
            $partition[$px] = array_slice($list, $mark, $incr);
            $mark += $incr;
        }
        return $partition;
    }

    public function deleteSeriesPorCompetencia($competencia_id){
            Serie::where('competencia_id',$competencia_id)->delete();
    }
}

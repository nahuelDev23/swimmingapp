<?php

namespace App\Repositories;

use App\Http\Helpers;
use App\Models\InscripcionPrueba;
use App\Models\Competidor;
use App\Models\Prueba;
use App\Models\Serie;
use App\Models\Cancheo;
use App\Models\Competencia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;

class InscripcionPruebaRepository
{
    private $inscripcionPrueba;
    private $competidor;
    private $prueba;


    public function __construct(InscripcionPrueba  $inscripcionPrueba, Competidor $competidor, Prueba $prueba)
    {
        $this->inscripcionPrueba = $inscripcionPrueba;
        $this->competidor = $competidor;
        $this->prueba = $prueba;

    }
    public function validate_conditions_init($request): RedirectResponse
    {
        if (!$this->check_if_alumno_exist_in_inscripcion_prueba($request)) {
            return back()->with('message', 'el alumno ya existe');
        }

        if (!$this->validate_alumno_category($request->competidor_id, $request->prueba_id)) {
            return back()->with('message', 'El alumno que estás intentando anotar no es de la misma categoria que requiere la prueba!!');
        }

        if (!$this->check_if_alumno_have_time_register_for_the_prueba($request->competidor_id, $request->prueba_id)) {
            return back()->with('message', 'El alumno que estás intentando anotar no tiene  tiempo registrado para la prueba');
        }

        if (!$this->validate_alumno_sexo_in_prueba($request->competidor_id, $request->prueba_id)) {
            return  back()->with('message', 'El alumno que estás intentando anotar no es del  mismo sexo que requiere la prueba');
        }
        return $this->create($request);
    }

    public function check_if_alumno_have_time_register_for_the_prueba($competidor_id, $prueba_id): bool
    {
        $checker_prueba_competidor = Competidor::where('id', $competidor_id)->select('prueba_id')->first();

        if ($checker_prueba_competidor->prueba_id != $prueba_id) {
            return false;
        }
        return true;
    }

    public function check_if_alumno_exist_in_inscripcion_prueba($request): bool
    {
        $response = $this->inscripcionPrueba->whereCompetenciaAndTiempoAndPrueba($request);
        return $response ? false : true;
    }

    public function validate_alumno_category($competidor_id, $prueba_id): bool
    {
        $alumno_category = $this->competidor->getCategoryIdOfAlumnoInTableCompetidors($competidor_id)->categoria_id;

        $prueba_category = $this->prueba->getCategoryIdOfPrueba($prueba_id)->categoria_id;

        if ($alumno_category != $prueba_category) {
            return false;
        }

        return true;
    }

    public function validate_alumno_sexo_in_prueba(int $competido_id, int $prueba_id): bool
    {
        $sexo = '';

        $alumno_sexo = $this->competidor->getAlumnoSexoInTableCompetidors($competido_id)->sexo;
        $prueba_sexo = $this->prueba->getSexoPrueba($prueba_id)->sexo;

        if ($prueba_sexo == 'VARONES') {
            $sexo = 'M';
        } else if ($prueba_sexo == 'MUJERES') {
            $sexo = 'F';
        } else {
            $sexo = '';
        };

        if ($sexo != $alumno_sexo && strlen($sexo) != 0) {
            return false;
        }
        return true;
    }
    public function create($request): RedirectResponse
    {
        $competidor = new InscripcionPrueba;
        $competidor->competencia_id = $request->competencia_id;
        $competidor->competidor_id = $request->competidor_id;
        $competidor->prueba_id = $request->prueba_id;
        $competidor->save();
        return  back()->with('message', 'el alumno se registro en la prueba correctamente');
    }

    public function fill_competidor_select(int $competencia_id): Collection
    {
        return $this->competidor->ByIfIsAdminOrUserAllAlumnoWithTiempoAndPruebaRegister($competencia_id);
    }

    public function list_alumno_for_prueba(Collection $pruebas_de_la_competencia, int $competencia_id): array
    {
        return $this->inscripcionPrueba->ByIfIsAdminOrUserListAlumnosByPrueba($pruebas_de_la_competencia, $competencia_id);
    }

    public function getSexoOfPrueba($sexo)
    {
        if ($sexo == 'VARONES') {
            return 'M';
        } else if ($sexo == 'MUJERES') {
            return 'F';
        } else {
            return '';
        };
    }

    public function createSeriesAndCancheoByPruebas(Competencia $competencia)
    {
        foreach ($competencia->pruebas as $prueba) {
            $sexo = $this->getSexoOfPrueba($prueba->sexo);
            $competidoresAptos = $this->inscripcionPrueba->getInscriptosPruebaFitForEachPruebaInCompetenciaOrderByTiempo($prueba, $sexo, $competencia->id);
            $cancha = $competencia->carriles;
            $competidoresAptosArray = Helpers::ConvertCollectionToArray($competidoresAptos);
            $cantidad_series = $this->calcularCantidadDeSeriesSegunCantidadDeCompetidoresAptos($competidoresAptos->count(), $cancha);
            $cantidad_competidores_por_series =  round($competidoresAptos->count() / round($cantidad_series));
            $cancheoDeSeriesOrdernadoPorTiempo = $this->separarEnSeriesParejasAlosAlumnos($competidoresAptosArray, $cantidad_competidores_por_series, $cantidad_series);

            $carrilesPorVelocidad = ['4', '3', '5', '2', '1', '6'];

            $this->generarSeriesYCancheos($cancheoDeSeriesOrdernadoPorTiempo,$prueba->id,$competencia->id,$carrilesPorVelocidad);
        }
    }

    public function generarSeriesYCancheos(Array $cancheoDeSeriesOrdernadoPorTiempo,int $pruebaId,int $competenciaId,Array $carrilesPorVelocidad):void
    {
        foreach ($cancheoDeSeriesOrdernadoPorTiempo as $index => $cancheos) {

            $serie = new Serie;
            $serie->nombre_serie = 'Serie ' . $index;
            $serie->prueba_id = $pruebaId;
            $serie->competencia_id = $competenciaId;
            $serie->save();


            foreach ($cancheos as  $index => $cancheo) {
                $canch = new Cancheo;
                $canch->carril = $carrilesPorVelocidad[$index];
                $canch->competidor_id = $cancheo->competidor_id;
                $canch->serie_id = $serie->id;
                $canch->competencia_id = $competenciaId;
                $canch->save();
            }
        }
    }
    public function separarEnSeriesParejasAlosAlumnos(Array $competidoresAptosArray,int $cantidad_competidores_por_series,int $cantidad_series) : Array
    {
        if ($cantidad_competidores_por_series >= 7) {
            return  array_chunk($competidoresAptosArray, ($cantidad_competidores_por_series - 2));
        } else if ($cantidad_competidores_por_series <= 4) {
            return $this->partition($competidoresAptosArray, $cantidad_series);
        }
    }

    public function calcularCantidadDeSeriesSegunCantidadDeCompetidoresAptos(int $cantidadDeCompetidoresAptos,int $carrilesDeLaCancha):int 
    {
        return  round($cantidadDeCompetidoresAptos / $carrilesDeLaCancha) == 0 ? 1 : round($cantidadDeCompetidoresAptos / $carrilesDeLaCancha);
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
}

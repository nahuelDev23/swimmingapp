<?php

namespace App\Repositories\UsesCase\Competencia;
use App\Models\Competencia;
use App\Models\InscripcionPrueba;
use App\Http\Helpers;
use App\Models\Serie;
use App\Models\Cancheo;
use Illuminate\Support\Collection;
use App\Repositories\UsesCase\Competencia\DeleteSeriesPorCompetencia;
use App\Repositories\UsesCase\Serie\GenerarSerie;


class CreateSeriesAndCancheoByPruebas
{
    private Competencia $competencia;
    private InscripcionPrueba $inscripcionPrueba;
    private const carrilesPorVelocidad = ['4', '3', '5', '2', '1', '6'];

    public function __construct(Competencia $competencia,InscripcionPrueba $inscripcionPrueba)
    {
        $this->competencia = $competencia;
        $this->inscripcionPrueba = $inscripcionPrueba;
    }

    public function execute():void
    {
        $deleteSeriesPorComptencia = new DeleteSeriesPorCompetencia($this->competencia);
        $deleteSeriesPorComptencia->execute();

        $this->createSeriesAndCancheoByPruebas();
    }

    public function getSexoOfPrueba($sexo): ?string
    {
        if ($sexo == 'VARONES') {
            return 'M';
        } else if ($sexo == 'MUJERES') {
            return 'F';
        } else {
            return '';
        };
    }

    public function createSeriesAndCancheoByPruebas() :void
    {
       
        foreach ($this->competencia->pruebas as $prueba) {
            $sexo = $this->getSexoOfPrueba($prueba->sexo);
            $competidoresAptos = $this->inscripcionPrueba->getInscriptosPruebaFitForEachPruebaInCompetenciaOrderByTiempo($prueba, $sexo, $this->competencia->id);
            $cancha = $this->competencia->carriles;
            $competidoresAptosArray = Helpers::ConvertCollectionToArray($competidoresAptos);
            $cantidad_series = $this->calcularCantidadDeSeriesSegunCantidadDeCompetidoresAptos($competidoresAptos->count(), $cancha);
            $cantidad_competidores_por_series =  round($competidoresAptos->count() / round($cantidad_series));
            $cancheoDeSeriesOrdernadoPorTiempo = $this->separarEnSeriesParejasAlosAlumnos($competidoresAptosArray, $cantidad_competidores_por_series, $cantidad_series);

            $this->generarSeriesYCancheos($cancheoDeSeriesOrdernadoPorTiempo,$prueba->id,$this->competencia->id);
        }
    }

    public function generarSeriesYCancheos(Array $cancheoDeSeriesOrdernadoPorTiempo,int $pruebaId,int $competenciaId):void
    {
        foreach ($cancheoDeSeriesOrdernadoPorTiempo as $index => $cancheos) {

            $generarSerie = new GenerarSerie();
            $serieId = $generarSerie->execute($index,$pruebaId,$competenciaId);

            foreach ($cancheos as  $index => $cancheo) {
                $canch = new Cancheo;
                $canch->carril = SELF::carrilesPorVelocidad[$index];
                $canch->competidor_id = $cancheo->competidor_id;
                $canch->serie_id = $serieId->id;
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

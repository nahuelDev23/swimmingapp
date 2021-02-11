<?php

namespace App\Repositories\UsesCase\Cancheo;
use App\Models\Cancheo;

class GenerarCancheo
{
    private const carrilesPorVelocidad = ['4', '3', '5', '2', '1', '6'];

    public function execute(Object $cancheos,int $competenciaId,int $serieId,int $index) 
    {
        $this->create($cancheos,$competenciaId,$serieId,$index);
    }

    public function create(Object $cancheos,int $competenciaId,int $serieId,int $index) : void
    {
        $cancheo = new Cancheo;
        $cancheo->carril = SELF::carrilesPorVelocidad[$index];
        $cancheo->competidor_id = $cancheos->competidor_id;
        $cancheo->serie_id = $serieId;
        $cancheo->competencia_id = $competenciaId;
        $cancheo->save();
}

}

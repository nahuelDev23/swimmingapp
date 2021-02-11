<?php

namespace App\Repositories\UsesCase\Competencia;
use App\Models\Competencia;
use App\Models\Serie;

class DeleteSeriesPorCompetencia
{
    private Competencia $competencia;

    public function __construct(Competencia $competencia)
    {
        $this->competencia = $competencia;

    }

    public function execute():void
    {
        $this->deleteSeriesPorCompetencia();
    }

    public function deleteSeriesPorCompetencia(){
        Serie::where('competencia_id',$this->competencia->id)->delete();
}

}

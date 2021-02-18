<?php

namespace App\Repositories\UsesCase\Serie;
use App\Models\Serie;
use Illuminate\Database\Eloquent\Collection;
class GetSerieOfCompetenciaOrderByNombrePrueba
{
    private $serie;
    public function __construct(Serie $serie)
    {
        $this->serie = $serie;
    }
   
    public function execute($competenciaId) 
    {
        return $this->GetSerieOfCompetenciaOrderByNombrePrueba($competenciaId);
    }

    public function GetSerieOfCompetenciaOrderByNombrePrueba($competenciaId) : Collection
    {
        return $this->serie->getSeriesByCompetenciaOrderByNombrePrueba($competenciaId);

}

}

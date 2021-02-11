<?php

namespace App\Repositories\UsesCase\Serie;
use App\Models\Serie;

class GenerarSerie
{
   
    public function execute($index,$pruebaId,$competenciaId) 
    {
        return $this->create($index,$pruebaId,$competenciaId);
    }

    public function create($index,$pruebaId,$competenciaId) : Serie
    {
        $serie = new Serie;
        $serie->nombre_serie = 'Serie ' . $index;
        $serie->prueba_id = $pruebaId;
        $serie->competencia_id = $competenciaId;
        $serie->save();
        return $serie;
}

}

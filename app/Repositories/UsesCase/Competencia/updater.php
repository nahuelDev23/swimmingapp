<?php
namespace App\Repositories\UsesCase\Competencia;

use App\Models\Competencia;
use Illuminate\Http\Request;
class Updater
{

    private $competencia;

    public function __construct(Competencia $competencia)
    {
        $this->competencia = $competencia;
    }
    public function execute(Request $request)
    {
        return $this->updater($request);
    }

    public function updater($request)
    {
        $this->competencia->nombre_competencia = $request->nombre_competencia;
        $this->competencia->fecha_competencia = $request->fecha_competencia;
        $this->competencia->detalle = $request->detalle;
        $this->competencia->carriles = $request->carriles;
        $this->competencia->update();
       
    }
}
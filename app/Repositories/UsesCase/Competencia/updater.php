<?php
namespace App\Repositories\UsesCase\Competencia;

use App\Models\Competencia;
use Illuminate\Http\Request;
class Updater
{

    private $request;
    private $competencia;

    public function __construct(Request $request,Competencia $competencia)
    {
        $this->request = $request;
        $this->competencia = $competencia;
    }
    public function execute()
    {
        return $this->updater();
    }

    public function updater()
    {
        $this->competencia->nombre_competencia = $this->request->nombre_competencia;
        $this->competencia->fecha_competencia = $this->request->fecha_competencia;
        $this->competencia->detalle = $this->request->detalle;
        $this->competencia->carriles = $this->request->carriles;
        $this->competencia->update();
        return back()->with('message','La competencia se edito con exito');
    }
}
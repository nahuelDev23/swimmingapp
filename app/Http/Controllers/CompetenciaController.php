<?php

namespace App\Http\Controllers;

use App\Models\Competencia;
use App\Models\Prueba;
use App\Models\Serie;
use Illuminate\Http\Request;
use App\Models\InscripcionPrueba;
use App\Repositories\UsesCase\Competencia\CreateSeriesAndCancheoByPruebas;
use Illuminate\Support\Facades\Auth;

class CompetenciaController extends Controller
{
    public function index()
    {
        if ((Auth::user()->password_changed_at == null)) {
            return view('users/reset-password');
         }
         else{
            return view('dashboard', [
                'competencias' => Competencia::select('id', 'nombre_competencia', 'detalle', 'fecha_competencia')->get(),
            ]);
         }
       
    }

    public function create()
    {   
        return view('competencias/create');
    }

    public function store(Request $request)
    {   
       Competencia::create($request->all());
       return back()->with('message','Competencia creada');
    }
    public function show(Competencia $competencia)
    {

        $series = Serie::where('series.competencia_id',$competencia->id)
        ->join('pruebas','series.prueba_id','=','pruebas.id')
        ->select('series.id','series.nombre_serie','pruebas.nombre_prueba','series.competencia_id')
        ->orderBy('pruebas.nombre_prueba','asc')
        ->get();

        
        $pruebas = Prueba::where('competencia_id',$competencia->id)->orderBy('nombre_prueba')->get();
        return view('competencias/show', [
            'competencia' => $competencia,
            'series' => $series,
            'pruebas' => $pruebas,
        ]);
    }

    public function generarSeriesCancheos(Competencia $competencia,InscripcionPrueba $inscripcionPrueba)
    {
        $createSeriesAndCancheoByPruebas = new CreateSeriesAndCancheoByPruebas($competencia,$inscripcionPrueba);
        $createSeriesAndCancheoByPruebas->execute();
        return back();
    }





    public function edit(Competencia $competencia)
    {
        return view('competencias/edit',[
            'competencia' => $competencia,
        ]);
    }

    public function update(Request $request,Competencia $competencia)
    {
        $competencia->nombre_competencia = $request->nombre_competencia;
        $competencia->fecha_competencia = $request->fecha_competencia;
        $competencia->detalle = $request->detalle;
        $competencia->carriles = $request->carriles;
        $competencia->update();
        return back()->with('message','La competencia se edito con exito');
    }
    public function destroy($id)
    {
        Competencia::find($id)->delete();
        return back()->with('success','La competencia se eliminó con exito');
    }
}

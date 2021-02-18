<?php

namespace App\Http\Controllers;
use App\Models\Competencia;
use App\Models\Prueba;
use App\Models\Serie;
use Illuminate\Http\Request;
use App\Models\InscripcionPrueba;
use App\Repositories\UsesCase\Competencia\CreateSeriesAndCancheoByPruebas;
use App\Repositories\UsesCase\Competencia\Updater;
use App\Repositories\UsesCase\Competencia\CheckIfNewUserResetDefatultPassword;
use App\Repositories\UsesCase\Serie\GetSerieOfCompetenciaOrderByNombrePrueba;


class CompetenciaController extends Controller
{
    public function index()
    {
        $changeDefaultPassword = new CheckIfNewUserResetDefatultPassword();
        return  $changeDefaultPassword->execute();
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
    public function show(Competencia $competencia,Serie $serie)
    {
        $series = new GetSerieOfCompetenciaOrderByNombrePrueba($serie);
        return view('competencias/show', [
            'competencia' => $competencia,
            'series' => $series->execute($competencia->id),
            'pruebas' => Prueba::where('competencia_id',$competencia->id)->orderBy('nombre_prueba')->get(),
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
        $update = new Updater($competencia);
        $update->execute($request);
        return redirect('dashboard')->with('success','La competencia se edito con exito');
    }

    public function destroy($id)
    {
        Competencia::find($id)->delete();
        return back()->with('success','La competencia se eliminó con exito');
    }
}

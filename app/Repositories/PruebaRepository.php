<?php

namespace App\Repositories;

use App\Models\Prueba;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;


class PruebaRepository
{
    private $prueba;

    public function __construct(Prueba $prueba)
    {
        $this->prueba = $prueba;
    }
    public function validateStoreOrUpdatePrueba_init($request, Prueba $prueba = null): RedirectResponse
    {
        if (!$this->validateIfNameOfPruebaAlreadyExistInCompetencia($request->competencia_id, $request->nombre_prueba, $prueba)) {
            return back()->with('error', 'Ya existe una prueba con ese nombre')->withInput();
        }
        if (!$this->validateThatNotExistTwoPruebaIndenticalWithDifferentName($request, $prueba)) {
            return back()->with('error', 'Hay una prueba que tiene los mismos requisitos pero con otro nombre')->withInput();
        }

        if ($prueba !== null) {
            return $this->update($request, $prueba);
        }

        return $this->create($request);
    }

    public function update($request, $prueba): RedirectResponse
    {
        $prueba->nombre_prueba = $request->nombre_prueba;
        $prueba->distancia = $request->distancia;
        $prueba->estilo = $request->estilo;
        $prueba->sexo = $request->sexo;
        $prueba->categoria_id = $request->categoria_id;
        $prueba->nivel = $request->nivel;
        $prueba->competencia_id = $request->competencia_id;

        $prueba->update();

        return back()->with('message', 'La prueba se editó correctamente');
    }


    public function validateIfNameOfPruebaAlreadyExistInCompetencia($competencia_id, $nombre_prueba, $prueba): bool
    {
        if($this->prueba->checkIfNamePruebaIsRepeatInCompetenciaForStoreOrUpdate($competencia_id, $nombre_prueba, $prueba)->count() > 0)
        {
            return false;
        }

        return true;
    }

    public function validateThatNotExistTwoPruebaIndenticalWithDifferentName($request,$prueba): bool
    {
       if($this->prueba->checkIfNameOfPruebaAlreadyExistInCompetenciaForStoreOrUpdate($request,$prueba)->count() > 0){
        return false;
       }
        return true;
    }

    public function create($request): RedirectResponse
    {
        $add_prueba = new Prueba();
        $add_prueba->nombre_prueba = $request->nombre_prueba;
        $add_prueba->distancia = $request->distancia;
        $add_prueba->estilo = $request->estilo;
        $add_prueba->sexo = $request->sexo;
        $add_prueba->categoria_id = $request->categoria_id;
        $add_prueba->nivel = $request->nivel;
        $add_prueba->competencia_id = $request->competencia_id;

        $add_prueba->save();

        return back()->with('message', 'La prueba se añadio correctamente');
    }

    public function getAllPruebasOfCompetenciaOrderByNombrePrueba(int $competencia_id): Collection
    {
        return Prueba::where('competencia_id', $competencia_id)->orderBy('nombre_prueba', 'asc')->get();
    }

    public function getAllPruebasOfCompetenciaOrderByNombrePruebaListForSelectInput(int $competencia_id): Collection
    {
        return  Prueba::where('competencia_id', $competencia_id)->orderBy('nombre_prueba', 'asc')->pluck('nombre_prueba', 'id');
    }
}

<?php

namespace App\Http\Controllers;

use App\Repositories\UsesCase\Categoria\getAllCategoriasOrderByNombreCategoriaListForSelectInput;
use App\Models\Competencia;
use App\Models\Prueba;
use App\Http\Requests\updatePruebaRequest;
use App\Http\Requests\addPruebaRequest;
use App\Repositories\PruebaRepository;


class PruebaController extends Controller
{
    public function create(Competencia $competencia,PruebaRepository $pruebaRepository)
    {
        $categoria = new getAllCategoriasOrderByNombreCategoriaListForSelectInput();
        return view('pruebas/create',[
            'competencia_id' => $competencia->id,
            'categorias_select' =>  $categoria->execute(),
            'pruebas_de_la_competencia_table'=>$pruebaRepository->getAllPruebasOfCompetenciaOrderByNombrePrueba($competencia->id),
        ]);
    }

    public function store(addPruebaRequest $request, PruebaRepository $pruebaRepository)
    {
        return $pruebaRepository->validateStoreOrUpdatePrueba_init($request);
    }

    public function edit(Prueba $prueba)
    {
        $categoria = new getAllCategoriasOrderByNombreCategoriaListForSelectInput();
        return view('pruebas/edit',[
            'prueba' => $prueba,
            'categorias_select' =>  $categoria->execute(),
            'prueba_id'=>$prueba->id,
            'competencia_id'=>$prueba->competencia_id,
        ]);
    }

    public function update(updatePruebaRequest $request, Prueba $prueba,PruebaRepository $pruebaRepository)
    {
        return $pruebaRepository->validateStoreOrUpdatePrueba_init($request,$prueba); 
    }

    public function destroy($id)
    {
        Prueba::destroy($id);
        return back()->with('success','La prueba se eliminó correctamente');
    }
}

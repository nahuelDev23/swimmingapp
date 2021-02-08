<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Competencia;
use App\Models\Prueba;
use Illuminate\Http\Request;
use App\Http\Requests\updatePruebaRequest;
use App\Http\Requests\addPruebaRequest;
use App\Repositories\PruebaRepository;
use App\Repositories\CategoriaRepository;

class PruebaController extends Controller
{
    public function create(Competencia $competencia,PruebaRepository $pruebaRepository,CategoriaRepository $categoriaRepository)
    {
        return view('pruebas/create',[
            'competencia_id' => $competencia->id,
            'categorias_select' =>  $categoriaRepository->getAllCategoriasOrderByNombreCategoriaListForSelectInput(),
            'pruebas_de_la_competencia_table'=>$pruebaRepository->getAllPruebasOfCompetenciaOrderByNombrePrueba($competencia->id),
        ]);
    }

    public function store(addPruebaRequest $request, PruebaRepository $pruebaRepository)
    {
        return $pruebaRepository->validateStoreOrUpdatePrueba_init($request);
    }

    public function edit(Prueba $prueba,CategoriaRepository $categoriaRepository)
    {
        return view('pruebas/edit',[
            'prueba' => $prueba,
            'categorias_select' =>  $categoriaRepository->getAllCategoriasOrderByNombreCategoriaListForSelectInput(),
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

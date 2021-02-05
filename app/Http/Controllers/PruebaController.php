<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Competencia;
use App\Models\Prueba;
use Illuminate\Http\Request;

class PruebaController extends Controller
{
    public function create(Competencia $competencia)
    {
        $categorias = Categoria::pluck('nombre_categoria','id');
        $pruebas_de_la_competencia = Prueba::where('competencia_id',$competencia->id)->orderBy('nombre_prueba','asc')->get();
        return view('pruebas/create',[
            'competencia_id' => $competencia->id,
            'categorias' => $categorias,
            'pruebas_de_la_competencia'=>$pruebas_de_la_competencia,
        ]);
    }

    public function store(Request $request)
    {
        /**
         * pasar todo a un request con mensajes personalizados
         */
       
        $this->validate($request, [
            'nombre_prueba' => 'required|min:8|max:9',
            'distancia' => 'required|min:2|max:3',
            'estilo' => 'required',
            'sexo' => 'required',
            'categoria_id' => 'required',
            'competencia_id' => 'required',
        ]);

        $check_if_name_is_repeat = Prueba::where('nombre_prueba',$request->nombre_prueba)->where('competencia_id',$request->competencia_id)->get();
        if($check_if_name_is_repeat->count() > 0){
            return back()->with('error','Ya existe una prueba con ese nombre')->withInput();
        }
        /**
         * Chequeo que no haya una prueba identica pero con distinto nombre
         */
        $check_if_register_is_repeat = Prueba::where('distancia',$request->distancia)
        ->where('estilo', $request->estilo)
        ->where('sexo', $request->sexo)
        ->where('categoria_id', $request->categoria_id)
        ->where('nivel', $request->nivel)
        ->where('competencia_id', $request->competencia_id)
        ->first();

        // dd($check_if_register_is_repeat);
        if($check_if_register_is_repeat != null ){
            return back()->with('error','La '.$check_if_register_is_repeat->nombre_prueba.' tiene los mismos requisitos')->withInput();
        }

        $add_prueba = new Prueba();
        $add_prueba->nombre_prueba = $request->nombre_prueba;
        $add_prueba->distancia = $request->distancia;
        $add_prueba->estilo = $request->estilo;
        $add_prueba->sexo = $request->sexo;
        $add_prueba->categoria_id = $request->categoria_id;
        $add_prueba->nivel = $request->nivel;
        $add_prueba->competencia_id = $request->competencia_id;

        $add_prueba->save();

        return back()->with('message','La prueba se añadio correctamente');
    }

    public function edit(Prueba $prueba)
    {
        $categorias = Categoria::pluck('nombre_categoria','id');
        return view('pruebas/edit',[
            'prueba' => $prueba,
            'categorias' => $categorias,
            'prueba_id'=>$prueba->id,
            'competencia_id'=>$prueba->competencia_id,
        ]);
    }

    public function update(Request $request, Prueba $prueba)
    {
        // dd($request->nombre_prueba);
         /**
         * pasar todo a un request con mensajes personalizados
         */
       
        $this->validate($request, [
            'nombre_prueba' => 'required|min:8|max:9|unique:pruebas,nombre_prueba,'.$prueba->id, #puedo repetir mi mismo nombre
            'distancia' => 'required|min:2|max:3',
            'estilo' => 'required',
            'sexo' => 'required',
            'categoria_id' => 'required',
            'competencia_id' => 'required',
        ]);

        /**
         * Chequeo que no haya una prueba identica pero con distinto nombre
         */
        $check_if_register_is_repeat = Prueba::where('distancia',$request->distancia)
        ->where('estilo', $request->estilo)
        ->where('sexo', $request->sexo)
        ->where('categoria_id', $request->categoria_id)
        ->where('nivel', $request->nivel)
        ->where('competencia_id', $request->competencia_id)
        ->first();

        /**
         * veo si los registros estan duplicados exeptuando si es mi mismo registro
         */
        if($check_if_register_is_repeat != null  && $check_if_register_is_repeat->id != $prueba->id){
            return back()->with('error','La '.$check_if_register_is_repeat->nombre_prueba.' tiene los mismos requisitos')->withInput();
        }

        $prueba->nombre_prueba = $request->nombre_prueba;
        $prueba->distancia = $request->distancia;
        $prueba->estilo = $request->estilo;
        $prueba->sexo = $request->sexo;
        $prueba->categoria_id = $request->categoria_id;
        $prueba->nivel = $request->nivel;
        $prueba->competencia_id = $request->competencia_id;

        $prueba->update();

        return back()->with('message','La prueba se editó correctamente');
        
    }

    public function destroy($id)
    {
        Prueba::destroy($id);
        return back()->with('success','La prueba se eliminó correctamente');
    }
}

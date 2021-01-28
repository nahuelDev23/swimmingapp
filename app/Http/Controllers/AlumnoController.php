<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Categoria;
use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlumnoController extends Controller
{
    public function index(){
        if(Auth::user()->is_admin == 1){
            $alumnos = Alumno::all();
        }else {
            $alumnos = Alumno::where('club_id',Auth::user()->club_id)->get();
        }
      
        return view('alumnos/index',[
            'alumnos' => $alumnos,
        ]);
    }

    public function create(){
        $categorias = Categoria::pluck('nombre_categoria','id');
        $clubs = Club::pluck('nombre_club','id');
        return view('alumnos/create',[
            'categorias' => $categorias,
            'clubs' => $clubs,
        ]);
    }

    public function edit(Alumno $alumno){
        $categorias = Categoria::pluck('nombre_categoria','id');
        return view('alumnos/edit',[
            'alumno' => $alumno,
            'categorias' => $categorias,
        ]);
    }

    public function update(Request $request ,Alumno $alumno){
        $this->validate($request, [
            'nombre' => 'required|min:3|max:50',
            'apellido' => 'required|min:3|max:50',
            'categoria_id' => 'required|max:3',
            'sexo' => 'required|max:1',
            'dni' => 'required|unique:alumnos,dni,'.$alumno->id,
            'fecha_nacimiento' => 'required',
        ]);
        
        $alumno->update( $request->except(['_method','_token']));
        
        return back()->with('message','El alumno se editó correctamente');
    }

    public function store(Request $request){

        $this->validate($request, [
            'nombre' => 'required|min:3|max:50',
            'apellido' => 'required|min:3|max:50',
            'categoria_id' => 'required|max:3',
            'sexo' => 'required|max:1',
            'dni' => 'required|unique:alumnos,dni',
            'fecha_nacimiento' => 'required',
        ]);

        $alumno = new Alumno();
        $alumno->nombre = $request->nombre;
        $alumno->apellido = $request->apellido;
        $alumno->categoria_id = $request->categoria_id;
        $alumno->sexo = $request->sexo;
        $alumno->dni = $request->dni;
        $alumno->fecha_nacimiento = $request->fecha_nacimiento;
        $alumno->club_id = Auth::user()->is_admin == 1 ? $request->club_id : Auth::user()->club_id;
        
        $alumno->save();

        return back()->with('success','El alumno se registro con exito');
    }

    public function destroy($id){
        Alumno::find($id)->delete();
        return back()->with('success','El alumno se eliminó con exito');
    }
    
}

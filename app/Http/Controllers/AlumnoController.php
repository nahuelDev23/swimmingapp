<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlumnoController extends Controller
{
    public function index(){
        $alumnos = Alumno::where('club_id',Auth::user()->club_id)->get();
        return view('alumnos/index',[
            'alumnos' => $alumnos,
        ]);
    }

    public function create(){
        $categorias = Categoria::pluck('nombre_categoria','id');
        return view('alumnos/create',[
            'categorias' => $categorias,
        ]);
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
        $alumno->club_id = Auth::user()->club_id;
        
        $alumno->save();

        return back()->with('success','El alumno se registro con exito');
    }


    
}

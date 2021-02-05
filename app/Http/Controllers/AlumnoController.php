<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Categoria;
use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Imports\AlumnosImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\AddAlumnoRequest;
use App\Http\Requests\UpdateAlumnoRequest;
use App\Repositories\AlumnoRepository;

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
        $clubs = Club::pluck('nombre_club','id');
        $categorias = Categoria::pluck('nombre_categoria','id');
        return view('alumnos/edit',[
            'alumno' => $alumno,
            'categorias' => $categorias,
            'clubs' => $clubs,
        ]);
    }

    public function update(UpdateAlumnoRequest $request ,Alumno $alumno){
        $alumno->update( $request->except(['_method','_token']));
        return back()->with('message','El alumno se editó correctamente');
    }

    public function store(AddAlumnoRequest $request,AlumnoRepository $AlumnoRepository){
        $AlumnoRepository->create($request);
        return back()->with('success','El alumno se registro con exito');
    }

    public function destroy($id){
        Alumno::find($id)->delete();
        return back()->with('success','El alumno se eliminó con exito');
    }
    
    function import(Request $request)
    {
     $this->validate($request, [
      'select_file'  => 'required|mimes:xls,xlsx'
     ]);

    
      Excel::import(new AlumnosImport,request()->file('select_file'));

     return back()->with('success', 'Excel Data Imported successfully.');
    }
}

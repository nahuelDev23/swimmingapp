<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Repositories\UsesCase\Alumno\Create;
use App\Repositories\UsesCase\Alumno\getAllAlumnosDependIfAuthUserIsAdminOrNot;
use App\Repositories\UsesCase\Categoria\getAllCategoriasOrderByNombreCategoriaListForSelectInput;
use App\Repositories\UsesCase\Club\GetAllClubListForSelectInput;
use App\Imports\AlumnosImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\AddAlumnoRequest;
use App\Http\Requests\UpdateAlumnoRequest;
use App\Http\Requests\ImportExcelRequest;


class AlumnoController extends Controller
{
    public function index(){
        $alumnos = new getAllAlumnosDependIfAuthUserIsAdminOrNot();
        return view('alumnos/index',[
            'alumnos' => $alumnos->execute(),
        ]);
    }

    public function create(){
        $categoria = new getAllCategoriasOrderByNombreCategoriaListForSelectInput();
        $clubs = new GetAllClubListForSelectInput();
        return view('alumnos/create',[
            'categorias' => $categoria->execute(),
            'clubs' => $clubs->execute(),
        ]);
    }

    public function edit(Alumno $alumno){
        $categoria = new getAllCategoriasOrderByNombreCategoriaListForSelectInput();
        $clubs = new GetAllClubListForSelectInput();
        return view('alumnos/edit',[
            'alumno' => $alumno,
            'categorias' => $categoria->execute(),
            'clubs' => $clubs->execute(),
        ]);
    }

    public function update(UpdateAlumnoRequest $request ,Alumno $alumno){
        $alumno->update( $request->except(['_method','_token']));
        return redirect('alumnos')->with('success','El alumno se editó correctamente');
    }

    public function store(AddAlumnoRequest $request){
        $store = new Create;
        $store->create($request);
        return redirect('alumnos')->with('success','El alumno se registro con exito');
    }

    public function destroy($id){
        Alumno::find($id)->delete();
        return redirect('alumnos')->with('success','El alumno se eliminó con exito');
    }
    
    function import(ImportExcelRequest $request)
    {
     //? probar en casa
    Excel::import(new AlumnosImport,request()->file('select_file'));

     return back()->with('success', 'Excel Data Imported successfully.');
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\Alumno;
use App\Imports\AlumnosImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\AddAlumnoRequest;
use App\Http\Requests\UpdateAlumnoRequest;
use App\Http\Requests\ImportExcelRequest;
use App\Repositories\CategoriaRepository;
use App\Repositories\ClubRepository;
use App\Repositories\UsesCase\Alumno\Creater;
use App\Repositories\UsesCase\Alumno\getAllDependIfAuthUserIsAdminOrNot;
class AlumnoController extends Controller
{
    public function index(){
        $getAlumnos = new getAllDependIfAuthUserIsAdminOrNot;
        return view('alumnos/index',[
            'alumnos' => $getAlumnos->execute(),
        ]);
    }

    public function create(CategoriaRepository $categoriaRepository,ClubRepository $clubRepository){
        return view('alumnos/create',[
            'categorias' => $categoriaRepository->getAllCategoriasOrderByNombreCategoriaListForSelectInput(),
            'clubs' => $clubRepository->getAllClubListForSelectInput(),
        ]);
    }

    public function edit(Alumno $alumno,CategoriaRepository $categoriaRepository,ClubRepository $clubRepository){
        return view('alumnos/edit',[
            'alumno' => $alumno,
            'categorias' => $categoriaRepository->getAllCategoriasOrderByNombreCategoriaListForSelectInput(),
            'clubs' => $clubRepository->getAllClubListForSelectInput(),
        ]);
    }

    public function update(UpdateAlumnoRequest $request ,Alumno $alumno){
        $alumno->update( $request->except(['_method','_token']));
        return back()->with('message','El alumno se editó correctamente');
    }

    public function store(AddAlumnoRequest $request){
        $creater = new Creater;
        $creater->execute($request);
        return back()->with('success','El alumno se registro con exito');
    }

    public function destroy($id){
        Alumno::find($id)->delete();
        return back()->with('success','El alumno se eliminó con exito');
    }
    
    function import(ImportExcelRequest $request)
    {
     //? probar en casa
    Excel::import(new AlumnosImport,request()->file('select_file'));

     return back()->with('success', 'Excel Data Imported successfully.');
    }
}

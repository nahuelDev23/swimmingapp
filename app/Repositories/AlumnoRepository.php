<?php
namespace App\Repositories;
use App\Models\Alumno;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class AlumnoRepository
{
    public function create($request) :void
    {
        $alumno = new Alumno();
        $alumno->nombre = $request->nombre;
        $alumno->apellido = $request->apellido;
        $alumno->categoria_id = $request->categoria_id;
        $alumno->sexo = $request->sexo;
        $alumno->dni = $request->dni;
        $alumno->fecha_nacimiento = $request->fecha_nacimiento;
        $alumno->club_id = Auth::user()->is_admin == 1 ? $request->club_id : Auth::user()->club_id;
        
        $alumno->save();

    }

    public function getAllAlumnosDependIfAuthUserIsAdminOrNot() : Collection
    {
        if(Auth::user()->is_admin == 1){
            return Alumno::all();
        }else {
            return Alumno::where('club_id',Auth::user()->club_id)->get();
        }
    }
}
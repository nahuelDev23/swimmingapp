<?php
namespace App\Repositories;
use App\Models\Alumno;
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
}
<?php

namespace App\Repositories\UsesCase\Alumno;
use App\Models\Alumno;
use Illuminate\Support\Facades\Auth;
class Create
{

    public function execute($request)
    {
        return $this->create($request);
    }
  
    public function create($request)
    {
        $alumno = new Alumno();
        $alumno->nombre = $request->nombre;
        $alumno->apellido = $request->apellido;
        $alumno->categoria_id = $request->categoria_id;
        $alumno->sexo = $request->sexo;
        $alumno->dni = $request->dni;
        $alumno->fecha_nacimiento = $request->fecha_nacimiento;
        $alumno->club_id = Auth::user()->is_admin == 1 ? $request->club_id : Auth::user()->club_id;
        
        return $alumno->save();
    }
}

<?php

namespace App\Repositories\UsesCase\Alumno;
use App\Models\Alumno;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class getAllAlumnosDependIfAuthUserIsAdminOrNot
{

    public function execute()
    {
        return $this->getAllAlumnosDependIfAuthUserIsAdminOrNot();
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

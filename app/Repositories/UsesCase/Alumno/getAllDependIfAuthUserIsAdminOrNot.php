<?php
namespace App\Repositories\UsesCase\Alumno;
use Illuminate\Support\Facades\Auth;
use App\Models\Alumno;
use Illuminate\Database\Eloquent\Collection;

class getAllDependIfAuthUserIsAdminOrNot 
{

    public function execute()
    {
        return $this->getAllDependIfAuthUserIsAdminOrNot();
    }
    
    public function getAllDependIfAuthUserIsAdminOrNot() : Collection
    {
        if(Auth::user()->is_admin == 1){
            return Alumno::all();
        }else {
            return Alumno::where('club_id',Auth::user()->club_id)->get();
        }
    }
}
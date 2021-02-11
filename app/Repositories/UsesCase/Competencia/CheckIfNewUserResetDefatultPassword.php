<?php
namespace App\Repositories\UsesCase\Competencia;

use Illuminate\Support\Facades\Auth;
use App\Models\Competencia;
 
class CheckIfNewUserResetDefatultPassword 
{  
   
    public function execute()
    {
        return $this->CheckIfNewUserResetDefatultPassword();
    }

    public function CheckIfNewUserResetDefatultPassword()
    {
        if ((Auth::user()->password_changed_at == null)) {
            return view('users/reset-password');
         }
         else{
            return view('dashboard', [
                'competencias' => Competencia::select('id', 'nombre_competencia', 'detalle', 'fecha_competencia')->get(),
            ]);
         }
    }
}
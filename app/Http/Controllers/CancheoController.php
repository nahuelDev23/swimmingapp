<?php

namespace App\Http\Controllers;

use App\Models\Cancheo;
use Illuminate\Http\Request;

class CancheoController extends Controller
{
    public function edit(Cancheo $cancheo){
        return view('cancheos/edit',[
            'cancheo_id'=>$cancheo->id,
            'tiempo' =>  $cancheo->tiempo,
        ]);
    }

    public function update(Request $request ,Cancheo $cancheo){
        $cancheo->tiempo = $request->tiempo;
        $cancheo->update();
        return back()->with('success','el tiempo se agrego correctamente');
    }
}

<?php
namespace App\Repositories;
use App\Models\InscripcionPrueba;
class InscripcionPruebaRepository
{
    public function validate_conditions_init($request)
    {
       
        if($this->check_if_alumno_exist_in_competidor($request)){
            return $this->create($request);
        }else{
            return back()->with('message','el alumno ya existe');
        }
    }

    public function check_if_alumno_exist_in_competidor ($request): bool
    {
        $response = InscripcionPrueba::where('competencia_id',$request->competencia_id)
        ->where('competidor_id', $request->competidor_id)
        ->where('prueba_id', $request->prueba_id)
        ->first();

       return $response ? false : true;
      
    }
    
    public function create($request)
    {
        $competidor = new InscripcionPrueba;
        $competidor->competencia_id = $request->competencia_id;
        $competidor->competidor_id = $request->competidor_id;
        $competidor->prueba_id = $request->prueba_id;
        $competidor->save();
       return  back()->with('message','el alumno se registro en la prueba correctamente');
    }
}
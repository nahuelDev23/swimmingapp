<?php

namespace App\Repositories;

use App\Models\InscripcionPrueba;
use App\Models\Competidor;
use App\Models\Prueba;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;

class InscripcionPruebaRepository
{
    private $inscripcionPrueba;
    private $competidor;
    private $prueba;

    public function __construct(InscripcionPrueba  $inscripcionPrueba,Competidor $competidor,Prueba $prueba)
    {
        $this->inscripcionPrueba = $inscripcionPrueba;
        $this->competidor = $competidor;
        $this->prueba = $prueba;
    }
    public function validate_conditions_init($request): RedirectResponse
    {
        if (!$this->check_if_alumno_exist_in_inscripcion_prueba($request)) {
            return back()->with('message', 'el alumno ya existe');
        }

        if (!$this->validate_alumno_category($request->competidor_id, $request->prueba_id)) {
            return back()->with('message', 'El alumno que estás intentando anotar no es de la misma categoria que requiere la prueba!!');
        }

        if(!$this->check_if_alumno_have_time_register_for_the_prueba($request->competidor_id,$request->prueba_id)){
            return back()->with('message','El alumno que estás intentando anotar no tiene  tiempo registrado para la prueba');
        }

        if(!$this->validate_alumno_sexo_in_prueba($request->competidor_id,$request->prueba_id)){
           return  back()->with('message','El alumno que estás intentando anotar no es del  mismo sexo que requiere la prueba');
        }
        return $this->create($request);
    }

    public function check_if_alumno_have_time_register_for_the_prueba($competidor_id,$prueba_id): bool
    {
        $checker_prueba_competidor = Competidor::where('id',$competidor_id)->select('prueba_id')->first();

        if($checker_prueba_competidor->prueba_id != $prueba_id){
            return false;
        }
        return true;
    }

    public function check_if_alumno_exist_in_inscripcion_prueba($request): bool
    {
        $response = $this->inscripcionPrueba->whereCompetenciaAndTiempoAndPrueba($request);
        return $response ? false : true;
    }

    public function validate_alumno_category($competidor_id, $prueba_id): bool
    {
        $alumno_category = $this->competidor->getCategoryIdOfAlumnoInTableCompetidors($competidor_id)->categoria_id;

        $prueba_category = $this->prueba->getCategoryIdOfPrueba($prueba_id)->categoria_id;
        
        if ($alumno_category != $prueba_category) {
            return false;
        }

        return true;
    }

    public function validate_alumno_sexo_in_prueba(int $competido_id,int $prueba_id): bool
    {
        $sexo = '';
       
        $alumno_sexo = $this->competidor->getAlumnoSexoInTableCompetidors($competido_id)->sexo;
        $prueba_sexo = $this->prueba->getSexoPrueba($prueba_id)->sexo;
        
        if ($prueba_sexo == 'VARONES') {
            $sexo = 'M';
        } else if ($prueba_sexo == 'MUJERES') {
            $sexo = 'F';
        } else {
            $sexo = '';
        };

        if($sexo != $alumno_sexo && strlen($sexo) != 0){
            return false;
        }
        return true;
    }
    public function create($request)
    {
        $competidor = new InscripcionPrueba;
        $competidor->competencia_id = $request->competencia_id;
        $competidor->competidor_id = $request->competidor_id;
        $competidor->prueba_id = $request->prueba_id;
        $competidor->save();
        return  back()->with('message', 'el alumno se registro en la prueba correctamente');
    }

    public function fill_competidor_select(int $competencia_id): Collection
    {
        return $this->competidor->ByIfIsAdminOrUserAllAlumnoWithTiempoAndPruebaRegister($competencia_id);
    }

    public function list_alumno_for_prueba(Collection $pruebas_de_la_competencia,int $competencia_id): Array
    {
        return $this->inscripcionPrueba->ByIfIsAdminOrUserListAlumnosByPrueba($pruebas_de_la_competencia, $competencia_id);
    }
}

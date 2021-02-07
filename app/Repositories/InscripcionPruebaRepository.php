<?php

namespace App\Repositories;

use App\Models\InscripcionPrueba;
use App\Models\Competidor;
use App\Models\Prueba;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
class InscripcionPruebaRepository
{
    private $inscripcionPrueba;
    private $competidor;

    public function __construct(InscripcionPrueba  $inscripcionPrueba,Competidor $competidor)
    {
        $this->inscripcionPrueba = $inscripcionPrueba;
        $this->competidor = $competidor;
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
        $checker_alumno_category = Competidor::join('alumnos', 'competidors.alumno_id', '=', 'alumnos.id')
            ->where('competidors.id', $competidor_id)
            ->select('alumnos.categoria_id')->first();

        $checker_prueba_category = Prueba::where('id', $prueba_id)->select('categoria_id')->first();

        if ($checker_alumno_category->categoria_id != $checker_prueba_category->categoria_id) {
            return false;
        }

        return true;
    }

    public function validate_alumno_sexo_in_prueba($competido_id,$prueba_id): bool
    {
        $sexo = '';
       
        $checker_alumno_sexo = Competidor::join('alumnos','competidors.alumno_id','=','alumnos.id')
        ->where('competidors.id',$competido_id)
        ->select('alumnos.sexo')
        ->first();

        $checker_prueba_sexo = Prueba::where('id',$prueba_id)->select('sexo')->first();
        
        if ($checker_prueba_sexo->sexo == 'VARONES') {
            $sexo = 'M';
        } else if ($checker_prueba_sexo->sexo == 'MUJERES') {
            $sexo = 'F';
        } else {
            $sexo = '';
        };

        if($sexo != $checker_alumno_sexo->sexo && strlen($sexo) != 0){
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
        return $this->competidor->ByIfIsAdminOrUser($competencia_id);
    }

    public function list_alumno_for_prueba(Collection $pruebas_de_la_competencia,int $competencia_id): Array
    {
        $lista_alumnos_inscriptos_por_prueba = [];
        if(Auth::user()->is_admin == 1){
        foreach($pruebas_de_la_competencia as $p){
            array_push($lista_alumnos_inscriptos_por_prueba, InscripcionPrueba::where('inscripcion_pruebas.competencia_id',$competencia_id)
            ->where('inscripcion_pruebas.prueba_id',$p->id)
            ->join('competidors','inscripcion_pruebas.competidor_id','=','competidors.id')
            ->join('alumnos','competidors.alumno_id','=','alumnos.id')
            ->get());
        }
        return $lista_alumnos_inscriptos_por_prueba;
    }else{
        foreach($pruebas_de_la_competencia as $p){
            array_push($lista_alumnos_inscriptos_por_prueba, InscripcionPrueba::where('inscripcion_pruebas.competencia_id',$competencia_id)
            ->where('inscripcion_pruebas.prueba_id',$p->id)
            ->join('competidors','inscripcion_pruebas.competidor_id','=','competidors.id')
            ->join('alumnos','competidors.alumno_id','=','alumnos.id')
            ->where('alumnos.club_id', Auth::user()->club->id)
            ->get());
        }
        return $lista_alumnos_inscriptos_por_prueba;
    }
    }
}

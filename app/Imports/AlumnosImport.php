<?php

namespace App\Imports;

use App\Models\Alumno;
use App\Models\Categoria;
use App\Models\Club;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;

class AlumnosImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array   $row)
    {
        // 
        // dd($row);
                $get_club_id = Club::select('id')->where('nombre_club',$row['club'])->get();
                $get_categoria_id = Categoria::select('id')->where('nombre_categoria',$row['categoria'])->get();
                $alumno = new Alumno();
                $alumno->nombre =  $row['nombre'];
                $alumno->apellido =  $row['apellido'];
                $alumno->categoria_id =  $get_categoria_id[0]->id;
                $alumno->club_id =   $get_club_id[0]->id;
                $alumno->sexo =  $row['sexo'];
                $alumno->dni =  $row['dni'];
                $alumno->fecha_nacimiento =  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha_nacimiento']);
                $alumno->save();
               
            
        }     
    
        public function rules(): array
    {
        return [
            'dni' => 'unique:alumnos',
        ];
    }

    public function customValidationMessages()
{
    return [
        'dni.unique' => 'Hay más de un alumno con el mismo dni, por favor revisar que no haya dni duplicado en el excel',
    ];
}
}

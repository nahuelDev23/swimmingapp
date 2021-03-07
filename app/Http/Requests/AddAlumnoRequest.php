<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddAlumnoRequest extends FormRequest
{
  
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|min:3|max:50|regex:/^[a-zA-Z]+$/u',
            'apellido' => 'required|min:3|max:50|regex:/^[a-zA-Z]+$/u',
            'categoria_id' => 'required|max:2|numeric',
            'sexo' => 'required|max:1|regex:/^[a-zA-Z]+$/u',
            'dni' => 'required|unique:alumnos,dni|min:10|max:10|regex:/^[0-9.]+$/',
            'fecha_nacimiento' => 'required|min:10|max:10|regex:/^[0-9-]+$/',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddAlumnoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => 'required|min:3|max:50',
            'apellido' => 'required|min:3|max:50',
            'categoria_id' => 'required|max:3',
            'sexo' => 'required|max:1',
            'dni' => 'required|unique:alumnos,dni',
            'fecha_nacimiento' => 'required',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class addPruebaRequest extends FormRequest
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
            'nombre_prueba' => 'required|min:8|max:9',
            'distancia' => 'required|min:2|max:3',
            'estilo' => 'required',
            'sexo' => 'required',
            'categoria_id' => 'required',
            'competencia_id' => 'required',
        ];
    }
}

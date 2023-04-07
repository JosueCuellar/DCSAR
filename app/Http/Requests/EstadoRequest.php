<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstadoRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'codigo_estado'=>'required|max:20',
            'nombre_estado'=>'required|max:150',
            'descripcion_estado'=>'required|max:150',
        ];
    }
    public function messages()
    {
        return [
            'codigo_estado.*'=>'Ingrese un codigo, de no mas de 20 caracteres',
            'nombre_estado.*'=>'Ingrese un nombre, de no mas de 150 caracteres',
            'descripcion_estado.*'=>'Ingrese una descripcion, de no mas de 150 caracteres',

        ];
    }
}

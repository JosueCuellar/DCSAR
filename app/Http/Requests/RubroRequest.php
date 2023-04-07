<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RubroRequest extends FormRequest
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
            'codigo_presupuestario'=>'required|max:255',
            'descripcion_rubro'=>'required|max:255',
        ];
    }
    public function messages()
    {
        return [
            'codigo_presupuestario.*'=>'Ingrese un codigo, de no mas de 255 caracteres',
            'descripcion_rubro.*'=>'Ingrese una descripcion, de no mas de 255 caracteres',

        ];
    }

}

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
            'codigoPresupuestario'=>'required|max:255',
            'descripcionRubro'=>'required|max:255',
        ];
    }
    public function messages()
    {
        return [
            'codigoPresupuestario.*'=>'Ingrese un codigo, de no mas de 255 caracteres',
            'descripcionRubro.*'=>'Ingrese una descripcion, de no mas de 255 caracteres',

        ];
    }

}

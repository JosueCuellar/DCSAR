<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedidaRequest extends FormRequest
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
            'nombre_medida'=>'required|max:255',
        ];
    }
    public function messages()
    {
        return [
            'nombre_medida.*'=>'Ingrese un nombre, de no mas de 255 caracteres',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProveedorRequest extends FormRequest
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
            'nombreComercial'=>'required|max:100',
            'razonSocial' => 'required|max:250',
            'direccion' => 'required|max:150',
            'fax' => 'required|max:150',
            'telefono1' => 'required|max:15',
            'telefono2' => 'required|max:15',

        ];
    }
    public function messages()
    {
        return [
            'nombreComercial.*'=>'Ingrese un nombre comercial, de no mas de 100 caracteres',
            'razonSocial.*'=>'Ingrese una razon social, de no mas de 100 caracteres',
            'direccion.*'=>'Ingrese una direccion, de no mas de 100 caracteres',
            'fax.*'=>'Ingrese un fax, de no mas de 100 caracteres',
            'telefono1.*'=>'Ingrese un teléfono, de no mas de 100 caracteres',
            'telefono2.*'=>'Ingrese un télefono opc, de no mas de 100 caracteres',
        ];
    }
}

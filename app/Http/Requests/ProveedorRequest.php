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
            'nombre_comercial'=>'required|max:255',
            'razon_social' => 'required|max:255',
            'direccion_proveedor' => 'required|max:255',
            'fax' => 'required|max:150',
            'telefono1_proveedor' => 'required|max:15',
            'telefono2_proveedor' => 'max:15',

        ];
    }
    public function messages()
    {
        return [
            'nombre_comercial.*'=>'Ingrese un nombre comercial, de no más de 255 caracteres',
            'razon_social.*'=>'Ingrese una razon social, de no más de 255 caracteres',
            'direccion_proveedor.*'=>'Ingrese una direccion_proveedor, de no más de 255 caracteres',
            'fax.*'=>'Ingrese un fax, de no mas de 150 caracteres',
            'telefono1_proveedor.*'=>'Ingrese un teléfono, con el formato que se indica',
            'telefono2_proveedor.*'=>'Ingrese un télefono opcional, con el formato que se indica',
        ];
    }
}

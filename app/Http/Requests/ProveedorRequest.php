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
            'nombreComercial'=>'required|max:255',
            'razonSocial' => 'required|max:255',
            'direccionProveedor' => 'required|max:255',
            'fax' => 'required|max:150',
            'telefonoProveedor1' => 'required|max:15',
            'telefonoProveedor2' => 'max:15',

        ];
    }
    public function messages()
    {
        return [
            'nombreComercial.*'=>'Ingrese un nombre comercial, de no más de 255 caracteres',
            'razonSocial.*'=>'Ingrese una razon social, de no más de 255 caracteres',
            'direccionProveedor.*'=>'Ingrese una direccionProveedor, de no más de 255 caracteres',
            'fax.*'=>'Ingrese un fax, de no mas de 150 caracteres',
            'telefonoProveedor1.*'=>'Ingrese un teléfono, con el formato que se indica',
            'telefonoProveedor2.*'=>'Ingrese un télefono opcional, con el formato que se indica',
        ];
    }
}

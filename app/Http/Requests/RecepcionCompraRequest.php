<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecepcionCompraRequest extends FormRequest
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
            'proveedor_id'=>'required',
            'nOrdenCompra' => 'required|max:50',
            'nPresupuestario' => 'required|max:50',
            // 'nCompromiso' => 'required|max:250',
            'codigo_factura' => 'required|max:50',

        ];
    }
    public function messages()
    {
        return [
            'proveedor_id.*'=>'Debe de ingresar un proveedor',
            'nOrdenCompra.*'=>'Ingrese un numero de orden de compra, de no mas de 50 caracteres',
            'nPresupuestario.*'=>'Ingrese un numero presupuestario, de no mas de 50 caracteres',
            'codigo_factura.*'=>'Ingrese codigo de factura, de no mas de 50 caracteres',
        ];
    }
}
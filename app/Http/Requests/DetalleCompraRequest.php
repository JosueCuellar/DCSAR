<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetalleCompraRequest extends FormRequest
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
            'producto_id'=>'required',
            'cantidadIngreso'=>'required',
            'precioUnidad'=>'required',
            'fechaVenc'=>'required',
            
        ];
    }
    public function messages()
    {
        return [
            'producto_id.*'=>'Campo requerido',
            'cantidadIngreso.*'=>'Campo requerido, tipo entero, maximo 10000',
            'precioUnidad.*'=>'Campo requerido, minimo 0.01, máximo 10,000',
            'fechaVenc.*'=>'Campo requerido',
            
        ];
    }
}

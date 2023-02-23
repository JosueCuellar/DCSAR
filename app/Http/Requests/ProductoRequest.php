<?php

namespace App\Http\Requests;

use App\Rules\JfifNotAllowed;
use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
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

            'cod_producto'=>'required|max:100',
            'descripcion'=>'required|max:100',
            'observacion'=>'required|max:100',
            'imagen' => ['required', new JfifNotAllowed],
            'marca_id'=>'required',
            'medida_id'=>'required',
            'rubro_id'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'cod_producto.*'=>'Ingrese codigo de producto',
            'descripcion.*'=>'Ingrese una descripcion',
            'observacion.*'=>'Ingrese una observacion',
            'imagen.*'=>'Ingrese una imagen (Formato: PNG, JPG, JPEG)',
            'marca_id.*'=>'Ingrese una marca',
            'medida_id.*'=>'Ingrese una medida',
            'rubro_id.*'=>'Ingrese un rubro',
        ];
    }
}

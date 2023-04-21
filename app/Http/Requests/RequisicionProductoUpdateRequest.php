<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequisicionProductoUpdateRequest extends FormRequest
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
            'fechaRequisicion'=>'required',
            'descripcion'=>'required|max:512',
        ];
    }
    public function messages()
    {
        return [
            'descripcion.*'=>'Ingrese una descripcion, de no mas de 512 caracteres',
            'fechaRequisicion.*'=>'La fecha no puede estar vacia',


        ];
    }
}

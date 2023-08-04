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
			'nombreMedida' => 'required|min:4|max:25',
		];
	}

	public function messages()
	{
		return [
			'nombreMedida.required' => 'Ingrese un nombre',
			'nombreMedida.min' => 'El nombre debe tener al menos 4 caracteres',
			'nombreMedida.max' => 'El nombre no debe tener más de 25 caracteres',
		];
	}
}

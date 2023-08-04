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
			'codigoPresupuestario' => 'required|string|min:5|max:6',
			'descripRubro' => 'required|max:60',
		];
	}

	public function messages()
	{
		return [
			'codigoPresupuestario.required' => 'Ingrese un código presupuestario',
			'codigoPresupuestario.numeric' => 'El código presupuestario solo debe contener números',
			'codigoPresupuestario.min' => 'El código presupuestario debe tener al menos 5 caracteres',
			'codigoPresupuestario.max' => 'El código presupuestario no debe tener más de 6 caracteres',
			'descripRubro.required' => 'Ingrese una descripción del rubro',
			'descripRubro.max' => 'La descripción del rubro no debe tener más de 60 caracteres',
		];
	}
}

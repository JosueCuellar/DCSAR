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
			'nombreMedida' => 'required|regex:/^[a-zA-Z\s]*$/|min:5|max:20',
		];
	}

	public function messages()
	{
		return [
			'nombreMedida.required' => 'Ingrese un nombre',
			'nombreMedida.regex' => 'El nombre solo debe contener letras y espacios',
			'nombreMedida.min' => 'El nombre debe tener al menos 5 caracteres',
			'nombreMedida.max' => 'El nombre no debe tener más de 20 caracteres',
		];
	}
}

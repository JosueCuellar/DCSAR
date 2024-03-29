<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarcaRequest extends FormRequest
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
			'nombre' => 'required|max:25|regex:/^[a-zA-Z\sñáéíóúÁÉÍÓÚ]+$/'
		];
	}

	public function messages()
	{
		return [
			'nombre.required' => 'Ingrese un nombre',
			'nombre.max' => 'El nombre no debe tener más de 25 caracteres',
			'nombre.regex' => 'El nombre solo debe contener letras y espacios',
		];
	}
}

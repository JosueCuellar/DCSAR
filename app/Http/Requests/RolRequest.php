<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RolRequest extends FormRequest
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
			'name' => 'required|string|min:5|max:50',
		];
	}

	public function messages()
	{
		return [
			'name.required' => 'Ingrese el nombre de un rol, no puede dejarlo vacio',
			'name.max' => 'El nombre no debe de tener mas de 50 caracteres',
			'name.min' => 'El nombre no debe tener menos de 5 caracteres',
		];
	}
}

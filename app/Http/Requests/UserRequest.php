<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
		$rules = [
			'name' => 'required|string|max:255',
			'email' => 'required|string|email|max:255',
			'role' => 'required|exists:roles,name',
		];

		if ($this->isMethod('post')) {
			// If creating a new user, the password is required and must be confirmed
			$rules['password'] = 'required|string|min:8|confirmed';
		} else {
			// If updating an existing user, the password is optional but must be confirmed if present
			$rules['password'] = 'nullable|string|min:8|confirmed';
		}

		return $rules;
	}



	public function messages()
	{
		return [
			'name.*' => 'Ingrese un nombre, de no mas de 255 caracteres',
			'email.*' => 'Ingrese un email, de no mas de 255 caracteres',
			'password.*' => 'Contraseña incorrecta',
			'role.required' => 'El campo rol es obligatorio',
			'role.exists' => 'El rol seleccionado no es válido',
		];
	}
}

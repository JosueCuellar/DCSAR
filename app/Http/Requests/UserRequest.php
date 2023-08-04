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
			'name' => 'required|string|max:60|min:10',
			'email' => 'required|string|email|max:100',
			'role' => 'required|exists:roles,name',
			'unidad_organizativa_id' => 'required',
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
			'name.required' => 'Ingrese un nombre',
			'name.min' => 'Ingrese un nombre, de al menos 10 caracteres',
			'name.max' => 'Ingrese un nombre, de no mas de 60 caracteres',
			'email.required' => 'Ingrese un email',
			'email.max' => 'Ingrese un email, de no mas de 100 caracteres',
			'password.*' => 'Contraseña incorrecta',
			'role.required' => 'El campo rol es obligatorio',
			'unidad_organizativa_id.required' => 'Debe de seleccionar una unidad organizativa',
			'role.exists' => 'El rol seleccionado no es válido',
		];
	}
}

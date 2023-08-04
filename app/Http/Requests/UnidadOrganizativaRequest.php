<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnidadOrganizativaRequest extends FormRequest
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
			'nombreUnidadOrganizativa' => 'required|max:50',
			'descripUnidadOrganizativa' => 'required|max:100',
		];
	}
	public function messages()
	{
		return [
			'nombreUnidadOrganizativa.*' => 'Ingrese un nombre, de no mas de 50 caracteres',
			'descripUnidadOrganizativa.*' => 'Ingrese una descripcion, de no mas de 100caracteres',
		];
	}
}

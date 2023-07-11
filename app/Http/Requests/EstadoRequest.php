<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstadoRequest extends FormRequest
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
			'codigoEstado' => 'required|max:20',
			'nombreEstado' => 'required|max:150',
			'descripcionEstado' => 'required|max:150',
		];
	}
	public function messages()
	{
		return [
			'codigoEstado.*' => 'Ingrese un codigo, de no mas de 20 caracteres',
			'nombreEstado.*' => 'Ingrese un nombre, de no mas de 150 caracteres',
			'descripcionEstado.*' => 'Ingrese una descripcion, de no mas de 150 caracteres',

		];
	}
}

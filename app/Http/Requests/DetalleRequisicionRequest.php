<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetalleRequisicionRequest extends FormRequest
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
			'cantidadAdd' => 'required|integer|min:1',

		];
	}
	public function messages()
	{
		return [
			'cantidadAdd.*' => 'Campo requerido,  debe de ser mayor a 0',
		];
	}
}

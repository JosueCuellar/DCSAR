<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class RequisicionProductoUpdateRequest extends FormRequest
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
		Validator::extend('not_only_numbers', function ($attribute, $value, $parameters, $validator) {
			return !preg_match('/^[0-9\s]*$/', $value);
		});

		return [
			'fechaRequisicion' => 'required',
			'descripcion' => 'required|max:255|not_only_numbers',
		];
	}
	public function messages()
	{
		return [
			'descripcion.required' => 'Ingrese una descripcion, de no mas de 255 caracteres',
			'descripcion.not_only_numbers' => 'No puede contener solo numeros',
			'descripcion.max' => 'Ingrese una descripcion de no mas de 255 caracteres',
			'fechaRequisicion.required' => 'La fecha no puede estar vacia',
		];
	}
}

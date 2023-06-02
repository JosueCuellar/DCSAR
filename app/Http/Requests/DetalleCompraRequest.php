<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DetalleCompraRequest extends FormRequest
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
			'producto_id' => 'required',
			'cantidadIngreso' => 'required|integer|max:10000',
			'precioUnidad' => [
					'required',
					Rule::notIn([0]),
					function ($attribute, $value, $fail) {
							if (preg_match('/^\d+(\.\d{1,2})?$/', $value) !== 1) {
									$fail('Debe tener como máximo 2 decimales');
							}
					},
			],
	];
	}
	public function messages()
	{
		return [
			'producto_id.required' => 'El campo producto es requerido',
			'cantidadIngreso.required' => 'El campo cantidad de ingreso es requerido',
			'cantidadIngreso.integer' => 'El campo cantidad de ingreso debe ser un número entero',
			'cantidadIngreso.max' => 'El campo cantidad de ingreso no debe ser mayor a 10000',
			'precioUnidad.required' => 'El campo precio por unidad es requerido',
		];
	}
}

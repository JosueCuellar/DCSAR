<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReporteMensualesRequest extends FormRequest
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
			'reportType' => 'required',
			'fechaInput' => 'required|date|before_or_equal:' . now()->endOfMonth(),
		];
	}

	public function messages()
	{
		return [
			'reportType.required' => 'El tipo de reporte es requerido.',
			'fechaInput.required' => 'La fecha es requerida.',
			'fechaInput.date' => 'La fecha ingresada debe ser una fecha válida.',
			'fechaInput.before_or_equal' => 'La fecha ingresada debe ser igual o anterior al final del mes actual.',
		];
	}
}

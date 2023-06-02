<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProveedorRequest extends FormRequest
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
			'nombreComercial' => 'required|max:255',
			'razonSocial' => 'required|max:255',
			'direccionProveedor' => 'required|max:255',
			'fax' => 'nullable|max:15',
			'telefonoProveedor1' => [
				'required',
				'max:15',
				function ($attribute, $value, $fail) {
						if (!preg_match('/^\(\d{3}\) \d{4}-\d{4}$/', $value)) {
								$fail('El teléfono debe tener el formato (999) 9999-9999');
						}
				},
		],
		'telefonoProveedor2' => [
			'nullable',
			'max:15',
			function ($attribute, $value, $fail) {
					if ($value !== null && !preg_match('/^\(\d{3}\) \d{4}-\d{4}$/', $value)) {
							$fail('El teléfono opcional debe tener el formato (999) 9999-9999');
					}
			},
	],
		];
	}

	public function messages()
	{
		return [
			'nombreComercial.required' => 'Ingrese un nombre comercial',
			'nombreComercial.max' => 'El nombre comercial no debe tener más de 255 caracteres',
			'razonSocial.required' => 'Ingrese una razón social',
			'razonSocial.max' => 'La razón social no debe tener más de 255 caracteres',
			'direccionProveedor.required' => 'Ingrese una dirección del proveedor',
			'direccionProveedor.max' => 'La dirección del proveedor no debe tener más de 255 caracteres',
			'fax.numeric' => 'El fax solo debe contener números',
			'fax.max' => 'El fax no debe tener más de 15 caracteres',
			'telefonoProveedor1.required' => 'Ingrese un teléfono',
			'telefonoProveedor1.max' => 'El teléfono no debe tener más de 15 caracteres',
			'telefonoProveedor2.max' => 'El teléfono opcional no debe tener más de 15 caracteres',
		];
	}
}

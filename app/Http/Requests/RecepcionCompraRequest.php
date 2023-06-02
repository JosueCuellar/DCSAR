<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecepcionCompraRequest extends FormRequest
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
			'proveedor_id' => 'required',
			'nOrdenCompra' => 'required|max:50|regex:/^[0-9\/]+$/',
			'nPresupuestario' => 'required|max:50',
			'codigoFactura' => 'required|max:50',
			'fecha' => 'before_or_equal:today'
		];
	}

	public function messages()
	{
		return [
			'proveedor_id.required' => 'Debe de ingresar un proveedor',
			'nOrdenCompra.required' => 'Ingrese un numero de orden de compra',
			'nOrdenCompra.max' => 'El numero de orden de compra no debe tener mas de 50 caracteres',
			'nOrdenCompra.regex' => 'El numero de orden de compra solo debe contener numeros y el caracter /',
			'nPresupuestario.required' => 'Ingrese un numero presupuestario',
			'nPresupuestario.max' => 'El numero presupuestario no debe tener mas de 50 caracteres',
			'codigoFactura.required' => 'Ingrese codigo de factura',
			'codigoFactura.max' => 'El codigo de factura no debe tener mas de 50 caracteres',
			'fecha.before_or_equal' => 'La fecha debe ser igual o anterior a la fecha actual'
		];
	}
}

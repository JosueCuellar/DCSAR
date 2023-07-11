<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
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
			'codProductoCon' => 'required',
			'descripcion' => 'required|max:255',
			'perecedero' => 'required|boolean',
			'observacion' => 'max:255',
			'imagen' => ['mimes:png,jpg,jpeg|exclude_if:imagen,*.webp|exclude_if:imagen,*.jfif'],
			'marca_id' => 'required',
			'medida_id' => 'required',
			'rubro_id' => 'required',
		];
		if ($this->isMethod('POST')) {
			$rules['imagen'][] = 'required';
		}
		return $rules;
	}
	public function messages()
	{
		return [
			'codProductoCon.required' => 'El código del producto es obligatorio.',
			'descripcion.required' => 'La descripción es obligatoria.',
			'descripcion.max' => 'La descripción no puede tener más de 255 caracteres.',
			'perecedero.required' => 'El campo perecedero es obligatorio.',
			'perecedero.boolean' => 'El campo perecedero debe ser verdadero o falso.',
			'observacion.max' => 'La observación no puede tener más de 255 caracteres.',
			'imagen.required' => 'La imagen es obligatoria.',
			'imagen.mimes' => 'La imagen debe ser de tipo png, jpg o jpeg.',
			'marca_id.required' => 'La marca es obligatoria.',
			'medida_id.required' => 'La medida es obligatoria.',
			'rubro_id.required' => 'El rubro es obligatorio.',
		];
	}
}

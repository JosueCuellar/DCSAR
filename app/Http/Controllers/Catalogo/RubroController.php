<?php

namespace App\Http\Controllers\Catalogo;

use App\Http\Controllers\Controller;
use App\Http\Requests\RubroRequest;
use App\Models\Rubro;

class RubroController extends Controller
{
	/**
	 * Muestra la vista del índice de rubros, trae un listado de todos los registros de la base de datos y los envía a la vista.
	 *
	 * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
	 */
	public function index()
	{
		try {
			// Obtiene un listado de todos los registros de rubros
			$rubros = Rubro::all();

			// Retorna la vista del índice de rubros junto con los datos necesarios
			return view('catalogo.rubro.index', compact('rubros'));
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error: ' . $e->getMessage());
		}
	}

	/**
	 * Muestra la vista de creación de un nuevo rubro.
	 *
	 * @return \Illuminate\Contracts\View\View
	 */
	public function create()
	{
		return view('catalogo.rubro.create');
	}

	/**
	 * Almacena un nuevo registro de rubro en la base de datos, utilizando la clase RubroRequest para validación.
	 *
	 * @param  \App\Http\Requests\RubroRequest  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(RubroRequest $request)
	{
		try {
			// Crea y almacena un nuevo objeto de rubro con los datos del formulario
			$rubro = new Rubro();
			$rubro->codigoPresupuestario = $request->codigoPresupuestario;
			$rubro->descripRubro = $request->descripRubro;
			$rubro->save();

			// Redirige al listado de todos los registros de rubros con mensaje de éxito
			return redirect()->route('rubro.index')->with('status', 'Rubro agregado');
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Error no se puede registrar: ' . $e->getMessage());
		}
	}

	/**
	 * Muestra la vista de edición de un registro de rubro almacenado en la base de datos.
	 *
	 * @param  \App\Models\Rubro  $rubro
	 * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
	 */
	public function edit(Rubro $rubro)
	{
		try {
			// Muestra la vista de edición junto con los detalles del rubro a editar
			return view('catalogo.rubro.edit', compact('rubro'));
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Error no se puede actualizar: ' . $e->getMessage());
		}
	}

	/**
	 * Actualiza un registro de rubro en la base de datos, utilizando la clase RubroRequest para validación.
	 *
	 * @param  \App\Http\Requests\RubroRequest  $request
	 * @param  \App\Models\Rubro  $rubro
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(RubroRequest $request, Rubro $rubro)
	{
		try {
			// Actualiza los datos del rubro con los valores del formulario
			$rubro->codigoPresupuestario = $request->codigoPresupuestario;
			$rubro->descripRubro = $request->descripRubro;
			$rubro->save();

			// Redirige al listado de todos los registros de rubros con mensaje de éxito
			return redirect()->route('rubro.index')->with('status', 'Rubro actualizado');
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Error no se puede actualizar: ' . $e->getMessage());
		}
	}

	/**
	 * Elimina un registro de rubro de la base de datos.
	 *
	 * @param  \App\Models\Rubro  $rubro
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy(Rubro $rubro)
	{
		try {
			// Elimina el registro de rubro de la base de datos
			$rubro->delete();

			// Redirige al listado de todos los registros de rubros con mensaje de éxito
			return redirect()->route('rubro.index')->with('delete', 'Rubro eliminado');
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'El registro no se puede eliminar, otra tabla lo utiliza: ' . $e->getMessage());
		}
	}
}

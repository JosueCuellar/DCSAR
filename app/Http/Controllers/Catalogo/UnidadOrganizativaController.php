<?php

namespace App\Http\Controllers\Catalogo;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnidadOrganizativaRequest;
use App\Models\UnidadOrganizativa;

class UnidadOrganizativaController extends Controller
{
	/**
	 * Muestra el listado de todos los registros de unidades organizativas en la base de datos y los envía a la vista del índice.
	 *
	 * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
	 */
	public function index()
	{
		try {
			// Obtiene todos los registros de unidades organizativas
			$unidades = UnidadOrganizativa::all();

			// Muestra la vista del índice junto con el listado de unidades organizativas
			return view('catalogo.unidadOrganizativa.index', compact('unidades'));
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error: ' . $e->getMessage());
		}
	}

	/**
	 * Almacena un nuevo registro de unidad organizativa en la base de datos, utilizando la clase UnidadOrganizativaRequest para validación.
	 *
	 * @param  \App\Http\Requests\UnidadOrganizativaRequest  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(UnidadOrganizativaRequest $request)
	{
		try {
			// Crea y almacena un nuevo objeto de unidad organizativa
			$unidad = new UnidadOrganizativa();
			$unidad->nombreUnidadOrganizativa = $request->nombreUnidadOrganizativa;
			$unidad->descripUnidadOrganizativa = $request->descripUnidadOrganizativa;
			$unidad->save();

			// Redirige al listado de todos los registros de unidades organizativas con mensaje de éxito
			return redirect()->route('unidadOrganizativa.index')->with('status', 'Unidad organizativa agregada');
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Error no se puede registrar: ' . $e->getMessage());
		}
	}

	/**
	 * Muestra la vista de edición para un registro de unidad organizativa almacenado en la base de datos.
	 *
	 * @param  \App\Models\UnidadOrganizativa  $unidadOrganizativa
	 * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
	 */
	public function edit(UnidadOrganizativa $unidadOrganizativa)
	{
		try {
			// Muestra la vista de edición junto con los datos del registro de unidad organizativa
			return view('catalogo.unidadOrganizativa.edit', compact('unidadOrganizativa'));
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error: ' . $e->getMessage());
		}
	}

	/**
	 * Actualiza un registro de unidad organizativa en la base de datos.
	 *
	 * @param  \App\Http\Requests\UnidadOrganizativaRequest  $request
	 * @param  \App\Models\UnidadOrganizativa  $unidadOrganizativa
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(UnidadOrganizativaRequest $request, UnidadOrganizativa $unidadOrganizativa)
	{
		try {
			// Actualiza los campos del registro de unidad organizativa con los valores del formulario
			$unidadOrganizativa->nombreUnidadOrganizativa = $request->nombreUnidadOrganizativa;
			$unidadOrganizativa->descripUnidadOrganizativa = $request->descripUnidadOrganizativa;
			$unidadOrganizativa->save();

			// Redirige al listado de todos los registros con un mensaje de éxito
			return redirect()->route('unidadOrganizativa.index')->with('status', 'Unidad organizativa actualizada');
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Error no se puede actualizar: ' . $e->getMessage());
		}
	}

	/**
	 * Elimina un registro de unidad organizativa de la base de datos.
	 *
	 * @param  \App\Models\UnidadOrganizativa  $unidadOrganizativa
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy(UnidadOrganizativa $unidadOrganizativa)
	{
		try {
			// Elimina el registro de unidad organizativa
			$unidadOrganizativa->delete();

			// Redirige al listado de todos los registros con un mensaje de éxito
			return redirect()->route('unidadOrganizativa.index')->with('delete', 'Unidad organizativa eliminada');
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'El registro no se puede eliminar, otra tabla lo utiliza: ' . $e->getMessage());
		}
	}
}

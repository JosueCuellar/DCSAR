<?php

namespace App\Http\Controllers\Catalogo;

use App\Http\Controllers\Controller;
use App\Http\Requests\MarcaRequest;
use App\Models\Marca;

class MarcaController extends Controller
{

	/**
	 * Muestra una lista de todos los registros de marcas almacenados en la base de datos y los envía a la vista del índice.
	 *
	 * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
	 */
	public function index()
	{
		try {
			// Obtiene todos los registros de marcas de la base de datos
			$marcas = Marca::all();

			// Retorna la vista del índice de marcas junto con la lista de marcas
			return view('catalogo.marca.index', compact('marcas'));
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error: ' . $e->getMessage());
		}
	}

	/**
	 * Crea y almacena un nuevo registro de marca dentro de la base de datos.
	 *
	 * @param  \App\Http\Requests\MarcaRequest  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(MarcaRequest $request)
	{
		try {
			// Crea un nuevo objeto Marca y asigna los valores desde el formulario
			$marca = new Marca();
			$marca->nombre = $request->nombre;
			$marca->save();

			// Redirige al listado de todos los registros de marcas
			return redirect()->route('marca.index')->with('status', 'Marca agregada');
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Error, no se puede registrar: ' . $e->getMessage());
		}
	}

	/**
	 * Muestra la vista de edición para un registro de marca existente.
	 *
	 * @param  \App\Models\Marca  $marca
	 * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
	 */
	public function edit(Marca $marca)
	{
		try {
			// Retorna la vista de edición con los detalles de la marca a editar
			return view('catalogo.marca.edit', compact('marca'));
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Error, no se puede actualizar: ' . $e->getMessage());
		}
	}

	/**
	 * Actualiza los detalles de un registro de marca existente en la base de datos.
	 *
	 * @param  \App\Http\Requests\MarcaRequest  $request
	 * @param  \App\Models\Marca  $marca
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(MarcaRequest $request, Marca $marca)
	{
		try {
			// Actualiza los valores de la marca con los datos proporcionados en el formulario
			$marca->nombre = $request->nombre;
			$marca->save();

			// Redirige al listado de todos los registros de marcas con mensaje de éxito
			return redirect()->route('marca.index')->with('status', 'Marca actualizada');
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Error, no se puede actualizar: ' . $e->getMessage());
		}
	}

	/**
	 * Elimina un registro de marca de la base de datos.
	 *
	 * @param  \App\Models\Marca  $marca
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy(Marca $marca)
	{
		try {
			// Elimina el registro de marca de la base de datos
			$marca->delete();

			// Redirige al listado de todos los registros de marcas con mensaje de éxito
			return redirect()->route('marca.index')->with('delete', 'Marca eliminada');
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error de eliminación
			return redirect()->back()->with('catch', 'El registro no se puede eliminar, otra tabla lo utiliza: ' . $e->getMessage());
		}
	}
}

<?php

namespace App\Http\Controllers\Catalogo;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedidaRequest;
use App\Models\Medida;

class MedidaController extends Controller
{

	/**
	 * Muestra una lista de todos los registros de medidas almacenados en la base de datos y los envía a la vista del índice.
	 *
	 * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
	 */
	public function index()
	{
		try {
			// Obtiene todos los registros de medidas de la base de datos
			$medidas = Medida::all();

			// Retorna la vista del índice de medidas junto con la lista de medidas
			return view('catalogo.medida.index', compact('medidas'));
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error: ' . $e->getMessage());
		}
	}

	/**
	 * Crea y almacena un nuevo registro de medida dentro de la base de datos.
	 *
	 * @param  \App\Http\Requests\MedidaRequest  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(MedidaRequest $request)
	{
		try {
			// Crea un nuevo objeto Medida y asigna los valores desde el formulario
			$medida = new Medida();
			$medida->nombreMedida = $request->nombreMedida;
			$medida->save();

			// Redirige al listado de todos los registros de medidas
			return redirect()->route('medida.index')->with('status', 'Medida agregada');
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Error, no se puede registrar: ' . $e->getMessage());
		}
	}

	/**
	 * Muestra la vista de edición para un registro de medida existente.
	 *
	 * @param  \App\Models\Medida  $medida
	 * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
	 */
	public function edit(Medida $medida)
	{
		try {
			// Retorna la vista de edición con los detalles de la medida a editar
			return view('catalogo.medida.edit', compact('medida'));
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Error: ' . $e->getMessage());
		}
	}

	/**
	 * Actualiza los detalles de un registro de medida existente en la base de datos.
	 *
	 * @param  \App\Http\Requests\MedidaRequest  $request
	 * @param  \App\Models\Medida  $medida
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(MedidaRequest $request, Medida $medida)
	{
		try {
			// Actualiza los valores de la medida con los datos proporcionados en el formulario
			$medida->nombreMedida = $request->nombreMedida;
			$medida->save();

			// Redirige al listado de todos los registros de medidas con mensaje de éxito
			return redirect()->route('medida.index')->with('status', 'Medida actualizada');
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Error, no se puede actualizar: ' . $e->getMessage());
		}
	}

	/**
	 * Elimina un registro de medida de la base de datos.
	 *
	 * @param  \App\Models\Medida  $medida
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy(Medida $medida)
	{
		try {
			// Elimina el registro de medida de la base de datos
			$medida->delete();

			// Redirige al listado de todos los registros de medidas con mensaje de éxito
			return redirect()->route('medida.index')->with('delete', 'Medida eliminada');
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error de eliminación
			return redirect()->back()->with('catch', 'El registro no se puede eliminar, otra tabla lo utiliza: ' . $e->getMessage());
		}
	}
}

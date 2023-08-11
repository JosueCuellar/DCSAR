<?php

namespace App\Http\Controllers\Catalogo;

use App\Http\Controllers\Controller;
use App\Http\Requests\EstadoRequest;
use App\Models\Estado;

class EstadoController extends Controller
{
	/**
	 * Muestra una lista de todos los estados almacenados en la base de datos y los envía a la vista del índice.
	 *
	 * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
	 */
	public function index()
	{
		try {
			// Obtiene todos los registros de estados de la base de datos
			$estados = Estado::all();
			// Retorna la vista del índice de estados junto con la lista de estados
			return view('catalogo.estado.index', compact('estados'));
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error: ' . $e->getMessage());
		}
	}


	/**
	 * Crea y almacena un nuevo estado dentro de la base de datos.
	 *
	 * @param  \App\Http\Requests\EstadoRequest  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(EstadoRequest $request)
	{
		try {
			// Crea un nuevo objeto Estado y asigna los valores desde el formulario
			$estado = new Estado();
			$estado->codigoEstado = $request->codigoEstado;
			$estado->nombreEstado = $request->nombreEstado;
			$estado->descripcionEstado = $request->descripcionEstado;
			$estado->save();

			// Redirige al listado de todos los registros de estados
			return redirect()->route('estado.index')->with('status', 'Estado agregado');
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Error, no se puede registrar: ' . $e->getMessage());
		}
	}


	/**
	 * Muestra la vista de edición para un registro de estado existente.
	 *
	 * @param  \App\Models\Estado  $estado
	 * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
	 */
	public function edit(Estado $estado)
	{
		try {
			// Retorna la vista de edición con los detalles del estado a editar
			return view('catalogo.estado.edit', compact('estado'));
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return $e->getMessage();
		}
	}


	/**
	 * Actualiza los detalles de un registro de estado existente en la base de datos.
	 *
	 * @param  \App\Http\Requests\EstadoRequest  $request
	 * @param  \App\Models\Estado  $estado
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(EstadoRequest $request, Estado $estado)
	{
		try {
			// Actualiza los valores del estado con los datos proporcionados en el formulario
			$estado->codigoEstado = $request->codigoEstado;
			$estado->nombreEstado = $request->nombreEstado;
			$estado->descripcionEstado = $request->descripcionEstado;
			$estado->save();

			// Redirige al listado de todos los registros de estados
			return redirect()->route('estado.index')->with('status', 'Estado actualizado');
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Error, no se puede actualizar: ' . $e->getMessage());
		}
	}


	/**
	 * Elimina un registro de estado de la base de datos.
	 *
	 * @param  \App\Models\Estado  $estado
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy(Estado $estado)
	{
		try {
			// Elimina el registro de estado de la base de datos
			$estado->delete();

			// Redirige al listado de todos los registros de estados con mensaje de éxito
			return redirect()->route('estado.index')->with('delete', 'Estado eliminado');
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error de eliminación
			return redirect()->back()->with('catch', 'El registro no se puede eliminar, otra tabla lo utiliza: ' . $e->getMessage());
		}
	}
}

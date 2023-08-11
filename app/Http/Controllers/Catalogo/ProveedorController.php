<?php

namespace App\Http\Controllers\Catalogo;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProveedorRequest;
use App\Models\Proveedor;

class ProveedorController extends Controller
{

	/**
	 * Muestra la vista del índice de proveedores, trae un listado de todos los registros de la base de datos y los envía a la vista.
	 *
	 * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
	 */
	public function index()
	{
		try {
			// Obtiene un listado de todos los registros de proveedores
			$proveedores = Proveedor::all();

			// Retorna la vista del índice de proveedores junto con los datos necesarios
			return view('catalogo.proveedor.index', compact('proveedores'));
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error: ' . $e->getMessage());
		}
	}

	/**
	 * Crea y almacena un nuevo registro de proveedor en la base de datos, utilizando la clase ProveedorRequest para validación.
	 *
	 * @param  \App\Http\Requests\ProveedorRequest  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(ProveedorRequest $request)
	{
		try {
			// Crea y almacena un nuevo objeto Proveedor con los datos del formulario
			$proveedor = new Proveedor();
			$proveedor->nombreComercial = $request->nombreComercial;
			$proveedor->razonSocial = $request->razonSocial;
			$proveedor->direccionProveedor = $request->direccionProveedor;
			$proveedor->fax = $request->fax;
			$proveedor->telefonoProveedor1 = $request->telefonoProveedor1;
			$proveedor->telefonoProveedor2 = $request->telefonoProveedor2;
			$proveedor->save();

			// Redirige al listado de todos los registros de proveedores con mensaje de éxito
			return redirect()->route('proveedor.index')->with('status', 'Proveedor agregado');
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Error, no se puede registrar: ' . $e->getMessage());
		}
	}

	/**
	 * Muestra la vista de edición para un registro de proveedor existente.
	 *
	 * @param  \App\Models\Proveedor  $proveedor
	 * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
	 */
	public function edit(Proveedor $proveedor)
	{
		try {
			// Retorna la vista de edición de proveedor junto con los datos necesarios
			return view('catalogo.proveedor.edit', compact('proveedor'));
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error: ' . $e->getMessage());
		}
	}

	/**
	 * Actualiza los detalles de un registro de proveedor existente en la base de datos, utilizando la clase ProveedorRequest para validación.
	 *
	 * @param  \App\Http\Requests\ProveedorRequest  $request
	 * @param  \App\Models\Proveedor  $proveedor
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(ProveedorRequest $request, Proveedor $proveedor)
	{
		try {
			// Actualiza los detalles del proveedor con los nuevos valores del formulario
			$proveedor->nombreComercial = $request->nombreComercial;
			$proveedor->razonSocial = $request->razonSocial;
			$proveedor->direccionProveedor = $request->direccionProveedor;
			$proveedor->fax = $request->fax;
			$proveedor->telefonoProveedor1 = $request->telefonoProveedor1;
			$proveedor->telefonoProveedor2 = $request->telefonoProveedor2;
			$proveedor->save();

			// Redirige al listado de todos los registros de proveedores con mensaje de éxito
			return redirect()->route('proveedor.index')->with('status', 'Proveedor actualizado');
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Error, no se puede actualizar: ' . $e->getMessage());
		}
	}

	/**
	 * Elimina un registro de proveedor de la base de datos.
	 *
	 * @param  \App\Models\Proveedor  $proveedor
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy(Proveedor $proveedor)
	{
		try {
			// Elimina el registro de proveedor
			$proveedor->delete();

			// Redirige al listado de todos los registros de proveedores con mensaje de éxito
			return redirect()->route('proveedor.index')->with('delete', 'Proveedor eliminado');
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'El registro no se puede eliminar, otra tabla lo utiliza: ' . $e->getMessage());
		}
	}
}

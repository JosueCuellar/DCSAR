<?php

namespace App\Http\Controllers\Catalogo;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProveedorRequest;
use App\Models\Proveedor;

class ProveedorController extends Controller
{

	//Función que trae un listado de todos los registros de la base de datos, los almacena y envía a la vista del index
	public function index()
	{
		try {
			$proveedores = Proveedor::all();
			return view('catalogo.proveedor.index', compact('proveedores'));
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	//Función que permite la creación de un nuevo registro que será almacenado dentro de la base de datos
	//Se hace uso de la clase Request para los mensajes de validación
	public function store(ProveedorRequest $request)
	{
		try {
			//Se crea y almacena un nuevo objeto
			$proveedor = new Proveedor();
			$proveedor->nombreComercial = $request->nombreComercial;
			$proveedor->razonSocial = $request->razonSocial;
			$proveedor->direccionProveedor = $request->direccionProveedor;
			$proveedor->fax = $request->fax;
			$proveedor->telefonoProveedor1 = $request->telefonoProveedor1;
			$proveedor->telefonoProveedor2 = $request->telefonoProveedor2;
			$proveedor->save();
			//Se redirige al listado de todos los registros
			return redirect()->route('proveedor.index')->with('status', 'Proveedor agregado');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Error no se puede registrar' . $e->getMessage());
		}
	}

	//Función que permite la edición de un registro almacenado
	public function edit(Proveedor $proveedor)
	{
		try {
			return view('catalogo.proveedor.edit', compact('proveedor'));
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	//Función que actualiza un registro
	public function update(ProveedorRequest $request, Proveedor $proveedor)
	{
		try {

			$proveedor->nombreComercial = $request->nombreComercial;
			$proveedor->razonSocial = $request->razonSocial;
			$proveedor->direccionProveedor = $request->direccionProveedor;
			$proveedor->fax = $request->fax;
			$proveedor->telefonoProveedor1 = $request->telefonoProveedor1;
			$proveedor->telefonoProveedor2 = $request->telefonoProveedor2;
			$proveedor->save();
			//Se redirige al listado de todos los registros
			return redirect()->route('proveedor.index')->with('status', 'Proveedor actualizado');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Error no se puede actualizar' . $e->getMessage());
		}
	}

	//Función que elimina un registro
	public function destroy(Proveedor $proveedor)
	{

		try {
			$proveedor->delete();
			return redirect()->route('proveedor.index')->with('delete', 'Proveedor eliminado');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'El registro no se puede eliminar, otra tabla lo utiliza' . $e->getMessage());
		}
	}
}

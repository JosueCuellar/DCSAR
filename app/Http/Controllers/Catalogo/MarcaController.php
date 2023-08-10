<?php

namespace App\Http\Controllers\Catalogo;

use App\Http\Controllers\Controller;
use App\Http\Requests\MarcaRequest;
use App\Models\Marca;

class MarcaController extends Controller
{

	//Función que trae un listado de todos los registros de la base de datos, los almacena y envía a la vista del index
	public function index()
	{
		try {
			$marcas = Marca::all();
			return view('catalogo.marca.index', compact('marcas'));
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	//Función que permite la creación de un nuevo registro que será almacenado dentro de la base de datos
	//Se hace uso de la clase Request para los mensajes de validación
	public function store(MarcaRequest $request)
	{
		try {
			//Se crea y almacena un nuevo objeto
			$marca = new Marca();
			$marca->nombre = $request->nombre;
			$marca->save();

			//Se redirige al listado de todos los registros
			return redirect()->route('marca.index')->with('status', 'Marca agregada');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Error no se puede registrar' . $e->getMessage());
		}
	}

	//Función que permite la edición de un registro almacenado
	public function edit(Marca $marca)
	{
		try {
			return view('catalogo.marca.edit', compact('marca'));
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Error no se puede actualizar' . $e->getMessage());
		}
	}

	//Función que actualiza un registro
	public function update(MarcaRequest $request, Marca $marca)
	{
		try {

			$marca->nombre =  $request->nombre;
			$marca->save();
			//Se redirige al listado de todos los registros
			return redirect()->route('marca.index')->with('status', 'Marca actualizada');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Error no se puede actualizar' . $e->getMessage());
		}
	}

	//Función que elimina un registro
	public function destroy(Marca $marca)
	{
		try {
			$marca->delete();
			return redirect()->route('marca.index')->with('delete', 'Marca eliminada');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'El registro no se puede eliminar, otra tabla lo utiliza' . $e->getMessage());
		}
	}
}

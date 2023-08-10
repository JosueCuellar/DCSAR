<?php

namespace App\Http\Controllers\Catalogo;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedidaRequest;
use App\Models\Medida;

class MedidaController extends Controller
{

	//Función que trae un listado de todos los registros de la base de datos, los almacena y envía a la vista del index
	public function index()
	{
		try {
			$medidas = Medida::all();
			return view('catalogo.medida.index', compact('medidas'));
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	//Función que permite la creación de un nuevo registro que será almacenado dentro de la base de datos
	//Se hace uso de la clase Request para los mensajes de validación
	public function store(MedidaRequest $request)
	{
		try {
			//Se crea y almacena un nuevo objeto
			$medida = new Medida();
			$medida->nombreMedida = $request->nombreMedida;
			$medida->save();
			//Se redirige al listado de todos los registros
			return redirect()->route('medida.index')->with('status', 'Medida agregada');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Error no se puede registrar' . $e->getMessage());
		}
	}

	//Función que permite la edición de un registro almacenado
	public function edit(Medida $medida)
	{
		try {
			return view('catalogo.medida.edit', compact('medida'));
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Error ' . $e->getMessage());
		}
	}

	//Función que actualiza un registro
	public function update(MedidaRequest $request, Medida $medida)
	{
		try {
			$medida->nombreMedida = $request->nombreMedida;
			$medida->save();
			//Se redirige al listado de todos los registros
			return redirect()->route('medida.index')->with('status', 'Medida actualizada');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Error no se puede actualizar' . $e->getMessage());
		}
	}

	//Función que elimina un registro
	public function destroy(Medida $medida)
	{
		try {
			$medida->delete();
			return redirect()->route('medida.index')->with('delete', 'Medida eliminada');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'El registro no se puede eliminar, otra tabla lo utiliza' . $e->getMessage());
		}
	}
}

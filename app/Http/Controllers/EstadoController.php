<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstadoRequest;
use App\Models\Estado;

class EstadoController extends Controller
{
	//Función que trae un listado de todos los registros de la base de datos, los almacena y envía a la vista del index
	public function index()
	{
		$estados = Estado::all();
		return view('estado.index', compact('estados'));
	}

	//Función que permite la creación de un nuevo registro que será almacenado dentro de la base de datos
	//Se hace uso de la clase Request para los mensajes de validación
	public function store(EstadoRequest $request)
	{
		try {
			//Se crea y almacena un nuevo objeto
			$estado = new Estado();
			$estado->codigoEstado = $request->codigoEstado;
			$estado->nombreEstado = $request->nombreEstado;
			$estado->descripcionEstado = $request->descripcionEstado;
			$estado->save();
			//Se redirige al listado de todos los registros
			return redirect()->route('estado.index')->with('status', 'Registro correcto');
		} catch (\Exception $e) {
			return redirect()->back()->with('msg', 'Error no se puede registrar');
		}
	}

	//Función que permite la edición de un registro almacenado
	public function edit(Estado $estado)
	{
		try {
			return view('estado.edit', compact('estado'));
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	//Función que actualiza un registro
	public function update(EstadoRequest $request, Estado $estado)
	{
		try {
			$estado->codigoEstado = $request->codigoEstado;
			$estado->nombreEstado = $request->nombreEstado;
			$estado->descripcionEstado = $request->descripcionEstado;
			$estado->save();
			//Se redirige al listado de todos los registros
			return redirect()->route('estado.index')->with('status', 'Registro correcto');
		} catch (\Exception $e) {
			return redirect()->back()->with('msg', 'Error no se puede actualizar');
		}
	}

	//Función que elimina un registro
	public function destroy(Estado $estado)
	{
		try {
			$estado->delete();
			return redirect()->route('estado.index')->with('delete', 'Registro eliminado');
		} catch (\Exception $e) {
			return redirect()->back()->with('msg', 'El registro no se puede eliminar, otra tabla lo utiliza');
		}
	}
}

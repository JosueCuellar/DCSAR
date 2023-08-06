<?php

namespace App\Http\Controllers\Catalogo;
use App\Http\Controllers\Controller;
use App\Http\Requests\RubroRequest;
use App\Models\Rubro;

class RubroController extends Controller
{
	//Función que trae un listado de todos los registros de la base de datos, los almacena y envía a la vista del index
	public function index()
	{
		try {
			$rubros = Rubro::all();
			return view('catalogo.rubro.index', compact('rubros'));
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	//Envia un arreglo de estados
	public function create()
	{
		return view('catalogo.rubro.create');
	}

	//Función que permite la creación de un nuevo registro que será almacenado dentro de la base de datos
	//Se hace uso de la clase Request para los mensajes de validación
	public function store(RubroRequest $request)
	{
		try {
			//Se crea y almacena un nuevo objeto
			$rubro = new Rubro();
			$rubro->codigoPresupuestario = $request->codigoPresupuestario;
			$rubro->descripRubro = $request->descripRubro;
			$rubro->save();
			//Se redirige al listado de todos los registros
			return redirect()->route('rubro.index')->with('status', 'Registro correcto');
		} catch (\Exception $e) {
			return redirect()->back()->with('msg', 'Error no se puede registrar' . $e->getMessage());
		}
	}

	//Función que permite la edición de un registro almacenado
	public function edit(Rubro $rubro)
	{
		try {
			return view('catalogo.rubro.edit', compact('rubro'));
		} catch (\Exception $e) {
			return redirect()->back()->with('msg', 'Error no se puede actualizar' . $e->getMessage());
		}
	}

	//Función que actualiza un registro
	public function update(RubroRequest $request, Rubro $rubro)
	{
		try {
			$rubro->codigoPresupuestario = $request->codigoPresupuestario;
			$rubro->descripRubro = $request->descripRubro;
			$rubro->save();
			//Se redirige al listado de todos los registros
			return redirect()->route('rubro.index')->with('status', 'Registro correcto');
		} catch (\Exception $e) {
			return redirect()->back()->with('msg', 'Error no se puede actualizar' . $e->getMessage());
		}
	}

	//Función que elimina un registro
	public function destroy(Rubro $rubro)
	{

		try {
			$rubro->delete();
			return redirect()->route('rubro.index')->with('delete', 'Registro eliminado');
		} catch (\Exception $e) {
			return redirect()->back()->with('msg', 'El registro no se puede eliminar, otra tabla lo utilizar' . $e->getMessage());
		}
	}
}

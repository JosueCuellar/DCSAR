<?php

namespace App\Http\Controllers\Catalogo;
use App\Http\Controllers\Controller;
use App\Http\Requests\UnidadOrganizativaRequest;
use App\Models\UnidadOrganizativa;

class UnidadOrganizativaController extends Controller
{
	//
	//Función que trae un listado de todos los registros de la base de datos, los almacena y envía a la vista del index
	public function index()
	{
		try {
			$unidades = UnidadOrganizativa::all();
			return view('catalogo.unidadOrganizativa.index', compact('unidades'));
		} catch (\Exception $e) {
		return redirect()->back()->with('catch', 'Ha ocurrido un error '.$e->getMessage());
		}
	}

	//Función que permite la creación de un nuevo registro que será almacenado dentro de la base de datos
	//Se hace uso de la clase Request para los mensajes de validación
	public function store(UnidadOrganizativaRequest $request)
	{
		try {
			//Se crea y almacena un nuevo objeto
			$unidad = new UnidadOrganizativa();
			$unidad->nombreUnidadOrganizativa = $request->nombreUnidadOrganizativa;
			$unidad->descripUnidadOrganizativa = $request->descripUnidadOrganizativa;
			$unidad->save();
			//Se redirige al listado de todos los registros
			return redirect()->route('unidadOrganizativa.index')->with('status', 'Unidad organizativa agregada');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Error no se puede registrar' . $e->getMessage());
		}
	}

	//Función que permite la edición de un registro almacenado
	public function edit(UnidadOrganizativa $unidadOrganizativa)
	{
		try {
			return view('catalogo.unidadOrganizativa.edit', compact('unidadOrganizativa'));
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error '.$e->getMessage());
		}
	}

	//Función que actualiza un registro
	public function update(UnidadOrganizativaRequest $request, UnidadOrganizativa $unidadOrganizativa)
	{
		try {
			$unidadOrganizativa->nombreUnidadOrganizativa = $request->nombreUnidadOrganizativa;
			$unidadOrganizativa->descripUnidadOrganizativa = $request->descripUnidadOrganizativa;
			$unidadOrganizativa->save();
			//Se redirige al listado de todos los registros
			return redirect()->route('unidadOrganizativa.index')->with('status', 'Unidad organizativa actualizada');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Error no se puede actualizar' . $e->getMessage());
		}
	}

	//Función que elimina un registro
	public function destroy(UnidadOrganizativa $unidadOrganizativa)
	{
		try {
			$unidadOrganizativa->delete();
			return redirect()->route('unidadOrganizativa.index')->with('delete', 'Unidad organizativa eliminada');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'El registro no se puede eliminar, otra tabla lo utilizar' . $e->getMessage());
		}
	}
}

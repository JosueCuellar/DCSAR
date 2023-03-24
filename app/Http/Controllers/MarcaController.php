<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarcaRequest;
use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    //

    //Función que trae un listado de todos los registros de la base de datos, los almacena y envía a la vista del index
    public function index()
    {
        $marcas = Marca::all();
        return view('marca.index', compact('marcas'));
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
            return redirect()->route('marca.index')->with('status', 'Registro correcto');
        } catch (\Exception $e) {
            return redirect()->back()->with('msg', 'Error no se puede registrar');
        }
    }

    //Función que permite la edición de un registro almacenado
    public function edit(Marca $marca)
    {
        try {
            return view('marca.edit', compact('marca'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    //Función que actualiza un registro
    public function update(MarcaRequest $request, Marca $marca)
    {
        try {

            $marca->nombre =  $request->nombre;
            $marca->save();
            //Se redirige al listado de todos los registros
            return redirect()->route('marca.index')->with('status', 'Registro correcto');
        } catch (\Exception $e) {
            return redirect()->back()->with('msg', 'Error no se puede actualizar');
        }
    }

    //Función que elimina un registro
    public function destroy(Marca $marca)
    {
        try {
            $marca->delete();
            return redirect()->route('marca.index')->with('delete', 'Registro eliminado');
        } catch (\Exception $e) {
            return redirect()->back()->with('msg', 'El registro no se puede eliminar, otra tabla lo utiliza');
        }
    }
}

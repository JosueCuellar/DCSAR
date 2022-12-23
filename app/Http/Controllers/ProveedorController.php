<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProveedorRequest;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{

    //Función que trae un listado de todos los registros de la base de datos, los almacena y envía a la vista del index
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('proveedor.index', compact('proveedores'));
    }

    //Función que permite la creación de un nuevo registro que será almacenado dentro de la base de datos
    //Se hace uso de la clase Request para los mensajes de validación
    public function store(ProveedorRequest $request)
    {
        try{
            //Se crea y almacena un nuevo objeto
            $proveedor = new Proveedor();
            $proveedor->nombreComercial = $request->nombreComercial;
            $proveedor->razonSocial = $request->razonSocial;
            $proveedor->direccion = $request->direccion;
            $proveedor->fax = $request->fax;
            $proveedor->telefono1 = $request->telefono1;
            $proveedor->telefono2 = $request->telefono2;
            $proveedor->save();
            //Se redirige al listado de todos los registros
            return redirect()->route('proveedor.index');
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    //Función que permite la edición de un registro almacenado
    public function edit(Proveedor $proveedor)
    {
        try{
            return view('proveedor.edit', compact('proveedor'));
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    //Función que actualiza un registro
    public function update(ProveedorRequest $request, Proveedor $proveedor)
    {
        try{
            
            $proveedor->nomreComercial->$request->nombreComercial;
            $proveedor->razonSocial->$request->razonSocial;
            $proveedor->direccion->$request->direccion;
            $proveedor->fax->$request->fax;
            $proveedor->telefono1->$request->telefono1;
            $proveedor->telefono2->$request->telefono2;
            $proveedor->save();            
            //Se redirige al listado de todos los registros
            return redirect()->route('proveedor.index');
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    //Función que elimina un registro
    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete();
        return redirect()->route('proveedor.index'); 
    }
}

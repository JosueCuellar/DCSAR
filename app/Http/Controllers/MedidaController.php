<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedidaRequest;
use App\Models\Medida;
use Illuminate\Http\Request;

class MedidaController extends Controller
{
    //
       //Función que trae un listado de todos los registros de la base de datos, los almacena y envía a la vista del index
       public function index()
       {
           $medidas = Medida::all();
           return view('medida.index', compact('medidas'));
       }
   
       //Función que permite la creación de un nuevo registro que será almacenado dentro de la base de datos
       //Se hace uso de la clase Request para los mensajes de validación
       public function store(MedidaRequest $request)
       {
           try{
               //Se crea y almacena un nuevo objeto
               $medida = new Medida();
               $medida->nombre_medida = $request->nombre_medida;
               $medida->save();
               //Se redirige al listado de todos los registros
               return redirect()->route('medida.index')->with('status', 'Registro correcto');
        } catch (\Exception $e) {
            return redirect()->back()->with('msg', 'Error no se puede registrar');
        }
       }
   
       //Función que permite la edición de un registro almacenado
       public function edit(Medida $medida)
       {
           try{
               return view('medida.edit', compact('medida'));
           }catch(\Exception $e){
               return $e->getMessage();
           }
       }
   
       //Función que actualiza un registro
       public function update(MedidaRequest $request, Medida $medida)
       {
           try{
                $medida->nombre_medida = $request->nombre_medida;
                $medida->save();            
               //Se redirige al listado de todos los registros
               return redirect()->route('medida.index')->with('status', 'Registro correcto');
        } catch (\Exception $e) {
            return redirect()->back()->with('msg', 'Error no se puede actualizar');
        }
       }
   
       //Función que elimina un registro
       public function destroy(Medida $medida)
       {
        try {
            $medida->delete();
            return redirect()->route('medida.index')->with('delete', 'Registro eliminado'); 
        } catch (\Exception $e) {
            return redirect()->back()->with('msg', 'El registro no se puede eliminar, otra tabla lo utiliza');
        }


       }
}

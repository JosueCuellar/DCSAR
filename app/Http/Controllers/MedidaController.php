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
               $medida->nombreMedida = $request->nombreMedida;
               $medida->save();
               //Se redirige al listado de todos los registros
               return redirect()->route('medida.index');
           }catch(\Exception $e){
               return $e->getMessage();
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
                $medida->nombreMedida = $request->nombreMedida;
                $medida->save();            
               //Se redirige al listado de todos los registros
               return redirect()->route('medida.index');
           }catch(\Exception $e){
               return $e->getMessage();
           }
       }
   
       //Función que elimina un registro
       public function destroy(Medida $medida)
       {
           $medida->delete();
           return redirect()->route('medida.index'); 
       }
}

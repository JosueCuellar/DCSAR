<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnidadOrganizativaRequest;
use App\Models\UnidadOrganizativa;
use Illuminate\Http\Request;

class UnidadOrganizativaController extends Controller
{
    //
       //Función que trae un listado de todos los registros de la base de datos, los almacena y envía a la vista del index
       public function index()
       {
           $unidades = UnidadOrganizativa::all();
           return view('unidadOrganizativa.index', compact('unidades'));
       }
   
       //Función que permite la creación de un nuevo registro que será almacenado dentro de la base de datos
       //Se hace uso de la clase Request para los mensajes de validación
       public function store(UnidadOrganizativaRequest $request)
       {
           try{
               //Se crea y almacena un nuevo objeto
               $unidad = new UnidadOrganizativa();
               $unidad->nombre_unidad_medida = $request->nombre_unidad_medida;
               $unidad->descripcion_unidad_medida = $request->descripcion_unidad_medida;
               $unidad->save();
               //Se redirige al listado de todos los registros
               return redirect()->route('unidadOrganizativa.index');
           }catch(\Exception $e){
               return $e->getMessage();
           }
       }
   
       //Función que permite la edición de un registro almacenado
       public function edit(UnidadOrganizativa $unidadOrganizativa)
       {
           try{
               return view('unidadOrganizativa.edit', compact('unidadOrganizativa'));
           }catch(\Exception $e){
               return $e->getMessage();
           }
       }
   
       //Función que actualiza un registro
       public function update(UnidadOrganizativaRequest $request, UnidadOrganizativa $unidadOrganizativa)
       {
           try{
                $unidadOrganizativa->nombre_unidad_medida = $request->nombre_unidad_medida;
                $unidadOrganizativa->descripcion_unidad_medida = $request->descripcion_unidad_medida;
                $unidadOrganizativa->save();          
               //Se redirige al listado de todos los registros
               return redirect()->route('unidadOrganizativa.index');
           }catch(\Exception $e){
               return $e->getMessage();
           }
       }
   
       //Función que elimina un registro
       public function destroy(UnidadOrganizativa $unidadOrganizativa)
       {
           $unidadOrganizativa->delete();
           return redirect()->route('unidadOrganizativa.index'); 
       }

}

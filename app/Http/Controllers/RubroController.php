<?php

namespace App\Http\Controllers;

use App\Http\Requests\RubroRequest;
use App\Models\Estado;
use App\Models\Rubro;
use Illuminate\Http\Request;

class RubroController extends Controller
{
    //
       //Función que trae un listado de todos los registros de la base de datos, los almacena y envía a la vista del index
       public function index()
       {
           $rubros = Rubro::all();
           $estados = Estado::all();
           return view('rubro.index', compact('rubros','estados'));
       }

       //Envia un arreglo de estados
       public function create()
       {
           $estados = Estado::all();
           return view('rubro.create', compact('estados'));
   
       }
   
       //Función que permite la creación de un nuevo registro que será almacenado dentro de la base de datos
       //Se hace uso de la clase Request para los mensajes de validación
       public function store(RubroRequest $request)
       {
           try{
               //Se crea y almacena un nuevo objeto
               $rubro = new Rubro();
               $rubro->codigo_presupuestario = $request->codigo_presupuestario;
               $rubro->descripcion_rubro = $request->descripcion_rubro;
               $rubro->save();
               //Se redirige al listado de todos los registros
               return redirect()->route('rubro.index')->with('status', 'Registro correcto');
            } catch (\Exception $e) {
                return redirect()->back()->with('msg', 'Error no se puede registrar');
            }
       }
   
       //Función que permite la edición de un registro almacenado
       public function edit(Rubro $rubro)
       {
           try{
               $estados = Estado::all();
               return view('rubro.edit', compact('rubro','estados'));
           }catch(\Exception $e){
               return $e->getMessage();
           }
       }
   
       //Función que actualiza un registro
       public function update(RubroRequest $request, Rubro $rubro)
       {
           try{
                $rubro->codigo_presupuestario = $request->codigo_presupuestario;
                $rubro->descripcion_rubro = $request->descripcion_rubro;
                $rubro->save();            
               //Se redirige al listado de todos los registros
               return redirect()->route('rubro.index')->with('status', 'Registro correcto');
            } catch (\Exception $e) {
                return redirect()->back()->with('msg', 'Error no se puede actualizar');
            }
       }
   
       //Función que elimina un registro
       public function destroy(Rubro $rubro)
       {
          
           try {
            $rubro->delete();
            return redirect()->route('rubro.index')->with('delete', 'Registro eliminado'); 
        } catch (\Exception $e) {
            return redirect()->back()->with('msg', 'El registro no se puede eliminar, otra tabla lo utilizar');
        }
       }
}

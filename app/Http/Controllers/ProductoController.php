<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoRequest;
use App\Models\Estado;
use App\Models\Marca;
use App\Models\Medida;
use App\Models\Producto;
use App\Models\Rubro;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    //
       //Función que trae un listado de todos los registros de la base de datos, los almacena y envía a la vista del index
       public function index()
       {
           $productos = Producto::all();
           return view('producto.index', compact('productos'));
       }

       //Envia un arreglo de estados
       public function create()
       {
           $marcas = Marca::all();
           $medidas = Medida::all();
           $rubros = Rubro::all();
           $estados = Estado::all();
           return view('producto.create', compact('marcas','medidas','rubros','estados'));
   
       }
   
       //Función que permite la creación de un nuevo registro que será almacenado dentro de la base de datos
       //Se hace uso de la clase Request para los mensajes de validación
       public function store(ProductoRequest $request)
       {
           try{
               $imagen = $request->file('imagen');
               $rutaGuardarImagen = 'imagen/';
               $imagenProducto = date('YmdHis').".".$imagen->getClientOriginalExtension();
               $imagen->move($rutaGuardarImagen, $imagenProducto);
               //Se crea y almacena un nuevo objeto
               $producto = new Producto();
               $producto->cod_producto = $request->cod_producto;
               $producto->descripcion = $request->descripcion;
               $producto->observacion = $request->observacion;
               $producto->imagen = $imagenProducto;
               $producto->marca_id = $request->marca_id;
               $producto->medida_id = $request->medida_id;
               $producto->rubro_id = $request->rubro_id;
               $producto->estado_id = $request->estado_id;
               $producto->save();
               //Se redirige al listado de todos los registros
               return redirect()->route('producto.index');
           }catch(\Exception $e){
               return $e->getMessage();
           }
       }
   
       //Función que permite la edición de un registro almacenado
       public function edit(Producto $producto)
       {
           try{
                $marcas = Marca::all();
                $medidas = Medida::all();
                $rubros = Rubro::all();
                $estados = Estado::all();
                return view('producto.edit', compact('producto','marcas','medidas','rubros','estados'));
            }catch(\Exception $e){
                return $e->getMessage();
            }
       }
   
       //Función que actualiza un registro
       public function update(ProductoRequest $request, Producto $producto)
       {
           try{
                $producto->cod_producto = $request->cod_producto;
                $producto->descripcion = $request->descripcion;
                $producto->observacion = $request->observacion;
                $producto->marca_id = $request->marca_id;
                $producto->medida_id = $request->medida_id;
                $producto->rubro_id = $request->rubro_id;
                $producto->estado_id = $request->estado_id;
                $producto->save();        
                //Se redirige al listado de todos los registros
                return redirect()->route('producto.index');
            }catch(\Exception $e){
                return $e->getMessage();
            }
       }
   
       //Función que elimina un registro
       public function destroy(Producto $producto)
       {
           $producto->delete();
           return redirect()->route('producto.index'); 
       }
}

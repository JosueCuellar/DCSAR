<?php

namespace App\Http\Controllers;

use App\Models\DetalleRequisicion;
use App\Models\Producto;
use App\Models\RequisicionProducto;
use Illuminate\Http\Request;

class DetalleRequisicionController extends Controller
{
    //
    public function index(RequisicionProducto $requisicionProducto, Request $request)
    {
        $detalle_requisicion = DetalleRequisicion::where('requisicion_id',$requisicionProducto->id)->get();
        $cod_producto = $request->get('cod_producto');
        if($cod_producto){
            $productos = Producto::where('cod_producto','LIKE',"%$cod_producto%")->get();
            return view('requisicionProducto.detalle',compact('detalle_requisicion', 'productos','requisicionProducto'));
        }else{
            $productos = Producto::all();
            return view('requisicionProducto.detalle',compact('detalle_requisicion', 'productos','requisicionProducto'));
        }
        $productos = Producto::all();
        
    }

    public function detalle(RequisicionProducto $requisicionProducto, Request $request)
    {
        $detalle_requisicion = DetalleRequisicion::where('requisicion_id',$requisicionProducto->id)->get();
        $cod_producto = $request->get('cod_producto');
        if($cod_producto){
            $productos = Producto::where('cod_producto','LIKE',"%$cod_producto%")->get();
            return view('requisicionProducto.detalleRevision',compact('detalle_requisicion', 'productos','requisicionProducto'));
        }else{
            $productos = Producto::all();
            return view('requisicionProducto.detalleRevision',compact('detalle_requisicion', 'productos','requisicionProducto'));
        }
        $productos = Producto::all();
        
    }

    public function store(Request $request, RequisicionProducto $requisicionProducto, Producto $producto)
    {
        try{
            $existe =  DetalleRequisicion::where('requisicion_id',$requisicionProducto->id)->where('producto_id',$producto->id)->get();
            $cantidad_P = count($existe);
            if($cantidad_P>0){
                $detalle_requisicion = DetalleRequisicion::find($existe[0]->id);
                $detalle_requisicion->cantidad = ($detalle_requisicion->cantidad) + 1;
                $detalle_requisicion->save();
            }else{
                $detalle_requisicion =  new DetalleRequisicion();
                $detalle_requisicion->cantidad = 1;
                $detalle_requisicion->requisicion_id = $requisicionProducto->id;
                $detalle_requisicion->producto_id=$producto->id;
                $detalle_requisicion->save();
            }
            return redirect()->route('requisicionProducto.detalle',$requisicionProducto);
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public function update(Request $request, RequisicionProducto $requisicionProducto, String $detalleRequisicion)
    {
        try{
            $detalleRequisicion =  DetalleRequisicion::find($detalleRequisicion);
            $detalleRequisicion->cantidad = $request->cantidad;
            $detalleRequisicion->save();
            return redirect()->route('requisicionProducto.detalle',$requisicionProducto);
            
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
    public function destroy(RequisicionProducto $requisicionProducto, DetalleRequisicion $detalleRequisicion)
    {
        try{
            $detalleRequisicion->forceDelete();
            return redirect()->route('requisicionProducto.detalle', $requisicionProducto);
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}

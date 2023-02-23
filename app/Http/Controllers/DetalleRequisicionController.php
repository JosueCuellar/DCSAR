<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetalleRequisicionRequest;
use App\Models\DetalleCompra;
use App\Models\DetalleRequisicion;
use App\Models\Producto;
use App\Models\RequisicionProducto;
use Illuminate\Http\Request;

class DetalleRequisicionController extends Controller
{
    //
    public function index(RequisicionProducto $requisicionProducto, Request $request)
    {
        $totalFinal = 0;
        
        $detalle_requisicion = DetalleRequisicion::where('requisicion_id',$requisicionProducto->id)->get();
        foreach($detalle_requisicion as $item){
            $totalFinal += $item->total;
        }
        $cod_producto = $request->get('cod_producto');
        if($cod_producto){
            $productos = Producto::where('cod_producto','LIKE',"%$cod_producto%")->get();
            return view('requisicionProducto.detalle',compact('detalle_requisicion', 'productos','requisicionProducto', 'totalFinal'));
        }else{
            $productos = Producto::all();
            return view('requisicionProducto.detalle',compact('detalle_requisicion', 'productos','requisicionProducto', 'totalFinal'));
        }
        $productos = Producto::all();
        
    }

    public function detalle(RequisicionProducto $requisicionProducto, Request $request)
    {
        $totalFinal = 0;
        $detalle_requisicion = DetalleRequisicion::where('requisicion_id',$requisicionProducto->id)->get();
        $cod_producto = $request->get('cod_producto');
        foreach($detalle_requisicion as $item){
            $totalFinal += $item->total;
        }
        if($cod_producto){
            $productos = Producto::where('cod_producto','LIKE',"%$cod_producto%")->get();
            return view('requisicionProducto.detalleRevision',compact('detalle_requisicion', 'productos','requisicionProducto','totalFinal'));
        }else{
            $productos = Producto::all();
            return view('requisicionProducto.detalleRevision',compact('detalle_requisicion', 'productos','requisicionProducto','totalFinal'));
        }
        $productos = Producto::all();
        
    }

    public function store(DetalleRequisicionRequest $request, RequisicionProducto $requisicionProducto, Producto $producto)
    {
        try{
            $producto_id = $producto->id;
            $precioPromedio = 0;                
            $existe =  DetalleRequisicion::where('requisicion_id',$requisicionProducto->id)->where('producto_id',$producto->id)->get();
            $productoA = Producto::where('id', $producto_id)->first();
            $precioPromedio = $productoA->costoPromedio;
            $cantidad_P = count($existe);
            if($cantidad_P>0){
                $detalle_requisicion = DetalleRequisicion::find($existe[0]->id);
                $detalle_requisicion->precioPromedio = $productoA->costoPromedio; 
                $detalle_requisicion->cantidad = ($detalle_requisicion->cantidad) + $request->cantidadAdd;
                $detalle_requisicion->total = ($detalle_requisicion->cantidad)*$precioPromedio;
                $detalle_requisicion->save();
            }else{
                $detalle_requisicion =  new DetalleRequisicion();
                $detalle_requisicion->cantidad = $request->cantidadAdd;
                $detalle_requisicion->precioPromedio = $productoA->costoPromedio; 
                $detalle_requisicion->total = ($detalle_requisicion->cantidad)*$precioPromedio ;
                $detalle_requisicion->requisicion_id = $requisicionProducto->id;
                $detalle_requisicion->producto_id = $producto->id;
                $detalle_requisicion->save();
            }
            return redirect()->route('requisicionProducto.detalle',$requisicionProducto)->with('status', 'Se ha agregado correctamente!');
        }catch(\Exception $e){
            return redirect()->back()->with('msg', 'Error, debe de agregar un numero valido!');
            // return response()->json(array($productoA));   
        }
    }

    public function update(Request $request, RequisicionProducto $requisicionProducto, String $detalleRequisicion)
    {
        try{

            $rules = [
                'cantidad' => 'required|numeric|min:1',
            ];
            $this->validate($request, $rules);
            $detalle =  DetalleRequisicion::find($detalleRequisicion);
            $detalle->cantidad = $request->cantidad;
            $detalle->total = ($request->cantidad)*($detalle->precioPromedio);
            $detalle->save();
            return redirect()->route('requisicionProducto.detalle',$requisicionProducto)->with('status', 'Se ha actualizado correctamente!');
        }catch(\Exception $e){
            return redirect()->back()->with('msg', 'Error, debe de agregar un numero valido!');
        }
    }
    public function destroy(RequisicionProducto $requisicionProducto, DetalleRequisicion $detalleRequisicion)
    {
        try{
            $detalleRequisicion->forceDelete();
            return redirect()->route('requisicionProducto.detalle', $requisicionProducto)->with('delete', 'Se ha eliminado el registro!');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error, debe de agregar un numero valido!');
        }
    }
}

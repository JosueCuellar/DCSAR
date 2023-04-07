<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetalleRequisicionRequest;
use App\Models\DetalleCompra;
use App\Models\DetalleRequisicion;
use App\Models\Producto;
use App\Models\RequisicionProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetalleRequisicionController extends Controller
{
    //
    public function index(RequisicionProducto $requisicionProducto, Request $request)
    {
        $totalFinal = 0.0;

        $productos = DB::select(
            "SELECT p.id as id, p.descripcion as descripcion, p.imagen as imagen,
            dc.cantidad_ingreso - COALESCE(rp.cantidad_rechazada, 0) AS stock,
            COALESCE(rp.cantidad_aprobada, 0) AS stock1,
            m.nombre_medida as nombre_medida, r.descripcion_rubro as rubro
            FROM productos p
            JOIN medidas m ON p.medida_id = m.id
            JOIN rubros r ON p.rubro_id = r.id
            LEFT JOIN (SELECT producto_id, SUM(cantidad_ingreso) AS cantidad_ingreso
            FROM detalle_compras
            GROUP BY producto_id) dc ON p.id = dc.producto_id
            LEFT JOIN (SELECT producto_id, SUM(CASE WHEN estado_id = 1 OR estado_id = 2 OR estado_id = 5 THEN cantidad ELSE 0 END) AS cantidad_aprobada,
            SUM(CASE WHEN estado_id = 4  THEN cantidad ELSE 0 END) AS cantidad_rechazada
            FROM detalle_requisicions dr
            JOIN requisicion_productos rp ON dr.requisicion_id = rp.id
            WHERE rp.estado_id IN (1, 2, 4, 5)
            GROUP BY producto_id) rp ON p.id = rp.producto_id;"
        );


        $detalle_requisicion = DetalleRequisicion::where('requisicion_id', $requisicionProducto->id)->get();
        foreach ($detalle_requisicion as $item) {
            $totalFinal += $item->total;
        }

        return view('requisicionProducto.detalle', compact('detalle_requisicion', 'productos', 'requisicionProducto', 'totalFinal'));
    }

    public function detalle(RequisicionProducto $requisicionProducto, Request $request)
    {
        $totalFinal = 0.0;
        $detalle_requisicion = DetalleRequisicion::where('requisicion_id', $requisicionProducto->id)->get();
        $cod_producto = $request->get('cod_producto');
        foreach ($detalle_requisicion as $item) {
            $totalFinal += $item->total;
        }
        if ($cod_producto) {
            $productos = Producto::where('cod_producto', 'LIKE', "%$cod_producto%")->get();
            return view('requisicionProducto.detalleRevision', compact('detalle_requisicion', 'productos', 'requisicionProducto', 'totalFinal'));
        } else {
            $productos = Producto::all();
            return view('requisicionProducto.detalleRevision', compact('detalle_requisicion', 'productos', 'requisicionProducto', 'totalFinal'));
        }
        $productos = Producto::all();
    }

    public function store(DetalleRequisicionRequest $request, RequisicionProducto $requisicionProducto, Producto $producto)
    {
        try {
            $producto_id = $producto->id;
            $codigo = $producto->id;;
            $productos = DB::select("
            SELECT p.cod_producto, p.descripcion,
            dc.cantidad_ingreso - COALESCE(rp.cantidad_rechazada, 0) AS stock,
            COALESCE(rp.cantidad_aprobada, 0) AS stock1
            FROM productos p
            LEFT JOIN (SELECT producto_id, SUM(cantidad_ingreso) AS cantidad_ingreso
            FROM detalle_compras
            GROUP BY producto_id) dc ON p.id = dc.producto_id 
            LEFT JOIN (SELECT producto_id, SUM(CASE WHEN estado_id = 1 OR estado_id = 2 OR estado_id = 5 THEN cantidad ELSE 0 END) AS cantidad_aprobada,
            SUM(CASE WHEN estado_id = 4 THEN cantidad ELSE 0 END) AS cantidad_rechazada
            FROM detalle_requisicions dr
            JOIN requisicion_productos rp ON dr.requisicion_id = rp.id
            WHERE rp.estado_id IN (1, 2, 4, 5)
            GROUP BY producto_id) rp ON p.id = rp.producto_id
            WHERE p.id = ?
            ", [$codigo]);

            $valorCantidadMinima = 0;
            foreach ($productos as $p) {
                $valorCantidadMinima = $p->stock-$p->stock1;
            };

            if ($request->cantidadAdd > $valorCantidadMinima) {
                return redirect()->back()->with('msg', 'Error, el numero supera a la cantida en stock! Unicamente hay ' . $valorCantidadMinima . ' disponibles');
            } else {

                $precio_promedio = 0;
                $existe =  DetalleRequisicion::where('requisicion_id', $requisicionProducto->id)->where('producto_id', $producto->id)->get();
                $productoA = Producto::where('id', $producto_id)->first();
                $precio_promedio = $productoA->costo_promedio;
                $cantidad_P = count($existe);
                if ($cantidad_P > 0) {
                    $detalle_requisicion = DetalleRequisicion::find($existe[0]->id);
                    $detalle_requisicion->precio_promedio = $productoA->costo_promedio;
                    $detalle_requisicion->cantidad = ($detalle_requisicion->cantidad) + $request->cantidadAdd;
                    $detalle_requisicion->cantidad_entregada = 0;
                    $detalle_requisicion->total = ($detalle_requisicion->cantidad) * $precio_promedio;
                    $detalle_requisicion->save();
                } else {
                    $detalle_requisicion =  new DetalleRequisicion();
                    $detalle_requisicion->cantidad = $request->cantidadAdd;
                    $detalle_requisicion->cantidad_entregada = 0;
                    $detalle_requisicion->precio_promedio = $productoA->costo_promedio;
                    $detalle_requisicion->total = ($detalle_requisicion->cantidad) * $precio_promedio;
                    $detalle_requisicion->requisicion_id = $requisicionProducto->id;
                    $detalle_requisicion->producto_id = $producto->id;
                    $detalle_requisicion->save();
                }
                return redirect()->route('requisicionProducto.detalle', $requisicionProducto)->with('status', 'Se ha agregado correctamente!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('msg', 'Error, debe de agregar un numero valido!'.$e->getMessage());
            // return response()->json(array($productoA));   
        }
    }

    public function update(Request $request, RequisicionProducto $requisicionProducto, String $detalleRequisicion)
    {
        try {

            $rules = [
                'cantidad' => 'required|numeric|min:1',
            ];
            $this->validate($request, $rules);
            $detalle =  DetalleRequisicion::find($detalleRequisicion);
            $detalle->cantidad = $request->cantidad;
            $detalle->total = ($request->cantidad) * ($detalle->precio_promedio);
            $detalle->save();
            return redirect()->route('requisicionProducto.detalle', $requisicionProducto)->with('status', 'Se ha actualizado correctamente!');
        } catch (\Exception $e) {
            return redirect()->back()->with('msg', 'Error, debe de agregar un numero valido!');
        }
    }
    public function destroy(RequisicionProducto $requisicionProducto, DetalleRequisicion $detalleRequisicion)
    {
        try {
            $detalleRequisicion->forceDelete();
            return redirect()->route('requisicionProducto.detalle', $requisicionProducto)->with('delete', 'Se ha eliminado el registro!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error, debe de agregar un numero valido!');
        }
    }
}

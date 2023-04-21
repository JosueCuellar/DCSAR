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
            dc.cantidadIngreso - COALESCE(rp.cantidad_rechazada, 0) AS stock,
            COALESCE(rp.cantidad_aprobada, 0) AS stock1,
            m.nombreMedida as nombreMedida, r.descripRubro as rubro
            FROM productos p
            JOIN medidas m ON p.medida_id = m.id
            JOIN rubros r ON p.rubro_id = r.id
            LEFT JOIN (SELECT producto_id, SUM(cantidadIngreso) AS cantidadIngreso
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
        $codProducto = $request->get('codProducto');
        foreach ($detalle_requisicion as $item) {
            $totalFinal += $item->total;
        }
        if ($codProducto) {
            $productos = Producto::where('codProducto', 'LIKE', "%$codProducto%")->get();
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
            SELECT p.codProducto, p.descripcion,
            dc.cantidadIngreso - COALESCE(rp.cantidad_rechazada, 0) AS stock,
            COALESCE(rp.cantidad_aprobada, 0) AS stock1
            FROM productos p
            LEFT JOIN (SELECT producto_id, SUM(cantidadIngreso) AS cantidadIngreso
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

                $precioPromedio = 0;
                $existe =  DetalleRequisicion::where('requisicion_id', $requisicionProducto->id)->where('producto_id', $producto->id)->get();
                $productoA = Producto::where('id', $producto_id)->first();
                $precioPromedio = $productoA->costoPromedio;
                $cantidad_P = count($existe);
                if ($cantidad_P > 0) {
                    $detalle_requisicion = DetalleRequisicion::find($existe[0]->id);
                    $detalle_requisicion->precioPromedio = $productoA->costoPromedio;
                    $detalle_requisicion->cantidad = ($detalle_requisicion->cantidad) + $request->cantidadAdd;
                    $detalle_requisicion->cantidadEntregada = 0;
                    $detalle_requisicion->total = ($detalle_requisicion->cantidad) * $precioPromedio;
                    $detalle_requisicion->save();
                } else {
                    $detalle_requisicion =  new DetalleRequisicion();
                    $detalle_requisicion->cantidad = $request->cantidadAdd;
                    $detalle_requisicion->cantidadEntregada = 0;
                    $detalle_requisicion->precioPromedio = $productoA->costoPromedio;
                    $detalle_requisicion->total = ($detalle_requisicion->cantidad) * $precioPromedio;
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
            $detalle->total = ($request->cantidad) * ($detalle->precioPromedio);
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

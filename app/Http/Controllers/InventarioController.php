<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    //

    public function index(Request $request)
    {

        $inventarios = DB::select(
            "SELECT p.codProducto, p.descripcion,
            dc.cantidadIngreso - COALESCE(rp.cantidad_rechazada, 0) AS stock,
            COALESCE(rp.cantidad_aprobada, 0) AS stock1
            FROM productos p
            LEFT JOIN (SELECT producto_id, SUM(cantidadIngreso) AS cantidadIngreso
            FROM detalle_compras
            GROUP BY producto_id) dc ON p.id = dc.producto_id
            LEFT JOIN (SELECT producto_id, SUM(CASE WHEN estado_id = 1 OR estado_id = 2 THEN cantidad ELSE 0 END) AS cantidad_aprobada,
            SUM(CASE WHEN estado_id = 4 THEN cantidad ELSE 0 END) AS cantidad_rechazada
            FROM detalle_requisicions dr
            JOIN requisicion_productos rp ON dr.requisicion_id = rp.id
            WHERE rp.estado_id IN (1, 2, 4)
            GROUP BY producto_id) rp ON p.id = rp.producto_id;"
        );


        $productos = DB::select(
            "SELECT p.id, p.descripcion, p.imagen,
            dc.cantidadIngreso - COALESCE(rp.cantidad_rechazada, 0) AS stock,
            COALESCE(rp.cantidad_aprobada, 0) AS stock1,
            m.nombreMedida, r.descripRubro
            FROM productos p
            JOIN medidas m ON p.medida_id = m.id
            JOIN rubros r ON p.rubro_id = r.id
            LEFT JOIN (SELECT producto_id, SUM(cantidadIngreso) AS cantidadIngreso
            FROM detalle_compras
            GROUP BY producto_id) dc ON p.id = dc.producto_id
            LEFT JOIN (SELECT producto_id, SUM(CASE WHEN estado_id = 1 OR estado_id = 2 THEN cantidad ELSE 0 END) AS cantidad_aprobada,
            SUM(CASE WHEN estado_id = 4 THEN cantidad ELSE 0 END) AS cantidad_rechazada
            FROM detalle_requisicions dr
            JOIN requisicion_productos rp ON dr.requisicion_id = rp.id
            WHERE rp.estado_id IN (1, 2, 4)
            GROUP BY producto_id) rp ON p.id = rp.producto_id;"
        );
        return view('inventario.index', compact('inventarios'));
    }
    
    public function store(Request $request)
    {
        try {
            $inventario = new Inventario();
            $inventario->codProducto = $request->codProducto;
            $inventario->descripcion = $request->descripcion;
            $inventario->observacion = $request->observacion;
            $inventario->stock = $request->stock;
            $inventario->save();
            return redirect()->route('producto.index');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}

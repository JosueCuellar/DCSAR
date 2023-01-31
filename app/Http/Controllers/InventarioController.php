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
        $ampe1= "%";
        $nombre = $request->get('buscarpor');
        $nombreD = $ampe1.''.$nombre;
        $nombreMedicamento = $nombreD.''.$ampe1;
        $inventarios = DB::select(
            "SELECT cod_producto,descripcion,observacion,SUM(stock) AS stock
            FROM
              (SELECT producto_id, SUM(cantidadIngreso) AS stock FROM detalle_compras GROUP BY producto_id
                UNION ALL
               SELECT  producto_id, -SUM(cantidad) AS stock FROM detalle_requisicions GROUP BY producto_id
              ) as subquery INNER JOIN productos ON subquery.producto_id = productos.id GROUP BY cod_producto,descripcion,observacion;");

            return view('inventario.index',compact('inventarios'));
 
    }
    public function store(Request $request)
    {
        try{
            $inventario = new Inventario();
            $inventario->cod_producto = $request->cod_producto;
            $inventario->descripcion = $request->descripcion;
            $inventario->observacion = $request->observacion;
            $inventario->stock = $request->stock;
            $inventario->save();
            return redirect()->route('producto.index');
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}

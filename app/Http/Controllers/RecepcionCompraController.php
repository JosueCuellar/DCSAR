<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Models\RecepcionCompra;
use DateTime;
use Illuminate\Http\Request;


class RecepcionCompraController extends Controller
{
    //
    public function index()
    {
        $recepcionCompras = RecepcionCompra::all();
        $proveedores = Proveedor::all();
        return view('recepcionCompra.create', compact('recepcionCompras', 'proveedores'));
    }

    public function store(Request $request)
    {
        try {
            $recepcionCompra = new RecepcionCompra();
            $recepcionCompra->proveedor_id = $request->proveedor_id;
            $recepcionCompra->nOrdenCompra = $request->nOrdenCompra;
            $recepcionCompra->nPresupuestario = $request->nPresupuestario;
            $recepcionCompra->nCompromiso = $request->nCompromiso;
            $recepcionCompra->actaRecepcion = $request->actaRecepcion;
            $recepcionCompra->codigoFactura = $request->codigoFactura;
            $recepcionCompra->save();
            return redirect()->route('recepcionCompra.detalle', $recepcionCompra);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}

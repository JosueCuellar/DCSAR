<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecepcionCompraRequest;
use App\Models\Proveedor;
use App\Models\RecepcionCompra;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class RecepcionCompraController extends Controller
{
    //
    public function index()
    {
        $recepcionCompras = RecepcionCompra::all();
        $proveedores = Proveedor::all();
        return view('recepcionCompra.create', compact('recepcionCompras', 'proveedores'));
    }


    public function store(RecepcionCompraRequest $request)
    {
        try {
            $recepcionCompra = new RecepcionCompra();
            $recepcionCompra->proveedor_id = $request->proveedor_id;
            $recepcionCompra->estado = false;
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


    public function update(Request $request, RecepcionCompra $recepcionCompra)
    {
        try {
            $recepcionCompra->estado = true;
            $recepcionCompra->save();
            return redirect()->route('recepcionCompra.consultar');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function consultar()
    {
        $recepcionesSinCompletar = RecepcionCompra::where('estado', false)->get();
        $recepcionesCompletas = RecepcionCompra::where('estado', true)->get();
        return view('recepcionCompra.consultar', compact('recepcionesCompletas', 'recepcionesSinCompletar'));
    }
}

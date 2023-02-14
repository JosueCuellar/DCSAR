<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetalleCompraRequest;
use App\Models\DetalleCompra;
use App\Models\Producto;
use App\Models\RecepcionCompra;
use Illuminate\Http\Request;

class DetalleCompraController extends Controller
{
    //

    public function index(RecepcionCompra $recepcionCompra)
    {
        $detalleCompra = DetalleCompra::where('recepcionCompra_id', $recepcionCompra->id)->get();
        $productos = Producto::all();
        return view('detalleCompra.index', compact('detalleCompra', 'productos'));
    }

    public function create(RecepcionCompra $recepcionCompra)
    {
        try {
            $detalleCompra = DetalleCompra::where('recepcionCompra_id', $recepcionCompra->id)->get();
            $productos = Producto::all();
            return view('detalleCompra.create', compact('recepcionCompra', 'detalleCompra', 'productos'));
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function store(DetalleCompraRequest $request, RecepcionCompra $recepcionCompra)
    {
        try {
            $detalleCompra =  new DetalleCompra();
            $detalleCompra->recepcionCompra_id = $recepcionCompra->id;
            $detalleCompra->producto_id = $request->producto_id;
            $detalleCompra->cantidadIngreso = $request->cantidadIngreso;
            $detalleCompra->precioUnidad = $request->precioUnidad;
            $detalleCompra->fechaVenc = $request->fechaVenc;
            $detalleCompra->save();

            return redirect()->route('recepcionCompra.detalle', $recepcionCompra);
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function edit(RecepcionCompra $recepcionCompra, DetalleCompra $detalleCompra)
    {
        $productos = Producto::all();
        return view('detalleCompra.edit', compact('recepcionCompra', 'detalleCompra', 'productos'));
    }


    public function update(DetalleCompraRequest $request, RecepcionCompra $recepcionCompra, DetalleCompra $detalleCompra)
    {

        try {
            //Se guardan los nuevos datos del detalle del ingreso
            $detalleCompra->recepcionCompra_id = $recepcionCompra->id;
            $detalleCompra->producto_id = $request->producto_id;
            $detalleCompra->cantidadIngreso = $request->cantidadIngreso;
            $detalleCompra->precioUnidad = $request->precioUnidad;
            $detalleCompra->fechaVenc = $request->fechaVenc;
            $detalleCompra->update();

            return redirect()->route('recepcionCompra.detalle', $recepcionCompra);
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function destroy(RecepcionCompra $recepcionCompra, DetalleCompra $detalleCompra)
    {
        $detalleCompra->delete();
        return redirect()->route('recepcionCompra.detalle', $recepcionCompra);
    }
}

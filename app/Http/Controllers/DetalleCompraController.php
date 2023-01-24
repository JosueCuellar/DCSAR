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

    public function index(RecepcionCompra $ingreso)
    {
        $detalleCompra = DetalleCompra::where('recepcionCompra_id', $ingreso->id)->get();
        $productos = Producto::all();
        return view('detalleCompra.index', compact('detalleCompra', 'productos'));
    }

    public function create(RecepcionCompra $ingreso)
    {
        try {
            $detalleCompra = DetalleCompra::where('recepcionCompra_id', $ingreso->id)->get();
            $productos = Producto::all();
            return view('detalleCompra.create', compact('ingreso', 'detalleCompra', 'productos'));
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function store(DetalleCompraRequest $request, RecepcionCompra $ingreso)
    {
        try{
            $detalleCompra =  new DetalleCompra();
            $detalleCompra->recepcionCompra_id = $ingreso->id;
            $detalleCompra->producto_id = $request->producto_id;
            $detalleCompra->cantidadIngreso = $request->cantidadIngreso;
            $detalleCompra->precioUnidad = $request->precioUnidad;
            $detalleCompra->fechaVenc = $request->fechaVenc;
            $detalleCompra->save();

            return redirect()->route('recepcionCompra.detalle', $ingreso);
        } catch(\Exception $e){
            $e->getMessage();
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetalleCompraRequest;
use App\Models\Bodega;
use App\Models\DetalleCompra;
use App\Models\DetalleRequisicion;
use App\Models\DocumentoXCompra;
use App\Models\Lote;
use App\Models\Producto;
use App\Models\RecepcionCompra;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class DetalleCompraController extends Controller
{
    //

    public function index(RecepcionCompra $recepcionCompra)
    {
        $detalleCompra = DetalleCompra::where('recepcionCompra_id', $recepcionCompra->id)->get();
        $productos = Producto::all();
        $bodegas = Bodega::all();
        return view('detalleCompra.index', compact('detalleCompra', 'productos', 'bodegas'));
    }

    public function create(RecepcionCompra $recepcionCompra)
    {
        try {
            $bodegas = Bodega::all();

            $currentStep = "3.Ingreso de productos"; //Paso actual
            $labelBar = ["1.Recepcion de compra", "2.Subir documentos del ingreso", "3.Ingreso de productos"]; // Array con los números de los pasos
                $totalFinal = 0;
            $detalleCompra = DetalleCompra::where('recepcionCompra_id', $recepcionCompra->id)->get();
            $productos = Producto::all();
            foreach($detalleCompra as $item){
                $totalFinal += $item->total;
            }
            $documentos  = DocumentoXCompra::where('recepcionCompra_id', $recepcionCompra->id)->get();
            return view('detalleCompra.create', compact('recepcionCompra', 'detalleCompra', 'productos', 'bodegas', 'documentos', 'totalFinal','labelBar', 'currentStep'));
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function store(DetalleCompraRequest $request, RecepcionCompra $recepcionCompra)
    {
            $total = ($request->cantidadIngreso) * ($request->precioUnidad);
        try {
            $deta = DetalleCompra::all();
            $n = count($deta)+1;
            $detalleCompra =  new DetalleCompra();
            $detalleCompra->producto_id = $request->producto_id;
            $detalleCompra->recepcionCompra_id = $recepcionCompra->id;
            $detalleCompra->cantidadIngreso = $request->cantidadIngreso;
            $detalleCompra->precioUnidad = $request->precioUnidad;
            $detalleCompra->total = $total;
            $detalleCompra->save();


            $lote = new Lote();
            $lote->detalleCompra_id = $detalleCompra->id;
            $lote->producto_id = $request->producto_id;
            $lote->fechaVencimiento = $request->fechaVenc;
            $lote->cantidadDisponible = $request->cantidadIngreso;

            $lote->save();

            return redirect()->route('recepcionCompra.detalle', $recepcionCompra)->with('status', 'Se ha agregado correctamente el producto');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit(RecepcionCompra $recepcionCompra, DetalleCompra $detalleCompra)
    {
        $productos = Producto::all();
        return view('detalleCompra.edit', compact('recepcionCompra', 'detalleCompra', 'productos'));
    }


    public function update(DetalleCompraRequest $request, RecepcionCompra $recepcionCompra, DetalleCompra $detalleCompra)
    {
        $total = ($request->cantidadIngreso) * ($request->precioUnidad);
        // $producto_id = $request->producto_id;
        try {
            //Se guardan los nuevos datos del detalle del ingreso
            $detalleCompra->recepcionCompra_id = $recepcionCompra->id;
            $detalleCompra->producto_id = $request->producto_id;
            $detalleCompra->cantidadIngreso = $request->cantidadIngreso;
            $detalleCompra->precioUnidad = $request->precioUnidad;
            $detalleCompra->total = $total;
            $detalleCompra->update();

            // $cProm = $this->costoPromedio($producto_id);
            // $productoA = Producto::where('id', $producto_id)->first();
            // $productoA->costoPromedio = $cProm;
            // $productoA->save();

            return redirect()->route('recepcionCompra.detalle', $recepcionCompra)->with('status', 'Se ha agregado correctamente el producto');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function destroy(RecepcionCompra $recepcionCompra, DetalleCompra $detalleCompra)
    {
        // $producto_id = $detalleCompra->producto_id;
        // $cProm = $this->costoPromedio($producto_id);

        $detalleCompra->delete();
        // $productoA = Producto::where('id', $producto_id)->first();
        // $productoA->costoPromedio = $cProm;
        // $productoA->save();
        return redirect()->route('recepcionCompra.detalle', $recepcionCompra)->with('delete', 'Se ha eliminado el detalle del producto');
    }

    // public function costoPromedio($producto){
    //     $existencias = 0;$saldoTotal = 0;$costoPromedio = 0;$sumaCompras=0;
    //     $sumaRequi = 0;$cantidadCompra = 0;$cantidadRequi = 0;
    //     $detalleCompras = DetalleCompra::where('producto_id', $producto)->get();                
    //     foreach($detalleCompras as $itemCompra){
    //         $cantidadCompra += $itemCompra->cantidadIngreso;
    //         $sumaCompras += $itemCompra->total;
    //     }  
    //     $detalleRequisicion = DetalleRequisicion::where('producto_id', $producto)->where('estado_id', 3)->get();
    //     foreach($detalleRequisicion as $itemRequi){
    //         $cantidadRequi = $itemRequi->cantidad;
    //         $sumaRequi += $itemRequi->total;
    //     }   
    //     $saldoTotal = $sumaCompras - $sumaRequi;
    //     $existencias = $cantidadCompra - $cantidadRequi;
    //     $costoPromedio = $saldoTotal/$existencias;
    //     return $costoPromedio;
    // }


}

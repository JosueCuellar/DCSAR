<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecepcionCompraRequest;
use App\Models\DetalleCompra;
use App\Models\DetalleRequisicion;
use App\Models\DocumentoXCompra;
use App\Models\Producto;
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
            // $recepcionCompra->nCompromiso = $request->nCompromiso;
            $recepcionCompra->actaRecepcion = $request->actaRecepcion;
            $recepcionCompra->codigoFactura = $request->codigoFactura;
            $recepcionCompra->save();
            return redirect()->route('recepcionCompra.detalle', $recepcionCompra);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Algo salio mal!');
        }
    }


    public function update(Request $request, RecepcionCompra $recepcionCompra)
    {
        try {
            $recepcionCompra->estado = true;
            $detallesCompra = DetalleCompra::where('recepcionCompra_id', $recepcionCompra->id)->get();
            foreach($detallesCompra as $detalle){
                $producto_id = $detalle->producto_id;
                $cProm = $this->costoPromedio($producto_id);
                $productoA = Producto::where('id', $producto_id)->first();
                $productoA->costoPromedio = $cProm;
                $productoA->save();
            }
            $recepcionCompra->save();
            return redirect()->route('recepcionCompra.consultar')->with('status', 'Registro correcto');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Algo salio mal!');
        }
    }

    public function consultar()
    {
        $recepcionesSinCompletar = RecepcionCompra::where('estado', false)->get();
        foreach ($recepcionesSinCompletar as $item) {
            $item->delete();
        }
        $recepcionesCompletas = RecepcionCompra::where('estado', true)->get();
        return view('recepcionCompra.consultar', compact('recepcionesCompletas'));
    }

    public function revisar(RecepcionCompra $recepcionCompra)
    {
        $totalFinal = 0;
        $detalleCompra = DetalleCompra::where('recepcionCompra_id',$recepcionCompra->id)->get();
        foreach($detalleCompra as $item){
            $totalFinal += $item->total;
        }
        $documentos  = DocumentoXCompra::where('recepcionCompra_id', $recepcionCompra->id)->get();
        return view('recepcionCompra.revisar', compact('documentos', 'detalleCompra', 'recepcionCompra','totalFinal'));
    }

        public function costoPromedio($producto){
        $existencias = 0;$saldoTotal = 0;$costoPromedio = 0;$sumaCompras=0;
        $sumaRequi = 0;$cantidadCompra = 0;$cantidadRequi = 0;
        $detalleCompras = DetalleCompra::where('producto_id', $producto)->get();                
        foreach($detalleCompras as $itemCompra){
            $cantidadCompra += $itemCompra->cantidadIngreso;
            $sumaCompras += $itemCompra->total;
        }  
        $detalleRequisicion = DetalleRequisicion::where('producto_id', $producto)->get();
        if(count($detalleRequisicion) > 0){
            foreach($detalleRequisicion as $itemRequi){
                $cantidadRequi = $itemRequi->cantidad;
                $sumaRequi += $itemRequi->total;
            }   
        }

        $saldoTotal = $sumaCompras - $sumaRequi;
        $existencias = $cantidadCompra - $cantidadRequi;
        $costoPromedio = $saldoTotal/$existencias;
        return $costoPromedio;
    }

    public function destroy(RecepcionCompra $recepcionCompra)
    {
        try{
            $recepcionCompra->delete();
            return redirect()->route('recepcionCompra.consultar')->with('delete', 'Registro eliminado');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'Algo salio mal!');
        }

    }

}

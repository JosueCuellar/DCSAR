<?php

namespace App\Http\Controllers;

use App\Models\DetalleRequisicion;
use App\Models\Lote;
use App\Models\ProductoBodega;
use App\Models\RequisicionProducto;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Termwind\Components\BreakLine;

class RequisicionProductoController extends Controller
{
    //
    public function index(Request $request)
    {
        try {
            $fecha_requisicion = $request->get('fecha_requisicion');
            $requisiciones = RequisicionProducto::where('estado_id', 1)->fechaRequisicion($fecha_requisicion)->get();
            $requisicionesSinCompletar = RequisicionProducto::where('estado_id', 5)->get();
            foreach ($requisicionesSinCompletar as $item) {
                $item->delete();
            }
            return view('requisicionProducto.index', compact('requisiciones', 'request'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Algo salio mal!');
        }
    }

    public function estado()
    {
        $requisicionesEnviadas = RequisicionProducto::where('estado_id', 1)->get();
        $nEnviadas = count($requisicionesEnviadas);
        $requisicionesAprobadas = RequisicionProducto::where('estado_id', 2)->get();
        $nAprobadas = count($requisicionesAprobadas);
        $requisicionesRechazadas = RequisicionProducto::where('estado_id', 3)->get();
        $nRechazadas = count($requisicionesRechazadas);

        return view('requisicionProducto.estado', compact('requisicionesEnviadas', 'requisicionesAprobadas', 'requisicionesRechazadas', 'nEnviadas', 'nAprobadas', 'nRechazadas'));
    }

    public function revisar()
    {
        $requisicionesEnviadas = RequisicionProducto::where('estado_id', 1)->get();
        return view('requisicionProducto.revisar', compact('requisicionesEnviadas'));
    }

    public function entrega()
    {
        $requisicionesAprobadas = RequisicionProducto::where('estado_id', 2)->get();
        return view('requisicionProducto.entrega', compact('requisicionesAprobadas'));
    }

    public function requisicionRecibida()
    {
        $requisicionRecibidas = RequisicionProducto::where('estado_id', 4)->get();

        return view('requisicionProducto.requiRealizada', compact('requisicionRecibidas'));
    }

    public function store(Request $request)
    {
        $requisicionProducto = new RequisicionProducto();
        $date =  new DateTime();
        $requisicionProducto->fecha_requisicion = $date->format('Y-m-d H:i:s');
        $requisicionProducto->estado_id = 5;
        $requisicionProducto->save();
        return redirect()->route('requisicionProducto.detalle', $requisicionProducto);
    }


    public function update(Request $request, RequisicionProducto $requisicionProducto)
    {
        $requisicionProducto->estado_id =  1;
        $requisicionProducto->descripcion = $request->descripcion;
        $requisicionProducto->save();
        return  redirect()->route('requisicionProducto.index')->with('status', 'Registro correcto');
    }


    public function requisicionEntregada(RequisicionProducto $requisicionProducto)
    {
        try {
            $requisicionProducto->estado_id =  4;
            $detallesRequi = DetalleRequisicion::where('requisicion_id', $requisicionProducto->id)->get();
            foreach ($detallesRequi as $detalle) {
                $producto_id = $detalle->producto_id;
                $this->reset($detalle->id);
                $detalle->save();


                // Se realiza la salida de cada lote dependiendo la cantidad de productos que se requieran
                $lotes = Lote::where('producto_id', $producto_id)->where('cantidad_disponible', '>', 0)->orderBy('id', 'asc')->get();
                foreach ($lotes as $lote) {
                    $deta = DetalleRequisicion::where('requisicion_id', $requisicionProducto->id)->where('producto_id', $producto_id)->first();
                    $cantidadDescontar = $deta->cantidad_entregada; //50
                    if ($cantidadDescontar > 0) {
                        if ($lote->cantidad_disponible < $cantidadDescontar) { //50
                            $deta->cantidad_entregada -= $lote->cantidad_disponible; //-10 hay 40
                            $deta->save();
                            $lote->cantidad_disponible = 0;
                        } else {
                            $diferencia = $lote->cantidad_disponible - $deta->cantidad_entregada; // 50 - 1
                            $deta->cantidad_entregada = 0; //-10 hay 40
                            $deta->save();
                            $lote->cantidad_disponible = $diferencia;
                        }
                        // Explicit save operation
                        $lote->save();
                    }

                    if ($cantidadDescontar === 0) {
                        break;
                    }
                    
                }

                $this->reset($detalle->id);


                $bodegas = ProductoBodega::where('producto_id', $producto_id)->where('cantidad_disponible', '>', 0)->orderBy('id', 'asc')->get();
                foreach ($bodegas as $bodega) {
                    $detaBodega = DetalleRequisicion::where('requisicion_id', $requisicionProducto->id)->where('producto_id', $producto_id)->first();                    
                    $cantDesc = $detaBodega->cantidad_entregada;
                    if ($cantDesc > 0) {
                        if ($bodega->cantidad_disponible < $cantDesc) { //50
                            $detaBodega->cantidad_entregada -= $bodega->cantidad_disponible; //-10 hay 40
                            $detaBodega->save();
                            $bodega->cantidad_disponible = 0;
                        } else {
                            $dif = $bodega->cantidad_disponible - $detaBodega->cantidad_entregada; // 50 - 1
                            $detaBodega->cantidad_entregada = 0; //-10 hay 40
                            $detaBodega->save();
                            $bodega->cantidad_disponible = $dif;
                            $bodega->save();

                        }
                        // Explicit save operation
                        $bodega->save();
                    } 
                    if ($cantDesc === 0) {
                        break;
                    }
                }
            }

            $requisicionProducto->save();
            return  redirect()->route('requisicionProducto.entrega')->with('status', 'Registro correcto');
        } catch (\Exception $e) {
            return  redirect()->route('requisicionProducto.entrega')->with('msg', 'Error' . $e->getMessage());
        }
    }

    
    public function reset($id)
    {
        $registro = DetalleRequisicion::find($id);
        $registro->cantidad_entregada += $registro->cantidad ;
        $registro->save();
    }

    public function aceptar(Request $request, RequisicionProducto $requisicionProducto)
    {
        $requisicionProducto->estado_id =  2;
        $nR = 1;
        $date = new Carbon();
        $n = DB::select("SELECT COUNT(id) AS nRequi FROM requisicion_productos WHERE nCorrelativo IS NOT NULL;");
        foreach ($n as $item) {
            $nR += $item->nRequi;
        }
        if ($nR < 10)
            $requisicionProducto->nCorrelativo =  '0' . $nR . '-' . $date->format('Y');
        else
            $requisicionProducto->nCorrelativo =  $nR . '-' . $date->format('Y');
        $requisicionProducto->observacion = $request->observacion;
        $requisicionProducto->save();
        return  redirect()->route('requisicionProducto.revisar');
    }

    public function denegar(Request $request, RequisicionProducto $requisicionProducto)
    {
        $requisicionProducto->estado_id =  3;
        $requisicionProducto->observacion = $request->observacion;
        $requisicionProducto->save();
        return  redirect()->route('requisicionProducto.revisar');
    }

    public function destroy(RequisicionProducto $requisicionProducto)
    {
        $requisicionProducto->delete();
        return redirect()->route('requisicionProducto.index')->with('delete', 'Registro eliminado');
    }
}

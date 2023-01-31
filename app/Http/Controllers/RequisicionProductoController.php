<?php

namespace App\Http\Controllers;

use App\Models\RequisicionProducto;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequisicionProductoController extends Controller
{
    //
    public function index(Request $request)
    {
        $fecha_requisicion = $request->get('fecha_requisicion');
        $requisiciones = RequisicionProducto::where('estado_id', 1)->fechaRequisicion($fecha_requisicion)->get();
        $requisicionesSinCompletar = RequisicionProducto::where('estado_id',2)->get();
        return view('requisicionProducto.index', compact('requisiciones','requisicionesSinCompletar','request'));
    }

    public function estado()
    {
        $requisicionesEnviadas = RequisicionProducto::where('estado_id', 1)->get();
        $requisicionesAprobadas = RequisicionProducto::where('estado_id',3)->get();
        $requisicionesRechazadas = RequisicionProducto::where('estado_id',4)->get();
        return view('requisicionProducto.estado', compact('requisicionesEnviadas','requisicionesAprobadas','requisicionesRechazadas'));
    }

    public function store(Request $request)
    {
        $nR = 1;
        $n = DB::select("SELECT COUNT(id) AS nRequi FROM requisicion_productos;");
        foreach($n as $item){
            $nR .= $item->nRequi;
        }
        $requisicionProducto = new RequisicionProducto();
        $date = new Carbon();
        $requisicionProducto->fecha_requisicion =  new DateTime();
        $requisicionProducto->nCorrelativo =  $nR.'-'.$date->format('Y');;
        $requisicionProducto->estado_id = 2;
        $requisicionProducto->save();
        return redirect()->route('requisicionProducto.detalle',$requisicionProducto);
    }


    public function update(Request $request, RequisicionProducto $requisicionProducto)
    {
        $requisicionProducto->estado_id =  1;
        $requisicionProducto->save();
        return  redirect()->route('requisicionProducto.index');
    }
}

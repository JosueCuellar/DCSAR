<?php

namespace App\Http\Controllers;

use App\Models\RequisicionProducto;
use DateTime;
use Illuminate\Http\Request;

class RequisicionProductoController extends Controller
{
    //
    public function index(Request $request)
    {
        $fecha_requisicion = $request->get('fecha_requisicion');
        $requisiciones = RequisicionProducto::where('estado',true)->fechaRequisicion($fecha_requisicion)->get();
        $requisicionesSinCompletar = RequisicionProducto::where('estado',false)->get();
        return view('requisicionProducto.index', compact('requisiciones','requisicionesSinCompletar','request'));
    }
    public function store(Request $request)
    {
        $requisicionProducto = new RequisicionProducto();
        $requisicionProducto->fecha_requisicion =  new DateTime();
        $requisicionProducto->estado = false;
        $requisicionProducto->save();
        return redirect()->route('requisicionProducto.detalle',$requisicionProducto);
    }


    public function update(Request $request, RequisicionProducto $requisicionProducto)
    {
        $requisicionProducto->estado =  true;
        $requisicionProducto->save();
        return  redirect()->route('requisicionProducto.index');
    }
}

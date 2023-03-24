<?php

namespace App\Http\Controllers;

use App\Models\RequisicionProducto;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $existe = false;
        $requisicionesEnviadas = RequisicionProducto::where('estado_id', 1)->get();
        $n = count($requisicionesEnviadas);
        if($n > 0)$existe = true;else $existe = false;

        $requisicionesEnviadas = RequisicionProducto::where('estado_id', 1)->get();
        $nEnviadas = count($requisicionesEnviadas);
        $requisicionesAprobadas = RequisicionProducto::where('estado_id',2)->get();
        $nAprobadas = count($requisicionesAprobadas);
        $requisicionesRechazadas = RequisicionProducto::where('estado_id',3)->get();
        $nRechazadas = count($requisicionesRechazadas);
        $requisicionesRecibidas = RequisicionProducto::where('estado_id',4)->get();
        $nRecibidas = count($requisicionesRecibidas);

        return view('dashboard', compact('n', 'existe','nEnviadas','nAprobadas','nRechazadas', 'nRecibidas'));
    }
}

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
        if($n > 0)$existe = true;

        return view('dashboard', compact('n', 'existe'));
    }
}

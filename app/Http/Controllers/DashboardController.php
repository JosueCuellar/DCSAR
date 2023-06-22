<?php

namespace App\Http\Controllers;

use App\Models\RequisicionProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
	//

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$existe = false;
		$requisicionesEnviadas = RequisicionProducto::where('estado_id', 1)
			->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
			->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
			->select('requisicion_productos.*')
			->get();
		$n = count($requisicionesEnviadas);
		if ($n > 0) $existe = true;
		else $existe = false;

		$requisicionesEnviadas = RequisicionProducto::where('estado_id', 1)->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
			->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
			->select('requisicion_productos.*')
			->get();
		$nEnviadas = count($requisicionesEnviadas);
		$requisicionesAprobadas = RequisicionProducto::where('estado_id', 2)->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
			->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
			->select('requisicion_productos.*')
			->get();
		$nAprobadas = count($requisicionesAprobadas);
		$requisicionesRechazadas = RequisicionProducto::where('estado_id', 3)->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
			->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
			->select('requisicion_productos.*')
			->get();
		$nRechazadas = count($requisicionesRechazadas);
		$requisicionesRecibidas = RequisicionProducto::where('estado_id', 4)->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
			->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
			->select('requisicion_productos.*')
			->get();
		$nRecibidas = count($requisicionesRecibidas);

		return view('dashboard', compact('n', 'existe', 'nEnviadas', 'nAprobadas', 'nRechazadas', 'nRecibidas'));
	}

	public function indexAdmin()
	{

		return view('administrador.dashboard');
	}
}

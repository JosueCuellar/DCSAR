<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\RequisicionProducto;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
	// Constructor de la clase
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$existeEnviadas = $existeRechazadas = $existeAceptadas = false;
		$ENVIADA = config('constantes.ENVIADA');
		$requisicionesEnviadas = RequisicionProducto::where('estado_id', $ENVIADA)->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
			->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
			->select('requisicion_productos.*')
			->get();
		// Contar el número de requisiciones enviadas
		$nEnviadas = count($requisicionesEnviadas);
		($nEnviadas > 0) ? $existeEnviadas = true : $existeEnviadas = false;
		//Constante para el estado aceptada --Se define dentro de config/constantes.php--
		$ACEPTADA = config('constantes.ACEPTADA');
		// Obtener las requisiciones aprobadas y que pertenecen a la misma unidad organizativa del usuario autenticado
		$requisicionesAprobadas = RequisicionProducto::where('estado_id', $ACEPTADA)->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
			->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
			->select('requisicion_productos.*')
			->get();

		$requisicionesAprobadasTodas = RequisicionProducto::where('estado_id', $ACEPTADA)->get();

		// Contar el número de requisiciones aprobadas
		$nAprobadas = count($requisicionesAprobadas);
		
		$nAprobadasTodas = count($requisicionesAprobadasTodas);
		($nAprobadasTodas > 0) ? $existeAceptadas = true : $existeAceptadas = false;

		//Constante para el estado rechazada --Se define dentro de config/constantes.php--
		$RECHAZADA = config('constantes.RECHAZADA');
		// Obtener las requisiciones rechazadas y que pertenecen a la misma unidad organizativa del usuario autenticado
		$requisicionesRechazadas = RequisicionProducto::where('estado_id', $RECHAZADA)->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
			->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
			->select('requisicion_productos.*')
			->get();

		// Contar el número de requisiciones rechazadas
		$nRechazadas = count($requisicionesRechazadas);
		($nRechazadas > 0) ? $existeRechazadas = true : $existeRechazadas = false;
		//Constante para el estado entregada --Se define dentro de config/constantes.php--
		$ENTREGADA = config('constantes.ENTREGADA');
		// Obtener las requisiciones recibidas y que pertenecen a la misma unidad organizativa del usuario autenticado
		$requisicionesRecibidas = RequisicionProducto::where('estado_id', $ENTREGADA)->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
			->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
			->select('requisicion_productos.*')
			->get();

		// Contar el número de requisiciones recibidas
		$nRecibidas= count($requisicionesRecibidas);

		// Retornar la vista 'dashboard' con las variables compactadas
		return view('dashboard.dashboard', compact('existeEnviadas', 'existeRechazadas', 'existeAceptadas', 'nEnviadas', 'nAprobadas', 'nAprobadasTodas', 'nRechazadas', 'nRecibidas'));
	}

	public function indexAdmin()
	{
		return view('dashboard.dashboardAdmin');
	}
}

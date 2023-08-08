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
		// Aplicar el middleware 'auth' para verificar si el usuario está autenticado
		$this->middleware('auth');
	}

	public function index()
	{
		// Inicializar la variable $existe en falso
		$existe = false;
		//Constante para el estado enviada --Se define dentro de config/constantes.php--
		$ENVIADA = config('constantes.ENVIADA');
		// Obtener las requisiciones enviadas con estado_id igual a 1 y que pertenecen a la misma unidad organizativa del usuario autenticado
		$requisicionesEnviadas = RequisicionProducto::where('estado_id', $ENVIADA)
			->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
			->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
			->select('requisicion_productos.*')
			->get();

		// Contar el número de requisiciones enviadas
		$n = count($requisicionesEnviadas);

		// Si el número de requisiciones enviadas es mayor que 0, asignar verdadero a la variable $existe, de lo contrario asignar falso
		if ($n > 0) $existe = true;
		else $existe = false;

		// Obtener las requisiciones enviadas y que pertenecen a la misma unidad organizativa del usuario autenticado
		$requisicionesEnviadas = RequisicionProducto::where('estado_id', $ENVIADA)->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
			->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
			->select('requisicion_productos.*')
			->get();

		// Contar el número de requisiciones enviadas
		$nEnviadas = count($requisicionesEnviadas);
		//Constante para el estado aceptada --Se define dentro de config/constantes.php--
		$ACEPTADA = config('constantes.ACEPTADA');
		// Obtener las requisiciones aprobadas y que pertenecen a la misma unidad organizativa del usuario autenticado
		$requisicionesAprobadas = RequisicionProducto::where('estado_id', $ACEPTADA)->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
			->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
			->select('requisicion_productos.*')
			->get();

		// Contar el número de requisiciones aprobadas
		$nAprobadas = count($requisicionesAprobadas);
		//Constante para el estado rechazada --Se define dentro de config/constantes.php--
		$RECHAZADA = config('constantes.RECHAZADA');
		// Obtener las requisiciones rechazadas y que pertenecen a la misma unidad organizativa del usuario autenticado
		$requisicionesRechazadas = RequisicionProducto::where('estado_id', $RECHAZADA)->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
			->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
			->select('requisicion_productos.*')
			->get();

		// Contar el número de requisiciones rechazadas
		$nRechazadas = count($requisicionesRechazadas);
		//Constante para el estado entregada --Se define dentro de config/constantes.php--
		$ENTREGADA = config('constantes.ENTREGADA');
		// Obtener las requisiciones recibidas y que pertenecen a la misma unidad organizativa del usuario autenticado
		$requisicionesRecibidas = RequisicionProducto::where('estado_id', $ENTREGADA)->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
			->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
			->select('requisicion_productos.*')
			->get();

		// Contar el número de requisiciones recibidas
		$nRecibidas = count($requisicionesRecibidas);

		// Retornar la vista 'dashboard' con las variables compactadas
		return view('dashboard.dashboard', compact('n', 'existe', 'nEnviadas', 'nAprobadas', 'nRechazadas', 'nRecibidas'));
	}

	public function indexAdmin()
	{
		return view('dashboard.dashboardAdmin');
	}
}

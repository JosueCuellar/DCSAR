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

	/**
	 * Muestra el panel de control del usuario autenticado con información sobre las requisiciones en diferentes estados.
	 *
	 * @return \Illuminate\Contracts\View\View
	 */
	public function index()
	{
		// Inicializar banderas para verificar si existen requisiciones en diferentes estados
		$existeEnviadas = $existeRechazadas = $existeAceptadas = false;

		// Constante para el estado ENVIADA --Se define dentro de config/constantes.php--
		$ENVIADA = config('constantes.ENVIADA');

		// Obtener las requisiciones enviadas que pertenecen a la misma unidad organizativa del usuario autenticado
		$requisicionesEnviadas = RequisicionProducto::where('estado_id', $ENVIADA)
			->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
			->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
			->select('requisicion_productos.*')
			->get();

		// Contar el número de requisiciones enviadas
		$nEnviadas = count($requisicionesEnviadas);
		$existeEnviadas = ($nEnviadas > 0);

		// Constante para el estado ACEPTADA --Se define dentro de config/constantes.php--
		$ACEPTADA = config('constantes.ACEPTADA');

		// Obtener las requisiciones aprobadas que pertenecen a la misma unidad organizativa del usuario autenticado
		$requisicionesAprobadas = RequisicionProducto::where('estado_id', $ACEPTADA)
			->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
			->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
			->select('requisicion_productos.*')
			->get();

		// Obtener todas las requisiciones aprobadas
		$requisicionesAprobadasTodas = RequisicionProducto::where('estado_id', $ACEPTADA)->get();

		// Contar el número de requisiciones aprobadas
		$nAprobadas = count($requisicionesAprobadas);
		$nAprobadasTodas = count($requisicionesAprobadasTodas);
		$existeAceptadas = ($nAprobadasTodas > 0);

		// Constante para el estado RECHAZADA --Se define dentro de config/constantes.php--
		$RECHAZADA = config('constantes.RECHAZADA');

		// Obtener las requisiciones rechazadas que pertenecen a la misma unidad organizativa del usuario autenticado
		$requisicionesRechazadas = RequisicionProducto::where('estado_id', $RECHAZADA)
			->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
			->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
			->select('requisicion_productos.*')
			->get();

		// Contar el número de requisiciones rechazadas
		$nRechazadas = count($requisicionesRechazadas);
		$existeRechazadas = ($nRechazadas > 0);

		// Constante para el estado ENTREGADA --Se define dentro de config/constantes.php--
		$ENTREGADA = config('constantes.ENTREGADA');

		// Obtener las requisiciones entregadas que pertenecen a la misma unidad organizativa del usuario autenticado
		$requisicionesRecibidas = RequisicionProducto::where('estado_id', $ENTREGADA)
			->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
			->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
			->select('requisicion_productos.*')
			->get();

		// Contar el número de requisiciones entregadas
		$nRecibidas = count($requisicionesRecibidas);

		// Retornar la vista 'dashboard' con las variables compactadas
		return view('dashboard.dashboard', compact(
			'existeEnviadas',
			'existeRechazadas',
			'existeAceptadas',
			'nEnviadas',
			'nAprobadas',
			'nAprobadasTodas',
			'nRechazadas',
			'nRecibidas'
		));
	}

	/**
	 * Muestra el panel de control para el usuario administrador.
	 *
	 * @return \Illuminate\Contracts\View\View
	 */
	public function indexAdmin()
	{
		// Retorna la vista 'dashboardAdmin'
		return view('dashboard.dashboardAdmin');
	}
}

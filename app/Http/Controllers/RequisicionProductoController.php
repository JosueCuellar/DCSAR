<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequisicionProductoUpdateRequest;
use App\Models\DetalleRequisicion;
use App\Models\ProductoBodega;
use App\Models\RequisicionProducto;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ReporteController;

class RequisicionProductoController extends Controller
{
	//Metodo que se encarga de visualizar las requisiciones enviadas para la revision
	public function index(Request $request)
	{
		try {
			$fechaRequisicion = $request->get('fechaRequisicion');
			$requisiciones = RequisicionProducto::where('estado_id', 1)
				->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
				->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
				->fechaRequisicion($fechaRequisicion)
				->select('requisicion_productos.*')
				->get();

			$requisicionesSinCompletar = RequisicionProducto::where('estado_id', 5)
				->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
				->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
				->get();
			foreach ($requisicionesSinCompletar as $item) {
				$item->delete();
			}
			return view('requisicionProducto.index', compact('requisiciones', 'request'));
		} catch (\Exception $e) {
			return redirect()->back()->with('error', 'Algo salio mal!');
		}
	}

	//Envia los estados de las requisiciones enviadas, aprobadas y rechazadas
	public function estado()
	{
		$requisicionesEnviadas = RequisicionProducto::where('estado_id', 1)
			->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
			->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
			->select('requisicion_productos.*')
			->get();
		$nEnviadas = count($requisicionesEnviadas);
		$requisicionesAprobadas = RequisicionProducto::where('estado_id', 2)
			->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
			->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
			->select('requisicion_productos.*')
			->get();
		$nAprobadas = count($requisicionesAprobadas);
		$requisicionesRechazadas = RequisicionProducto::where('estado_id', 3)
			->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
			->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
			->select('requisicion_productos.*')
			->get();
		$nRechazadas = count($requisicionesRechazadas);

		return view('requisicionProducto.estado', compact('requisicionesEnviadas', 'requisicionesAprobadas', 'requisicionesRechazadas', 'nEnviadas', 'nAprobadas', 'nRechazadas'));
	}

	//Muestra el panel de Revision de solicitudes enviadas, es el panel que ve el Gerente de cada Unidad Organizativa
	public function revisar()
	{
		$requisicionesEnviadas = RequisicionProducto::where('estado_id', 1)
			->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
			->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
			->select('requisicion_productos.*')
			->get();

		return view('requisicionProducto.revisar', compact('requisicionesEnviadas'));
	}

	//Muestra el panel de Requisicon a entregar, que ve el Encargado de Almacen para confirmar que los productos han sido enviados
	public function entrega()
	{
		$requisicionesAprobadas = RequisicionProducto::where('estado_id', 2)->get();
		return view('requisicionProducto.entrega', compact('requisicionesAprobadas'));
	}

	//Muestra una tabla con todas las requisiciones que han sido entregadas
	public function requisicionRecibida()
	{
		$requisicionRecibidas = RequisicionProducto::where('estado_id', 4)
			->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
			->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
			->select('requisicion_productos.*')
			->get();

		return view('requisicionProducto.requiRealizada', compact('requisicionRecibidas'));
	}
	//Muestra una tabla con todas las requisiciones que han sido entregadas
	public function historialRequi()
	{
		$requisicionRecibidas = RequisicionProducto::where('estado_id', 4)->get();
		return view('requisicionProducto.historialRequi', compact('requisicionRecibidas'));
	}

	//Metodo que sirve para inicializar cada requisicion que se creara
	public function store(Request $request)
	{
		$requisicionProducto = new RequisicionProducto();
		$date =  new DateTime();
		$requisicionProducto->fechaRequisicion = $date->format('Y-m-d H:i:s');
		$requisicionProducto->estado_id = 5;
		// Asignar el user_id al usuario autenticado actualmente
		$requisicionProducto->user_id = Auth::id();
		$requisicionProducto->save();
		return redirect()->route('requisicionProducto.detalle', $requisicionProducto);
	}

	//Función que permite la edición de un registro almacenado
	public function edit(RequisicionProducto $requisicionProducto)
	{
		try {
			return view('requisicionProducto.edit', compact('requisicionProducto'));
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	//Función que actualiza un registro
	public function update(RequisicionProductoUpdateRequest $request, RequisicionProducto $requisicionProducto)
	{
		try {
			$requisicionProducto->fechaRequisicion = $request->fechaRequisicion;
			$requisicionProducto->descripcion = $request->descripcion;
			$requisicionProducto->save();
			//Se redirige al listado de todos los registros
			return redirect()->route('requisicionProducto.index')->with('actualizado', 'Registro correcto');
		} catch (\Exception $e) {
			return redirect()->back()->with('msg', 'Error no se puede actualizar');
		}
	}

	//METODO QUE SE ENCARGA DE QUE SE PUEDA FINALIZAR UNA REQUISICION QUE HA SIDO INICIALIZADA (Cambia el estado a enviadas)
	public function completar(Request $request, RequisicionProducto $requisicionProducto)
	{
		try {
			Validator::extend('not_only_numbers', function ($attribute, $value, $parameters, $validator) {
				return !preg_match('/^[0-9\s]*$/', $value);
			});

			$request->validate([
				'descripcion' => ['required', 'not_only_numbers']
			]);

			$requisicionProducto->estado_id = 1;
			$requisicionProducto->descripcion = $request->descripcion;
			$requisicionProducto->save();
			return redirect()->route('requisicionProducto.index')->with('status', 'Registro correcto');
		} catch (\Exception $e) {
			return redirect()->back()->with('msg', 'Debe de ingresar un a descripcion al finalizar, ademas esta no debe de contener solo numeros');
		}
	}

	//METODO QUE SE ENCARGA DE QUE  UNA REQUISICION CAMBIE A ENTREGADA (Productos recibidos)
	public function requisicionEntregada(RequisicionProducto $requisicionProducto)
	{
		try {
			$requisicionProducto->estado_id = 4;
			$detallesRequi = DetalleRequisicion::where('requisicion_id', $requisicionProducto->id)->get();
			foreach ($detallesRequi as $detalle) {
				$producto_id = $detalle->producto_id;
				$bodegas = ProductoBodega::where('producto_id', $producto_id)->where('cantidadDisponible', '>', 0)->orderBy('id', 'asc')->get();
				$detaBodega = DetalleRequisicion::where('requisicion_id', $requisicionProducto->id)->where('producto_id', $producto_id)->first();
				$cantDesc = $detaBodega->cantidadEntregada;
				if ($cantDesc > 0) {
					foreach ($bodegas as $bodega) {
						//Si la cantidadEntregada es mayor que cantidad disponible 5000 < 100
						if ($bodega->cantidadDisponible < $cantDesc) {
							//50
							$detaBodega->cantidadEntregada -= $bodega->cantidadDisponible; //-10 hay 40
							$detaBodega->save();
							$bodega->cantidadDisponible = 0;
							// Update cantDesc after updating cantidadEntregada
							$cantDesc = $detaBodega->cantidadEntregada;
						} else {

							$dif = $bodega->cantidadDisponible - $cantDesc; // 50 - 1
							$detaBodega->cantidadEntregada = 0; //-10 hay 40
							$detaBodega->save();
							// Update cantDesc after updating cantidadEntregada
							$cantDesc = 0;
							$bodega->cantidadDisponible = $dif;
							$bodega->save();
						}
						// Explicit save operation
						$bodega->save();
					}
				}
			}
			$requisicionProducto->save();
			return redirect()->route('requisicionProducto.entrega')->with('status', 'Registro correcto');
		} catch (\Exception $e) {
			return redirect()->route('requisicionProducto.entrega')->with('msg', 'Error' . $e->getMessage());
		}
	}


	public function reset($id)
	{
		$registro = DetalleRequisicion::find($id);
		$registro->cantidadEntregada += $registro->cantidad;
		$registro->save();
	}

	public function aceptar(Request $request, RequisicionProducto $requisicionProducto)
	{
		$requisicionProducto->estado_id = 2;
		$requisicionProducto->observacion = $request->observacion;
		$countRequiApro = RequisicionProducto::where('estado_id', 2)->orderBy('id', 'desc')->first();
		$countRequiReci = RequisicionProducto::where('estado_id', 4)->orderBy('id', 'desc')->first();

		// Check if the RequisicionProducto table is empty
		if ($countRequiApro == null && $countRequiReci == null) {
			// If the table is empty, set the nCorrelativo value to 01-YYYY
			$date = new Carbon();
			$requisicionProducto->nCorrelativo = '01-' . $date->format('Y');
		} else {
			// Get the last RequisicionProducto record with estado_id = 2 or estado_id = 4 from the database, ordered by the numerical part of the nCorrelativo field
			$lastRequisicionProducto = RequisicionProducto::whereIn('estado_id', [2, 3, 4])
				->orderByRaw("CAST(LEFT(nCorrelativo, CHARINDEX('-', nCorrelativo) - 1) AS INT) DESC")
				->first();

			// Get the nCorrelativo value from the last record
			$lastNumber = $lastRequisicionProducto->nCorrelativo;


			list($number, $year) = explode('-', $lastNumber);

			// Create a new Carbon instance to get the current year
			$date = new Carbon();
			$currentYear = $date->format('Y');

			// Check if the current year is different from the year part of the last nCorrelativo value
			if ($currentYear != $year) {
				// If the years are different, reset the number part of the nCorrelativo value to 01
				$number = '01';
			} else {
				// If the years are the same, increment the number part of the nCorrelativo value
				$number = (int)$number + 1;

				// Zero-pad the number if necessary
				if ($number < 10) {
					$number = '0' . $number;
				}
			}
			// Construct the new nCorrelativo value
			$requisicionProducto->nCorrelativo = $number . '-' . $currentYear;
		}
		$requisicionProducto->save();
		return redirect()->route('requisicionProducto.revisar')->with('status', $requisicionProducto);
	}


	//METODO QUE SE ENCARGA DE QUE  UNA REQUISICION CAMBIE A DENEGADA POR EL JEFE GERENTE de cada Unidad Organizativa
	public function denegar(Request $request, RequisicionProducto $requisicionProducto)
	{
		$requisicionProducto->estado_id = 3;
		$requisicionProducto->observacion = $request->observacion;
		if (!is_null($requisicionProducto->nCorrelativo)) {
			$requisicionProducto->save();
			return redirect()->route('requisicionProducto.entrega');
		}
		$requisicionProducto->save();
		return redirect()->route('requisicionProducto.revisar');
	}


	//Se encarga de eliminar una requisicion de productos
	public function destroy(RequisicionProducto $requisicionProducto)
	{
		if ($requisicionProducto->nCorrelativo !== null) {
			return redirect()->route('requisicionProducto.estado')->with('error', 'No se puede eliminar el registro porque ya se le asigno un numero correlativo');
		}
		$requisicionProducto->delete();
		return redirect()->route('requisicionProducto.index')->with('delete', 'Registro eliminado');
	}
}

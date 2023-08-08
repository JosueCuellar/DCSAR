<?php

namespace App\Http\Controllers\RequisicionProducto;


use App\Http\Controllers\Controller;
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
			//Constante para el estado enviada --Se define dentro de config/constantes.php--
			$ENVIADA = config('constantes.ENVIADA');

			$fechaRequisicion = $request->get('fechaRequisicion');
			$requisiciones = RequisicionProducto::where('estado_id', $ENVIADA)
				->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
				->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
				->fechaRequisicion($fechaRequisicion)
				->select('requisicion_productos.*')
				->get();

			//Constante para el estado inicializada --Se define dentro de config/constantes.php--
			$INICIALIZADA = config('constantes.INICIALIZADA');
			$requisicionesSinCompletar = RequisicionProducto::where('estado_id', $INICIALIZADA)
				->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
				->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
				->get();
			foreach ($requisicionesSinCompletar as $item) {
				$item->delete();
			}
			return view('requisicionProducto.requisicionProducto.index', compact('requisiciones', 'request'));
		} catch (\Exception $e) {
			return redirect()->back()->with('error', 'Algo salio mal!');
		}
	}

	//Envia los estados de las requisiciones enviadas, aprobadas y rechazadas
	public function estado()
	{
		try {
			//Constante para el estado enviada --Se define dentro de config/constantes.php--
			$ENVIADA = config('constantes.ENVIADA');
			$requisicionesEnviadas = RequisicionProducto::where('estado_id', $ENVIADA)
				->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
				->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
				->select('requisicion_productos.*')
				->get();
			$nEnviadas = count($requisicionesEnviadas);
			//Constante para el estado aceptada --Se define dentro de config/constantes.php--
			$ACEPTADA = config('constantes.ACEPTADA');
			$requisicionesAprobadas = RequisicionProducto::where('estado_id', $ACEPTADA)
				->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
				->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
				->select('requisicion_productos.*')
				->get();
			$nAprobadas = count($requisicionesAprobadas);
			//Constante para el estado rechazada --Se define dentro de config/constantes.php--
			$RECHAZADA = config('constantes.RECHAZADA');
			$requisicionesRechazadas = RequisicionProducto::where('estado_id', $RECHAZADA)
				->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
				->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
				->select('requisicion_productos.*')
				->get();
			$nRechazadas = count($requisicionesRechazadas);

			return view('requisicionProducto.requisicionProducto.estado', compact('requisicionesEnviadas', 'requisicionesAprobadas', 'requisicionesRechazadas', 'nEnviadas', 'nAprobadas', 'nRechazadas'));
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	//Muestra el panel de Revision de solicitudes enviadas, es el panel que ve el Gerente de cada Unidad Organizativa
	public function revisar()
	{
		try {
			//Constante para el estado enviada --Se define dentro de config/constantes.php--
			$ENVIADA = config('constantes.ENVIADA');
			$requisicionesEnviadas = RequisicionProducto::where('estado_id', $ENVIADA)
				->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
				->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
				->select('requisicion_productos.*')
				->get();

			//Constante para el estado aceptada --Se define dentro de config/constantes.php--
			$ACEPTADA = config('constantes.ACEPTADA');
			$requisicionesAprobadas = RequisicionProducto::where('estado_id', $ACEPTADA)
				->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
				->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
				->select('requisicion_productos.*')
				->get();

			return view('requisicionProducto.requisicionProducto.revisar', compact('requisicionesEnviadas', 'requisicionesAprobadas'));
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	//Muestra el panel de Requisicon a entregar, que ve el Encargado de Almacen para confirmar que los productos han sido enviados
	public function entrega()
	{
		try {
			//Constante para el estado aceptada --Se define dentro de config/constantes.php--
			$ACEPTADA = config('constantes.ACEPTADA');
			$requisicionesAprobadas = RequisicionProducto::where('estado_id', $ACEPTADA)->get();
			return view('requisicionProducto.requisicionProducto.entrega', compact('requisicionesAprobadas'));
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	//Muestra una tabla con todas las requisiciones que han sido entregadas
	public function requisicionRecibida()
	{
		try {
			//Constante para el estado entregada --Se define dentro de config/constantes.php--
			$ENTREGADA = config('constantes.ENTREGADA');
			$requisicionRecibidas = RequisicionProducto::where('estado_id', $ENTREGADA)
				->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
				->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
				->select('requisicion_productos.*')
				->get();

			return view('requisicionProducto.requisicionProducto.requiRealizada', compact('requisicionRecibidas'));
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}
	//Muestra una tabla con todas las requisiciones que han sido entregadas
	public function historialRequi()
	{
		try {
			//Constante para el estado entregada --Se define dentro de config/constantes.php--
			$ENTREGADA = config('constantes.ENTREGADA');
			$requisicionRecibidas = RequisicionProducto::where('estado_id', $ENTREGADA)->get();
			return view('requisicionProducto.requisicionProducto.historialRequi', compact('requisicionRecibidas'));
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	//Metodo que sirve para inicializar cada requisicion que se creara
	public function store(Request $request)
	{
		try {
			//Constante para el estado inicializada --Se define dentro de config/constantes.php--
			$INICIALIZADA = config('constantes.INICIALIZADA');
			$requisicionProducto = new RequisicionProducto();
			$date =  new DateTime();
			$requisicionProducto->fechaRequisicion = $date->format('Y-m-d H:i:s');
			$requisicionProducto->estado_id = $INICIALIZADA;
			// Asignar el user_id al usuario autenticado actualmente
			$requisicionProducto->user_id = Auth::id();
			$requisicionProducto->save();
			return redirect()->route('requisicionProducto.detalle', $requisicionProducto);
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	//Función que permite la edición de un registro almacenado
	public function edit(RequisicionProducto $requisicionProducto)
	{
		try {
			return view('requisicionProducto.requisicionProducto.edit', compact('requisicionProducto'));
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
			//Constante para el estado enviada --Se define dentro de config/constantes.php--
			$ENVIADA = config('constantes.ENVIADA');
			Validator::extend('not_only_numbers', function ($attribute, $value, $parameters, $validator) {
				return !preg_match('/^[0-9\s]*$/', $value);
			});

			$rules = [
				'descripcion' => ['required', 'not_only_numbers', 'max:255']
			];

			$customMessages = [
				'required' => 'El campo :attribute es obligatorio.',
				'not_only_numbers' => 'El campo :attribute no debe contener solo números.',
				'max' => 'El campo :attribute no debe tener más de :max caracteres.'
			];
			$request->validate($rules, $customMessages);
			$requisicionProducto->estado_id = $ENVIADA;
			$requisicionProducto->descripcion = $request->descripcion;
			$requisicionProducto->save();
			return redirect()->route('requisicionProducto.index')->with('status', 'Registro correcto');
		} catch (\Exception $e) {
			return redirect()->back()->with('msg', $e->getMessage());
		}
	}

	//METODO QUE SE ENCARGA DE QUE  UNA REQUISICION CAMBIE A ENTREGADA (Productos recibidos)
	public function requisicionEntregada(RequisicionProducto $requisicionProducto)
	{
		try {
			//Constante para el estado entregada --Se define dentro de config/constantes.php--
			$ENTREGADA = config('constantes.ENTREGADA');

			$requisicionProducto->estado_id = $ENTREGADA;
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
		try {
			//Constante para el estado aceptada --Se define dentro de config/constantes.php--
			$ACEPTADA = config('constantes.ACEPTADA');
			//Constante para el estado entregada --Se define dentro de config/constantes.php--
			$ENTREGADA = config('constantes.ENTREGADA');
			Validator::extend('not_only_numbers', function ($attribute, $value, $parameters, $validator) {
				return !preg_match('/^[0-9\s]*$/', $value);
			});

			$rules = [
				'observacion' => ['required', 'not_only_numbers', 'max:255']
			];

			$customMessages = [
				'required' => 'El campo :attribute es obligatorio.',
				'not_only_numbers' => 'El campo :attribute no debe contener solo números.',
				'max' => 'El campo :attribute no debe tener más de :max caracteres.'
			];

			$request->validate($rules, $customMessages);
			$requisicionProducto->estado_id = $ACEPTADA;
			$requisicionProducto->observacion = $request->observacion;
			//Constante para el estado aceptada --Se define dentro de config/constantes.php--
			$ACEPTADA = config('constantes.ACEPTADA');
			$RECHAZADA = config('constantes.RECHAZADA');
			$countRequiApro = RequisicionProducto::where('estado_id', $ACEPTADA)->orderBy('id', 'desc')->first();
			$countRequiReci = RequisicionProducto::where('estado_id', $ENTREGADA)->orderBy('id', 'desc')->first();
			if ($requisicionProducto->nCorrelativo != NULL) {
				$requisicionProducto->save();
			} else {
				// Check if the RequisicionProducto table is empty
				if ($countRequiApro == null && $countRequiReci == null) {
					// If the table is empty, set the nCorrelativo value to 01-YYYY
					$date = new Carbon();
					$requisicionProducto->nCorrelativo = '01-' . $date->format('Y');
				} else {
					$lastRequisicionProducto = RequisicionProducto::whereIn('estado_id', [$ACEPTADA, $RECHAZADA, $ENTREGADA])
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
			}
			$requisicionProducto->save();
			return redirect()->route('requisicionProducto.revisar')->with('status', $requisicionProducto);
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}


	//METODO QUE SE ENCARGA DE QUE  UNA REQUISICION CAMBIE A DENEGADA POR EL JEFE GERENTE de cada Unidad Organizativa
	public function denegar(Request $request, RequisicionProducto $requisicionProducto)
	{
		try {
			//Constante para el estado rechazada --Se define dentro de config/constantes.php--
			$RECHAZADA = config('constantes.RECHAZADA');
			Validator::extend('not_only_numbers', function ($attribute, $value, $parameters, $validator) {
				return !preg_match('/^[0-9\s]*$/', $value);
			});

			$rules = [
				'observacion' => ['required', 'not_only_numbers', 'max:255']
			];

			$customMessages = [
				'required' => 'El campo :attribute es obligatorio.',
				'not_only_numbers' => 'El campo :attribute no debe contener solo números.',
				'max' => 'El campo :attribute no debe tener más de :max caracteres.'
			];
			$request->validate($rules, $customMessages);
			$requisicionProducto->estado_id = $RECHAZADA;
			$requisicionProducto->observacion = $request->observacion;
			if (!is_null($requisicionProducto->nCorrelativo)) {
				$requisicionProducto->save();
				return redirect()->route('requisicionProducto.entrega');
			}
			$requisicionProducto->save();
			return redirect()->route('requisicionProducto.revisar');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}


	//Se encarga de eliminar una requisicion de productos
	public function destroy(RequisicionProducto $requisicionProducto)
	{
		try {
			if ($requisicionProducto->nCorrelativo !== null) {
				return redirect()->route('requisicionProducto.estado')->with('error', 'No se puede eliminar el registro porque ya se le asigno un numero correlativo');
			}
			$requisicionProducto->delete();
			return redirect()->route('requisicionProducto.index')->with('delete', 'Registro eliminado');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}
}

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
	/**
	 * Muestra las requisiciones enviadas para revisión.
	 *
	 * @param Request $request La solicitud HTTP que puede contener parámetros de búsqueda.
	 * @return Illuminate\View\View La vista con las requisiciones enviadas para revisión.
	 */
	public function index(Request $request)
	{
		try {
			// Constante para el estado "enviada" (definido en config/constantes.php)
			$ENVIADA = config('constantes.ENVIADA');

			// Obtención del valor del parámetro "fechaRequisicion" de la solicitud
			$fechaRequisicion = $request->get('fechaRequisicion');

			// Consulta para obtener las requisiciones enviadas para revisión
			$requisiciones = RequisicionProducto::where('estado_id', $ENVIADA)
				->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
				->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
				->fechaRequisicion($fechaRequisicion)
				->select('requisicion_productos.*')
				->get();

			// Constante para el estado "inicializada" (definido en config/constantes.php)
			$INICIALIZADA = config('constantes.INICIALIZADA');

			// Obtener requisiciones sin completar en estado "inicializada"
			$requisicionesSinCompletar = RequisicionProducto::where('estado_id', $INICIALIZADA)
				->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
				->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
				->get();

			// Eliminar requisiciones sin completar
			foreach ($requisicionesSinCompletar as $item) {
				$item->delete();
			}

			// Redireccionar a la vista con las requisiciones y los parámetros de búsqueda
			return view('requisicionProducto.requisicionProducto.index', compact('requisiciones', 'request'));
		} catch (\Exception $e) {
			// En caso de excepción, redireccionar de vuelta con un mensaje de error.
			return redirect()->back()->with('catch', 'Algo salió mal!');
		}
	}

	/**
	 * Muestra los estados de las requisiciones enviadas, aprobadas y rechazadas.
	 *
	 * @return Illuminate\View\View La vista con los estados de las requisiciones.
	 */
	public function estado()
	{
		try {
			// Constante para el estado "enviada" (definido en config/constantes.php)
			$ENVIADA = config('constantes.ENVIADA');
			// Obtener requisiciones enviadas
			$requisicionesEnviadas = RequisicionProducto::where('estado_id', $ENVIADA)
				->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
				->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
				->select('requisicion_productos.*')
				->get();
			$nEnviadas = count($requisicionesEnviadas);

			// Constante para el estado "aceptada" (definido en config/constantes.php)
			$ACEPTADA = config('constantes.ACEPTADA');
			// Obtener requisiciones aprobadas
			$requisicionesAprobadas = RequisicionProducto::where('estado_id', $ACEPTADA)
				->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
				->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
				->select('requisicion_productos.*')
				->get();
			$nAprobadas = count($requisicionesAprobadas);

			// Constante para el estado "rechazada" (definido en config/constantes.php)
			$RECHAZADA = config('constantes.RECHAZADA');
			// Obtener requisiciones rechazadas
			$requisicionesRechazadas = RequisicionProducto::where('estado_id', $RECHAZADA)
				->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
				->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
				->select('requisicion_productos.*')
				->get();
			$nRechazadas = count($requisicionesRechazadas);

			// Redireccionar a la vista con los estados y números de requisiciones
			return view('requisicionProducto.requisicionProducto.estado', compact('requisicionesEnviadas', 'requisicionesAprobadas', 'requisicionesRechazadas', 'nEnviadas', 'nAprobadas', 'nRechazadas'));
		} catch (\Exception $e) {
			// En caso de excepción, redireccionar de vuelta con un mensaje de error.
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	/**
	 * Muestra el panel de revisión de solicitudes enviadas. Este panel es visualizado por el Gerente de cada Unidad Organizativa.
	 *
	 * @return Illuminate\View\View La vista del panel de revisión de solicitudes enviadas.
	 */
	public function revisar()
	{
		try {
			// Constante para el estado "enviada" (definido en config/constantes.php)
			$ENVIADA = config('constantes.ENVIADA');
			// Obtener requisiciones enviadas
			$requisicionesEnviadas = RequisicionProducto::where('estado_id', $ENVIADA)
				->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
				->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
				->select('requisicion_productos.*')
				->get();

			// Constante para el estado "aceptada" (definido en config/constantes.php)
			$ACEPTADA = config('constantes.ACEPTADA');
			// Obtener requisiciones aprobadas
			$requisicionesAprobadas = RequisicionProducto::where('estado_id', $ACEPTADA)
				->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
				->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
				->select('requisicion_productos.*')
				->get();

			// Redireccionar a la vista del panel de revisión con las requisiciones enviadas y aprobadas
			return view('requisicionProducto.requisicionProducto.revisar', compact('requisicionesEnviadas', 'requisicionesAprobadas'));
		} catch (\Exception $e) {
			// En caso de excepción, redireccionar de vuelta con un mensaje de error.
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	/**
	 * Muestra el panel de Requisición a entregar, que es visualizado por el Encargado de Almacén para confirmar que los productos han sido enviados.
	 *
	 * @return Illuminate\View\View La vista del panel de Requisición a entregar.
	 */
	public function entrega()
	{
		try {
			// Constante para el estado "aceptada" (definido en config/constantes.php)
			$ACEPTADA = config('constantes.ACEPTADA');
			// Obtener requisiciones aprobadas
			$requisicionesAprobadas = RequisicionProducto::where('estado_id', $ACEPTADA)->get();

			// Redireccionar a la vista del panel de Requisición a entregar con las requisiciones aprobadas
			return view('requisicionProducto.requisicionProducto.entrega', compact('requisicionesAprobadas'));
		} catch (\Exception $e) {
			// En caso de excepción, redireccionar de vuelta con un mensaje de error.
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	/**
	 * Muestra una tabla con todas las requisiciones que han sido entregadas.
	 *
	 * @return Illuminate\View\View La vista con la tabla de requisiciones entregadas.
	 */
	public function requisicionRecibida()
	{
		try {
			// Constante para el estado "entregada" (definido en config/constantes.php)
			$ENTREGADA = config('constantes.ENTREGADA');
			// Obtener requisiciones entregadas
			$requisicionRecibidas = RequisicionProducto::where('estado_id', $ENTREGADA)
				->join('usuarios', 'usuarios.id', '=', 'requisicion_productos.user_id')
				->where('usuarios.unidad_organizativa_id', Auth::user()->unidad_organizativa_id)
				->select('requisicion_productos.*')
				->get();

			// Redireccionar a la vista con la tabla de requisiciones entregadas
			return view('requisicionProducto.requisicionProducto.requiRealizada', compact('requisicionRecibidas'));
		} catch (\Exception $e) {
			// En caso de excepción, redireccionar de vuelta con un mensaje de error.
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	/**
	 * Muestra una tabla con el historial de todas las requisiciones que han sido entregadas.
	 *
	 * @return Illuminate\View\View La vista con la tabla de historial de requisiciones entregadas.
	 */
	public function historialRequi()
	{
		try {
			// Constante para el estado "entregada" (definido en config/constantes.php)
			$ENTREGADA = config('constantes.ENTREGADA');
			// Obtener requisiciones entregadas
			$requisicionRecibidas = RequisicionProducto::where('estado_id', $ENTREGADA)->get();

			// Redireccionar a la vista con la tabla de historial de requisiciones entregadas
			return view('requisicionProducto.requisicionProducto.historialRequi', compact('requisicionRecibidas'));
		} catch (\Exception $e) {
			// En caso de excepción, redireccionar de vuelta con un mensaje de error.
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}


	/**
	 * Inicializa una nueva requisición.
	 *
	 * @param Request $request La solicitud HTTP.
	 * @return Illuminate\Http\RedirectResponse La redirección a la vista de detalles de la nueva requisición.
	 */
	public function store(Request $request)
	{
		try {
			// Constante para el estado "inicializada" (definido en config/constantes.php)
			$INICIALIZADA = config('constantes.INICIALIZADA');

			// Crear una nueva instancia de RequisicionProducto
			$requisicionProducto = new RequisicionProducto();

			// Obtener la fecha actual
			$date =  new DateTime();
			$requisicionProducto->fechaRequisicion = $date->format('Y-m-d H:i:s');

			// Asignar el estado "inicializada" y el user_id del usuario autenticado
			$requisicionProducto->estado_id = $INICIALIZADA;
			$requisicionProducto->user_id = Auth::id();

			// Establecer el número correlativo como NULL (puede depender de tu lógica)
			$requisicionProducto->nCorrelativo = NULL;

			// Guardar la nueva requisición en la base de datos
			$requisicionProducto->save();

			// Redireccionar a la vista de detalles de la nueva requisición
			return redirect()->route('requisicionProducto.detalle', $requisicionProducto);
		} catch (\Exception $e) {
			// En caso de excepción, redireccionar de vuelta con un mensaje de error.
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	/**
	 * Muestra el formulario de edición de una requisición.
	 *
	 * @param RequisicionProducto $requisicionProducto El objeto de la requisición a editar.
	 * @return Illuminate\View\View La vista del formulario de edición de requisición.
	 */
	public function edit(RequisicionProducto $requisicionProducto)
	{
		try {
			// Redireccionar a la vista de edición de la requisición, pasando el objeto de la requisición a editar
			return view('requisicionProducto.requisicionProducto.edit', compact('requisicionProducto'));
		} catch (\Exception $e) {
			// En caso de excepción, retornar un mensaje de error.
			return $e->getMessage();
		}
	}

	/**
	 * Actualiza un registro de requisición.
	 *
	 * @param RequisicionProductoUpdateRequest $request La solicitud HTTP con los datos de actualización.
	 * @param RequisicionProducto $requisicionProducto El objeto de la requisición a actualizar.
	 * @return Illuminate\Http\RedirectResponse La redirección al listado de todos los registros con un mensaje de estado.
	 */
	public function update(RequisicionProductoUpdateRequest $request, RequisicionProducto $requisicionProducto)
	{
		try {
			// Actualizar los datos de la requisición con los datos proporcionados en la solicitud
			$requisicionProducto->fechaRequisicion = $request->fechaRequisicion;
			$requisicionProducto->descripcion = $request->descripcion;
			$requisicionProducto->save();

			// Redireccionar al listado de todos los registros con un mensaje de estado
			return redirect()->route('requisicionProducto.index')->with('status', 'Registro actualizado');
		} catch (\Exception $e) {
			// En caso de excepción, redireccionar de vuelta con un mensaje de error.
			return redirect()->back()->with('catch', 'Error, no se puede actualizar');
		}
	}

	/**
	 * Finaliza una requisición que ha sido inicializada (cambia el estado a "enviada").
	 *
	 * @param Request $request La solicitud HTTP con los datos necesarios.
	 * @param RequisicionProducto $requisicionProducto El objeto de la requisición a finalizar.
	 * @return Illuminate\Http\RedirectResponse La redirección al listado de requisiciones con un mensaje de estado.
	 */
	public function completar(Request $request, RequisicionProducto $requisicionProducto)
	{
		try {
			// Constante para el estado "enviada" (definido en config/constantes.php)
			$ENVIADA = config('constantes.ENVIADA');

			// Definir reglas de validación
			$rules = [
				'descripcion' => ['required', 'not_only_numbers', 'max:255']
			];

			// Definir mensajes personalizados para las reglas de validación
			$customMessages = [
				'required' => 'El campo :attribute es obligatorio.',
				'not_only_numbers' => 'El campo :attribute no debe contener solo números.',
				'max' => 'El campo :attribute no debe tener más de :max caracteres.'
			];

			// Validar la solicitud con las reglas y mensajes personalizados
			$request->validate($rules, $customMessages);

			// Actualizar el estado y la descripción de la requisición
			$requisicionProducto->estado_id = $ENVIADA;
			$requisicionProducto->descripcion = $request->descripcion;
			$requisicionProducto->save();

			// Redireccionar al listado de requisiciones con un mensaje de estado
			return redirect()->route('requisicionProducto.index')->with('status', 'La requisición ha sido enviada');
		} catch (\Exception $e) {
			// En caso de excepción, redireccionar de vuelta con un mensaje de error.
			return redirect()->back()->with('catch', $e->getMessage());
		}
	}

	//METODO QUE SE ENCARGA DE QUE  UNA REQUISICION CAMBIE A ENTREGADA (Productos recibidos)
	/**
	 * Marca una requisición como entregada y actualiza las cantidades disponibles en las bodegas correspondientes.
	 *
	 * @param RequisicionProducto $requisicionProducto El objeto de la requisición a marcar como entregada.
	 * @return Illuminate\Http\RedirectResponse La redirección a la vista de Requisición a entregar con un mensaje de estado.
	 */
	public function requisicionEntregada(RequisicionProducto $requisicionProducto)
	{
		try {
			// Constante para el estado "entregada" (definido en config/constantes.php)
			$ENTREGADA = config('constantes.ENTREGADA');

			// Cambiar el estado de la requisición a "entregada"
			$requisicionProducto->estado_id = $ENTREGADA;

			// Obtener los detalles de la requisición
			$detallesRequi = DetalleRequisicion::where('requisicion_id', $requisicionProducto->id)->get();

			// Iterar a través de los detalles de la requisición
			foreach ($detallesRequi as $detalle) {
				$producto_id = $detalle->producto_id;

				// Obtener las bodegas con cantidades disponibles para el producto
				$bodegas = ProductoBodega::where('producto_id', $producto_id)
					->where('cantidadDisponible', '>', 0)
					->orderBy('id', 'asc')
					->get();

				$detaBodega = DetalleRequisicion::where('requisicion_id', $requisicionProducto->id)
					->where('producto_id', $producto_id)
					->first();

				$cantDesc = $detaBodega->cantidadEntregada;

				if ($cantDesc > 0) {
					foreach ($bodegas as $bodega) {
						if ($bodega->cantidadDisponible < $cantDesc) {
							$detaBodega->cantidadEntregada -= $bodega->cantidadDisponible;
							$detaBodega->save();
							$bodega->cantidadDisponible = 0;
							$cantDesc = $detaBodega->cantidadEntregada;
						} else {
							$dif = $bodega->cantidadDisponible - $cantDesc;
							$detaBodega->cantidadEntregada = 0;
							$detaBodega->save();
							$cantDesc = 0;
							$bodega->cantidadDisponible = $dif;
							$bodega->save();
						}
						// Guardar explícitamente la actualización de la cantidad en la bodega
						$bodega->save();
					}
				}
			}

			// Guardar el estado actualizado y los cambios en la requisición
			$requisicionProducto->save();

			// Redireccionar a la vista de Requisición a entregar con un mensaje de estado
			return redirect()->route('requisicionProducto.entrega')->with('status', 'La requisición ha sido entregada');
		} catch (\Exception $e) {
			// En caso de excepción, redireccionar a la vista de Requisición a entregar con un mensaje de error.
			return redirect()->route('requisicionProducto.entrega')->with('catch', 'Error ' . $e->getMessage());
		}
	}

	/**
	 * Restablece la cantidad entregada de un detalle de requisición.
	 *
	 * @param int $id El ID del detalle de requisición.
	 * @return void
	 */
	public function reset($id)
	{
		try {
			// Encontrar el detalle de requisición por su ID
			$registro = DetalleRequisicion::find($id);

			// Incrementar la cantidad entregada con la cantidad original
			$registro->cantidadEntregada += $registro->cantidad;

			// Guardar el registro actualizado
			$registro->save();
		} catch (\Exception $e) {
			// En caso de excepción, puedes manejarla aquí si es necesario.
		}
	}

	/**
	 * Acepta una solicitud de requisición y actualiza el número de correlativo.
	 *
	 * @param Request $request La solicitud HTTP.
	 * @param RequisicionProducto $requisicionProducto El objeto de la requisición a aceptar.
	 * @return Illuminate\Http\RedirectResponse La redirección a la vista de revisión con un mensaje de estado.
	 */
	public function aceptar(Request $request, RequisicionProducto $requisicionProducto)
	{
		try {
			// Constante para el estado "aceptada" (definido en config/constantes.php)
			$ACEPTADA = config('constantes.ACEPTADA');
			// Constante para el estado "entregada" (definido en config/constantes.php)
			$ENTREGADA = config('constantes.ENTREGADA');

			// Validación personalizada para asegurar que el campo "observacion" no contenga solo números
			Validator::extend('not_only_numbers', function ($attribute, $value, $parameters, $validator) {
				return !preg_match('/^[0-9\s]*$/', $value);
			});

			// Reglas de validación para el campo "observacion"
			$rules = [
				'observacion' => ['required', 'not_only_numbers', 'max:255']
			];

			// Mensajes personalizados para las reglas de validación
			$customMessages = [
				'required' => 'El campo :attribute es obligatorio.',
				'not_only_numbers' => 'El campo :attribute no debe contener solo números.',
				'max' => 'El campo :attribute no debe tener más de :max caracteres.'
			];

			// Validar la solicitud según las reglas y mensajes definidos
			$request->validate($rules, $customMessages);
			// Cambiar el estado de la requisición a "aceptada"
			$requisicionProducto->estado_id = $ACEPTADA;
			$requisicionProducto->observacion = $request->observacion;
			//Constante para el estado aceptada --Se define dentro de config/constantes.php--
			$ACEPTADA = config('constantes.ACEPTADA');
			$RECHAZADA = config('constantes.RECHAZADA');

			$countRequiApro = RequisicionProducto::where('estado_id', $ACEPTADA)->orderBy('id', 'desc')->first();
			$countRequiReci = RequisicionProducto::where('estado_id', $ENTREGADA)->orderBy('id', 'desc')->first();

			$lastRequisicionProducto = RequisicionProducto::whereIn('estado_id', [$ACEPTADA, $RECHAZADA, $ENTREGADA])
				->whereRaw("YEAR(SUBSTRING(nCorrelativo, CHARINDEX('-', nCorrelativo) + 1, LEN(nCorrelativo))) = ?", [date('Y')])
				->orderByRaw("CAST(LEFT(nCorrelativo, CHARINDEX('-', nCorrelativo) - 1) AS INT) DESC")
				->first();
			// Comprobar si el valor de nCorrelativo en la requisición ya está establecido
			if ($requisicionProducto->nCorrelativo != NULL) {
				$requisicionProducto->save();
			} else {
				// Verificar si la tabla RequisicionProducto está vacía
				if ($countRequiApro == null && $countRequiReci == null) {
					// Si la tabla está vacía, establecer el valor de nCorrelativo en '01-YYYY'
					$date = new Carbon();
					$requisicionProducto->nCorrelativo = '01-' . $date->format('Y');
				} else {
					// Obtener el valor de nCorrelativo del último registro
					$lastNumber = $lastRequisicionProducto->nCorrelativo;
					list($number, $year) = explode('-', $lastNumber);
					// Crear una nueva instancia de Carbon para obtener el año actual
					$date = new Carbon();
					$currentYear = $date->format('Y');
					// Comprobar si el año actual es diferente del año en la parte de año del nCorrelativo del último registro
					if ($currentYear != $year) {
						// Si los años son diferentes, restablecer la parte numérica del nCorrelativo a '01'
						$number = '01';
					} else {
						// Si los años son iguales, incrementar la parte numérica del nCorrelativo
						$number = (int)$number + 1;
						// Agregar un cero inicial al número si es necesario
						if ($number < 10) {
							$number = '0' . $number;
						}
					}
					// Construir el nuevo valor de nCorrelativo
					$requisicionProducto->nCorrelativo = $number . '-' . $currentYear;
				}
			}
			$requisicionProducto->save();
			return redirect()->route('requisicionProducto.revisar')->with('status', 'La solicitud se ha aceptado correctamente');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	/**
	 * Cambia el estado de una requisición a "Denegada" 
	 *
	 * @param Request $request La solicitud HTTP.
	 * @param RequisicionProducto $requisicionProducto El objeto de la requisición a denegar.
	 * @return Illuminate\Http\RedirectResponse La redirección a la vista correspondiente con un mensaje de estado.
	 */
	public function denegar(Request $request, RequisicionProducto $requisicionProducto)
	{
		try {
			// Constante para el estado "Rechazada" (se define dentro de config/constantes.php)
			$RECHAZADA = config('constantes.RECHAZADA');

			// Validar el campo de observación según reglas personalizadas
			Validator::extend('not_only_numbers', function ($attribute, $value, $parameters, $validator) {
				return !preg_match('/^[0-9\s]*$/', $value);
			});

			// Definir reglas de validación
			$rules = [
				'observacion' => ['required', 'not_only_numbers', 'max:255']
			];

			// Definir mensajes personalizados para las reglas de validación
			$customMessages = [
				'required' => 'El campo :attribute es obligatorio.',
				'not_only_numbers' => 'El campo :attribute no debe contener solo números.',
				'max' => 'El campo :attribute no debe tener más de :max caracteres.'
			];

			// Validar la solicitud con las reglas y mensajes definidos
			$request->validate($rules, $customMessages);

			// Cambiar el estado de la requisición a "Rechazada"
			$requisicionProducto->estado_id = $RECHAZADA;
			$requisicionProducto->observacion = $request->observacion;

			// Guardar los cambios en la base de datos
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

	/**
	 * Elimina una requisición de productos.
	 *
	 *
	 * @param RequisicionProducto $requisicionProducto El objeto de la requisición a eliminar.
	 * @return Illuminate\Http\RedirectResponse La redirección a la lista de requisiciones con un mensaje de estado.
	 */
	public function destroy(RequisicionProducto $requisicionProducto)
	{
		try {
			// Verificar si la requisición ya tiene un número de correlativo asignado
			if ($requisicionProducto->nCorrelativo !== null) {
				return redirect()->route('requisicionProducto.estado')->with('catch', 'No se puede eliminar el registro porque ya se le asignó un número correlativo');
			}

			// Eliminar la requisición de productos
			$requisicionProducto->delete();

			// Redireccionar a la lista de requisiciones con un mensaje de éxito
			return redirect()->route('requisicionProducto.index')->with('delete', 'Registro eliminado');
		} catch (\Exception $e) {
			// En caso de error, redireccionar a la página anterior con un mensaje de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error: ' . $e->getMessage());
		}
	}
}

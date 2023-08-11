<?php

namespace App\Http\Controllers\IngresoProducto;

use App\Http\Controllers\Controller;

use App\Http\Requests\RecepcionCompraRequest;
use App\Models\DetalleCompra;
use App\Models\DetalleRequisicion;
use App\Models\DocumentoXCompra;
use App\Models\Producto;
use App\Models\ProductoBodega;
use App\Models\Proveedor;
use App\Models\RecepcionCompra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RecepcionCompraController extends Controller
{
	/**
	 * Muestra una vista que guía al usuario a través de un proceso de tres pasos para la recepción de compra.
	 *
	 * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
	 */
	public function index()
	{
		try {
			// Recupera datos de la base de datos
			$proveedores = Proveedor::all();

			// Define el paso actual y las etiquetas de los pasos
			$currentStep = "1.Recepcion de compra";
			$labelBar = ["1.Recepcion de compra", "2.Subir documentos del ingreso", "3.Ingreso de productos"];

			// Muestra la vista con los datos y etiquetas recuperados
			return view('ingresoProducto.recepcionCompra.create', compact('proveedores', 'currentStep', 'labelBar'));
		} catch (\Exception $e) {
			// Registra el error y devuelve una página de error o un mensaje
			Log::error('Error creating Recepcion de compra: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
			abort(500, 'Error creating Recepcion de compra.');
		}
	}

	/**
	 * Almacena un nuevo registro de RecepcionCompra en la base de datos.
	 *
	 * @param \App\Http\Requests\RecepcionCompraRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(RecepcionCompraRequest $request)
	{
		try {
			// Crea una nueva instancia de RecepcionCompra y asigna los valores del formulario
			$recepcionCompra = new RecepcionCompra();
			$recepcionCompra->proveedor_id = $request->proveedor_id;
			$recepcionCompra->fechaIngreso = $request->fecha;
			//El estado de finalizado de inicializa en false
			$recepcionCompra->finalizado = 0;
			$recepcionCompra->nOrdenCompra = $request->nOrdenCompra;
			$recepcionCompra->nPresupuestario = $request->nPresupuestario;
			$recepcionCompra->codigoFactura = $request->codigoFactura;
			$recepcionCompra->save();

			// Redirige a la ruta 'recepcionCompra.documento' con el ID de la recepción creada
			return redirect()->route('recepcionCompra.documento', $recepcionCompra);
		} catch (\Exception $e) {
			// Si ocurre un error, redirige de vuelta al formulario con un mensaje de error
			return redirect()->back()->with('catch', 'Algo salio mal!');
		}
	}

	/**
	 * Muestra la vista de edición de una RecepcionCompra existente.
	 *
	 * @param \App\Models\RecepcionCompra $recepcionCompra
	 * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
	 */
	public function edit(RecepcionCompra $recepcionCompra)
	{
		try {
			// Recupera todos los proveedores para la vista
			$proveedores = Proveedor::all();

			// Renderiza la vista de edición con los datos de la recepción y los proveedores
			return view('ingresoProducto.recepcionCompra.edit', compact('recepcionCompra', 'proveedores'));
		} catch (\Exception $e) {
			// Si ocurre un error, puedes manejarlo adecuadamente, como redirigir con un mensaje de error
			return $e->getMessage();
		}
	}

	/**
	 * Actualiza una RecepcionCompra existente.
	 *
	 * @param \App\Models\RecepcionCompra $recepcionCompra
	 * @param \App\Http\Requests\RecepcionCompraRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function updateCompra(RecepcionCompra $recepcionCompra, RecepcionCompraRequest $request)
	{
		try {
			// Actualiza los datos de la recepción con los valores del formulario
			$recepcionCompra->proveedor_id = $request->proveedor_id;
			$recepcionCompra->fechaIngreso = $request->fecha;
			$recepcionCompra->nOrdenCompra = $request->nOrdenCompra;
			$recepcionCompra->nPresupuestario = $request->nPresupuestario;
			$recepcionCompra->codigoFactura = $request->codigoFactura;
			$recepcionCompra->save();

			// Redirige a la página de consulta de la recepción actualizada
			return redirect()->route('recepcionCompra.consultar', $recepcionCompra);
		} catch (\Exception $e) {
			// Si ocurre un error, puedes manejarlo adecuadamente, como redirigir con un mensaje de error
			return redirect()->back()->with('catch', 'Algo salio mal!');
		}
	}

	/**
	 * Actualiza el estado de finalizado de una RecepcionCompra y realiza cálculos asociados.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Models\RecepcionCompra $recepcionCompra
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(Request $request, RecepcionCompra $recepcionCompra)
	{
		try {
			// Marca la recepción como finalizada
			$recepcionCompra->finalizado = 1;

			// Guarda los cambios en la recepción
			$recepcionCompra->save();

			// Obtiene los detalles de compra asociados a esta recepción
			$detallesCompra = DetalleCompra::where('recepcion_compra_id', $recepcionCompra->id)->get();

			// Actualiza el costo promedio y registros de productos en la bodega
			foreach ($detallesCompra as $detalle) {
				$producto_id = $detalle->producto_id;

				// Calcula y actualiza el costo promedio del producto
				$cProm = $this->costoPromedioCalculo($producto_id);
				$productoA = Producto::where('id', $producto_id)->first();
				$productoA->costoPromedio = $cProm;
				$productoA->save();

				// Actualiza registros de productos en la bodega
				$bodega_id = 1;
				$cantidadAlmacenar = $detalle->cantidadIngreso;
				$productoExistente = ProductoBodega::where('producto_id', $producto_id)->where('bodega_id', $bodega_id)->first();
				if ($productoExistente) {
					$productoExistente->cantidadDisponible += $cantidadAlmacenar;
					$productoExistente->save();
				} else {
					ProductoBodega::create([
						'producto_id' => $producto_id,
						'bodega_id' => $bodega_id,
						'cantidadDisponible' => $cantidadAlmacenar
					]);
				}
			}

			// Guarda nuevamente la recepción (puede no ser necesario, dependiendo de la lógica)
			$recepcionCompra->save();

			// Redirige a la página de consulta con un mensaje de éxito
			return redirect()->route('recepcionCompra.consultar')->with('status', 'Registro de ingreso correcto');
		} catch (\Exception $e) {
			// Maneja cualquier excepción y muestra un mensaje de error
			return back()->with('catch', 'Algo salio mal!');
		}
	}

	/**
	 * Consulta y muestra las recepciones de ingreso completas.
	 *
	 * @return \Illuminate\View\View
	 */
	public function consultar()
	{
		try {
			// Elimina las recepciones de ingreso sin completar (finalizado = false)
			$recepcionesSinCompletar = RecepcionCompra::where('finalizado', false)->get();
			foreach ($recepcionesSinCompletar as $item) {
				$item->delete();
			}

			// Consulta y obtiene las recepciones de ingreso completas (finalizado = true)
			$recepcionesCompletas = RecepcionCompra::where('finalizado', true)->get();

			// Renderiza la vista con las recepciones completas
			return view('ingresoProducto.recepcionCompra.consultar', compact('recepcionesCompletas'));
		} catch (\Exception $e) {
			// Maneja cualquier excepción y muestra un mensaje de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	/**
	 * Visualiza la revisión de los detalles de la recepción de ingreso de productos.
	 *
	 * @param \App\Models\RecepcionCompra $recepcionCompra
	 * @return \Illuminate\View\View
	 */
	public function revisar(RecepcionCompra $recepcionCompra)
	{
		try {
			$totalFinal = 0.0;

			// Consulta los detalles de compra asociados a la recepción
			$detalleCompra = DetalleCompra::where('recepcion_compra_id', $recepcionCompra->id)->get();

			// Calcula el total final sumando los totales de los detalles
			foreach ($detalleCompra as $item) {
				$totalFinal += $item->total;
			}

			// Consulta los documentos asociados a la recepción
			$documentos = DocumentoXCompra::where('recepcion_compra_id', $recepcionCompra->id)->get();

			// Renderiza la vista de revisión con los datos necesarios
			return view('ingresoProducto.recepcionCompra.revisar', compact('documentos', 'detalleCompra', 'recepcionCompra', 'totalFinal'));
		} catch (\Exception $e) {
			// Maneja cualquier excepción y muestra un mensaje de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	/**
	 * Elimina un registro de una recepción de compra junto con sus detalles y ajustes en bodega.
	 *
	 * @param \App\Models\RecepcionCompra $recepcionCompra
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy(RecepcionCompra $recepcionCompra)
	{
		try {
			// Consulta los detalles de compra asociados a la recepción
			$detallesCompra = DetalleCompra::where('recepcion_compra_id', $recepcionCompra->id)->get();

			foreach ($detallesCompra as $detalle) {
				$producto_id = $detalle->producto_id;
				$cantidadAlmacenar = $detalle->cantidadIngreso;

				// Actualiza las cantidades en bodega según la eliminación de los detalles
				$productoExistente = ProductoBodega::where('producto_id', $producto_id)->get();
				$cantidadRestante = $cantidadAlmacenar;

				foreach ($productoExistente as $producto) {
					if ($cantidadRestante > 0) {
						if ($producto->cantidadDisponible >= $cantidadRestante) {
							$producto->cantidadDisponible -= $cantidadRestante;
							$cantidadRestante = 0;
						} else {
							$cantidadRestante -= $producto->cantidadDisponible;
							$producto->cantidadDisponible = 0;
						}
						$producto->save();
					}
				}

				// Actualiza el costo promedio del producto y elimina el detalle de compra
				$detalle->delete();
				$cProm = $this->costoPromedioCalculo($producto_id);
				$productoA = Producto::where('id', $producto_id)->first();
				$productoA->costoPromedio = $cProm;
				$productoA->save();
			}

			// Elimina la recepción de compra
			$recepcionCompra->delete();

			// Redirige a la página de consulta con un mensaje de éxito
			return redirect()->route('recepcionCompra.consultar')->with('delete', 'Registro eliminado');
		} catch (\Exception $e) {
			// Si ocurre un error, captura la excepción y redirige de vuelta con un mensaje de error
			return redirect()->back()->with('catch', 'Algo salio mal!');
		}
	}

	// Esta es una función de PHP llamada costoPromedioCalculo que calcula el costo promedio de un producto dado. Toma un parámetro llamado producto, que representa el producto que se está consultando.
	// Dentro de la función, cuatro variables se inicializan como cero, a saber, $existencias, $saldoTotal, $costoPromedio y $sumaCompras.
	// La función recupera todos los registros de detalle de DetalleCompra que tienen la identificación del producto que coincide con el parámetro pasado usando la función where() y los asigna a $detalleCompras. Luego, un ciclo foreach calcula la cantidad total comprada y el costo total de las compras.
	// De igual manera, la función recupera todos los registros de detalle de DetalleRequisicion que tiene referencia al id del producto y cuyo RequisicionProducto correspondiente tiene un estado_id de $ENTREGADAS usando la función whereHas() y lo asigna a $detalleRequisicion. Un ciclo if verifica si $detalleRequisicion se evalúa como un valor no vacío y, si es verdadero, un ciclo foreach calcula la cantidad total de solicitudes realizadas y resume sus costos respectivos.
	// Luego, la función calcula el saldo de cierre del inventario restando el costo de las solicitudes del costo de las compras, que se asigna a $saldoTotal.
	// Luego, la cantidad de existencias restantes se calcula restando la cantidad total solicitada de la cantidad total comprada, que se asigna a $existencias.
	// Finalmente, el costo promedio por unidad se calcula dividiendo $saldoTotal por $existencias, que se asigna a $costoPromedio y luego se devuelve como resultado de la función.
	// El resultado de esta función es un único número flotante que representa el costo promedio por unidad del producto especificado asignado a $costoPromedio.

	/**
	 * Calcula el costo promedio de un producto dado.
	 *
	 * @param int $producto El ID del producto que se está consultando.
	 * @return float El costo promedio por unidad del producto.
	 */
	public function costoPromedioCalculo($producto)
	{
		try {
			$existencias = $saldoTotal = $costoPromedioVar = $sumaCompras = $sumaRequi = $cantidadCompra = $cantidadRequi = 0;

			// Recupera los detalles de compra finalizados asociados al producto
			$detalleCompras = DetalleCompra::whereHas('recepcionCompra', function ($query) {
				$query->where('finalizado', 1);
			})->where('producto_id', $producto)->get();

			foreach ($detalleCompras as $itemCompra) {
				$cantidadCompra += $itemCompra->cantidadIngreso;
				$sumaCompras += $itemCompra->total;
			}

			// Recupera los detalles de requisición entregados asociados al producto
			$ENTREGADA = config('constantes.ENTREGADA');
			$detalleRequisicion = DetalleRequisicion::whereHas('requisicionProducto', function ($query) use ($ENTREGADA) {
				$query->where('estado_id', $ENTREGADA);
			})->where('producto_id', $producto)->get();

			if (count($detalleRequisicion) > 0) {
				foreach ($detalleRequisicion as $itemRequi) {
					$cantidadRequi += $itemRequi->cantidad;
					$sumaRequi += $itemRequi->total;
				}
			}

			// Calcula el saldo total restando las solicitudes de las compras
			$saldoTotal = $sumaCompras - $sumaRequi;

			// Calcula las existencias restando las solicitudes de las compras
			$existencias = $cantidadCompra - $cantidadRequi;

			if ($existencias > 0) {
				$costoPromedioVar = $saldoTotal / $existencias;
			} else {
				$costoPromedioVar = $saldoTotal / 1;
			}

			return $costoPromedioVar;
		} catch (\Exception $e) {
			// Si ocurre un error, captura la excepción y devuelve un mensaje de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}
}

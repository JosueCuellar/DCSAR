<?php

namespace App\Http\Controllers;

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
	//
	//En general, este código es responsable de llenar 
	//una vista con datos de dos tablas de base de datos y algunos 
	//metadatos de pasos, que se usarán para guiar al usuario a través de un proceso de tres pasos.
	public function index()
	{
		try {
			// Retrieve data from the database
			$proveedores = Proveedor::all();

			// Define the current step and step labels
			$currentStep = "1.Recepcion de compra";
			$labelBar = ["1.Recepcion de compra", "2.Subir documentos del ingreso", "3.Ingreso de productos"];

			// Render the view with the retrieved data and labels
			return view('recepcionCompra.create', compact('proveedores', 'currentStep', 'labelBar'));
		} catch (\Exception $e) {
			// Log the error and return an error page or message
			Log::error('Error creating Recepcion de compra: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
			abort(500, 'Error creating Recepcion de compra.');
		}
	}


	//Permite la creacion de un nuevo INGRESO de productos
	public function store(RecepcionCompraRequest $request)
	{
		try {
			$recepcionCompra = new RecepcionCompra();
			$recepcionCompra->proveedor_id = $request->proveedor_id;
			$recepcionCompra->fechaIngreso = $request->fecha;
			$recepcionCompra->inicializado = false;
			$recepcionCompra->nOrdenCompra = $request->nOrdenCompra;
			$recepcionCompra->nPresupuestario = $request->nPresupuestario;
			$recepcionCompra->codigoFactura = $request->codigoFactura;
			$recepcionCompra->save();
			return redirect()->route('recepcionCompra.documento', $recepcionCompra);
		} catch (\Exception $e) {
			return redirect()->back()->with('error', 'Algo salio mal!');
		}
	}

	//Vista paraedicion de una recepcion de ingreso de productos ya creada
	public function edit(RecepcionCompra $recepcionCompra)
	{
		try {
			$proveedores = Proveedor::all();

			return view('recepcionCompra.edit', compact('recepcionCompra', 'proveedores'));
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	//Permite la edicion de una recepcion de ingreso de productos ya creada
	public function updateCompra(RecepcionCompra $recepcionCompra, RecepcionCompraRequest $request)
	{
		try {
			$recepcionCompra->proveedor_id = $request->proveedor_id;
			$recepcionCompra->fechaIngreso = $request->fecha;
			$recepcionCompra->inicializado = true;
			$recepcionCompra->nOrdenCompra = $request->nOrdenCompra;
			$recepcionCompra->nPresupuestario = $request->nPresupuestario;
			$recepcionCompra->codigoFactura = $request->codigoFactura;
			$recepcionCompra->save();
			return redirect()->route('recepcionCompra.consultar', $recepcionCompra);
		} catch (\Exception $e) {
			return redirect()->back()->with('error', 'Algo salio mal!');
		}
	}

	public function update(Request $request, RecepcionCompra $recepcionCompra)
	{
		try {
			$recepcionCompra->inicializado = true;
			$detallesCompra = DetalleCompra::where('recepcion_compra_id', $recepcionCompra->id)->get();
			foreach ($detallesCompra as $detalle) {
				$producto_id = $detalle->producto_id;
				$cProm = $this->costoPromedioCalculo($producto_id);
				$productoA = Producto::where('id', $producto_id)->first();
				$productoA->costoPromedio = $cProm;
				$productoA->save();

				//Crear los registros de los productos en la bodega
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
			$recepcionCompra->save();
			return redirect()->route('recepcionCompra.consultar')->with('status', 'Registro correcto');
		} catch (\Exception $e) {
			return back()->with('error', 'Algo salio mal!');
		}
	}

	//Visualizar las recepcion de ingreso completas
	public function consultar()
	{
		$recepcionesSinCompletar = RecepcionCompra::where('inicializado', false)->get();
		foreach ($recepcionesSinCompletar as $item) {
			$item->delete();
		}
		$recepcionesCompletas = RecepcionCompra::where('inicializado', true)->get();
		return view('recepcionCompra.consultar', compact('recepcionesCompletas'));
	}

	//Visualizar al revision de los detalles de la recepcion de ingreso de productos
	public function revisar(RecepcionCompra $recepcionCompra)
	{
		$totalFinal = 0.0;
		$detalleCompra = DetalleCompra::where('recepcion_compra_id', $recepcionCompra->id)->get();
		foreach ($detalleCompra as $item) {
			$totalFinal += $item->total;
		}
		$documentos  = DocumentoXCompra::where('recepcion_compra_id', $recepcionCompra->id)->get();
		return view('recepcionCompra.revisar', compact('documentos', 'detalleCompra', 'recepcionCompra', 'totalFinal'));
	}

	//Permite eliminar un registro de una recepcion de compra
	public function destroy(RecepcionCompra $recepcionCompra)
	{
		try {
			$detallesCompra = DetalleCompra::where('recepcion_compra_id', $recepcionCompra->id)->get();
			foreach ($detallesCompra as $detalle) {
				$producto_id = $detalle->producto_id;

				//Crear los registros de los productos en la bodega
				$cantidadAlmacenar = $detalle->cantidadIngreso;
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
				$detalle->delete();
				$cProm = $this->costoPromedioCalculo($producto_id);
				$productoA = Producto::where('id', $producto_id)->first();
				$productoA->costoPromedio = $cProm;
				$productoA->save();
			}
			$recepcionCompra->delete();
			return redirect()->route('recepcionCompra.consultar')->with('delete', 'Registro eliminado');
		} catch (\Exception $e) {
			return redirect()->back()->with('error', 'Algo salio mal!');
		}
	}

	// Esta es una función de PHP llamada costoPromedioCalculo que calcula el costo promedio de un producto dado. Toma un parámetro llamado producto, que representa el producto que se está consultando.
	// Dentro de la función, cuatro variables se inicializan como cero, a saber, $existencias, $saldoTotal, $costoPromedio y $sumaCompras.
	// La función recupera todos los registros de detalle de DetalleCompra que tienen la identificación del producto que coincide con el parámetro pasado usando la función where() y los asigna a $detalleCompras. Luego, un ciclo foreach calcula la cantidad total comprada y el costo total de las compras.
	// De igual manera, la función recupera todos los registros de detalle de DetalleRequisicion que tiene referencia al id del producto y cuyo RequisicionProducto correspondiente tiene un estado_id de 4 usando la función whereHas() y lo asigna a $detalleRequisicion. Un ciclo if verifica si $detalleRequisicion se evalúa como un valor no vacío y, si es verdadero, un ciclo foreach calcula la cantidad total de solicitudes realizadas y resume sus costos respectivos.
	// Luego, la función calcula el saldo de cierre del inventario restando el costo de las solicitudes del costo de las compras, que se asigna a $saldoTotal.
	// Luego, la cantidad de existencias restantes se calcula restando la cantidad total solicitada de la cantidad total comprada, que se asigna a $existencias.
	// Finalmente, el costo promedio por unidad se calcula dividiendo $saldoTotal por $existencias, que se asigna a $costoPromedio y luego se devuelve como resultado de la función.
	// El resultado de esta función es un único número flotante que representa el costo promedio por unidad del producto especificado asignado a $costoPromedio.

	public function costoPromedioCalculo($producto)
	{
		$existencias = 0;
		$saldoTotal = 0;
		$costoPromedioVar = 0;
		$sumaCompras = 0;
		$sumaRequi = 0;
		$cantidadCompra = 0;
		$cantidadRequi = 0;
		$detalleCompras = DetalleCompra::whereHas('recepcionCompra', function ($query) {
			$query->where('inicializado', 1);
		})->where('producto_id', $producto)->get();		
		foreach ($detalleCompras as $itemCompra) {
			$cantidadCompra += $itemCompra->cantidadIngreso;
			$sumaCompras += $itemCompra->total;
		}
		$detalleRequisicion = DetalleRequisicion::whereHas('requisicionProducto', function ($query) {
			$query->where('estado_id', 4);
		})->where('producto_id', $producto)->get();

		if (count($detalleRequisicion) > 0) {
			foreach ($detalleRequisicion as $itemRequi) {
				$cantidadRequi = $itemRequi->cantidad;
				$sumaRequi += $itemRequi->total;
			}
		}

		$saldoTotal = $sumaCompras - $sumaRequi;
		$existencias = $cantidadCompra - $cantidadRequi;
		$costoPromedioVar = $saldoTotal / $existencias;
		return $costoPromedioVar;
	}
}

<?php

namespace App\Http\Controllers\IngresoProducto;

use App\Http\Controllers\Controller;
use App\Http\Requests\DetalleCompraRequest;
use App\Models\Bodega;
use App\Models\DetalleCompra;
use App\Models\DetalleRequisicion;
use App\Models\DocumentoXCompra;
use App\Models\Producto;
use App\Models\ProductoBodega;
use App\Models\RecepcionCompra;


class DetalleCompraController extends Controller
{


	/**
	 * Muestra el detalle de la recepción de compra y el ingreso de productos.
	 *
	 * @param \App\Models\RecepcionCompra $recepcionCompra
	 * @return \Illuminate\Contracts\View\View
	 */
	public function index(RecepcionCompra $recepcionCompra)
	{
		try {
			// Obtiene los detalles de compra relacionados con la recepción de compra
			$detalleCompra = DetalleCompra::where('recepcion_compra_id', $recepcionCompra->id)->get();

			// Obtiene todos los productos y bodegas disponibles
			$productos = Producto::all();
			$bodegas = Bodega::all();

			// Configuración para el seguimiento de pasos
			$currentStep = "3.Ingreso de productos"; // Paso actual
			$labelBar = ["1.Recepcion de compra", "2.Subir documentos del ingreso", "3.Ingreso de productos"]; // Array con los números de los pasos

			// Calcula el total final de la compra
			$totalFinal = 0;
			foreach ($detalleCompra as $item) {
				$totalFinal += $item->total;
			}

			// Obtiene los documentos relacionados con la recepción de compra
			$documentos = DocumentoXCompra::where('recepcion_compra_id', $recepcionCompra->id)->get();

			// Retorna la vista con los datos necesarios
			return view('ingresoProducto.detalleCompra.index', compact('recepcionCompra', 'detalleCompra', 'productos', 'bodegas', 'documentos', 'totalFinal', 'labelBar', 'currentStep'));
		} catch (\Exception $e) {
			// Maneja cualquier excepción y muestra el mensaje de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	/**
	 * Almacena un nuevo detalle de compra asociado a una recepción de compra.
	 *
	 * @param \App\Http\Requests\DetalleCompraRequest $request
	 * @param \App\Models\RecepcionCompra $recepcionCompra
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(DetalleCompraRequest $request, RecepcionCompra $recepcionCompra)
	{
		try {
			// Calcula el total para el detalle de compra
			$total = ($request->cantidadIngreso) * ($request->precioUnidad);

			// Crea un nuevo detalle de compra y almacena los datos
			$detalleCompra = new DetalleCompra();
			$detalleCompra->producto_id = $request->producto_id;
			$detalleCompra->recepcion_compra_id = $recepcionCompra->id;
			$detalleCompra->cantidadIngreso = $request->cantidadIngreso;
			$detalleCompra->fechaVencimiento = $request->fechaVenc;
			$detalleCompra->precioUnidad = $request->precioUnidad;
			$detalleCompra->total = $total;
			$detalleCompra->save();

			// Redirige de vuelta a la página de detalles de recepción con un mensaje de estado
			return redirect()->route('recepcionCompra.detalle', $recepcionCompra)->with('status', 'Ingreso de producto');
		} catch (\Exception $e) {
			// Maneja cualquier excepción y muestra el mensaje de error
			return $e->getMessage();
		}
	}

	/**
	 * Muestra el formulario de edición para un detalle de compra específico
	 * asociado a una recepción de compra.
	 *
	 * @param \App\Models\RecepcionCompra $recepcionCompra La recepción de compra asociada
	 * @param \App\Models\DetalleCompra $detalleCompra El detalle de compra a editar
	 * @return \Illuminate\View\View
	 */
	public function edit(RecepcionCompra $recepcionCompra, DetalleCompra $detalleCompra)
	{
		// Obtener la lista de productos disponibles
		$productos = Producto::all();

		// Cargar la vista de edición con los datos necesarios
		return view('ingresoProducto.detalleCompra.editPorDetalle', compact('recepcionCompra', 'detalleCompra', 'productos'));
	}

	/**
	 * Actualiza un detalle de compra asociado a una recepción de compra.
	 *
	 * @param \App\Http\Requests\DetalleCompraRequest $request
	 * @param \App\Models\RecepcionCompra $recepcionCompra La recepción de compra asociada
	 * @param \App\Models\DetalleCompra $detalleCompra El detalle de compra a actualizar
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(DetalleCompraRequest $request, RecepcionCompra $recepcionCompra, DetalleCompra $detalleCompra)
	{
		try {
			// Calcula el total para el detalle de compra
			$total = ($request->cantidadIngreso) * ($request->precioUnidad);

			// Actualiza los datos del detalle del ingreso con los nuevos valores
			$detalleCompra->recepcion_compra_id = $recepcionCompra->id;
			$detalleCompra->producto_id = $request->producto_id;
			$detalleCompra->cantidadIngreso = $request->cantidadIngreso;
			$detalleCompra->fechaVencimiento = $request->fechaVenc;
			$detalleCompra->precioUnidad = $request->precioUnidad;
			$detalleCompra->total = $total;
			$detalleCompra->update();

			// Redirige de vuelta a la página de detalles de recepción con un mensaje de estado
			return redirect()->route('recepcionCompra.detalle', $recepcionCompra)->with('status', 'Ingreso de producto actualizado');
		} catch (\Exception $e) {
			// Maneja cualquier excepción y muestra el mensaje de error
			return $e->getMessage();
		}
	}

	/**
	 * Elimina un detalle de compra asociado a una recepción de compra.
	 *
	 * @param \App\Models\RecepcionCompra $recepcionCompra La recepción de compra asociada
	 * @param \App\Models\DetalleCompra $detalleCompra El detalle de compra a eliminar
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy(RecepcionCompra $recepcionCompra, DetalleCompra $detalleCompra)
	{
		// Elimina el detalle de compra
		$detalleCompra->delete();

		// Redirige de vuelta a la página de detalles de recepción con un mensaje de estado
		return redirect()->route('recepcionCompra.detalle', $recepcionCompra)->with('delete', 'Se ha eliminado el detalle del producto');
	}



	/**
	 * Muestra la vista de edición de detalles de compra asociados a una recepción de compra.
	 *
	 * @param \App\Models\RecepcionCompra $recepcionCompra La recepción de compra asociada
	 * @param \App\Models\DetalleCompra $detalleCompra El detalle de compra a editar
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function indexEdit(RecepcionCompra $recepcionCompra, DetalleCompra $detalleCompra)
	{
		// Obtiene los detalles de compra asociados a la recepción de compra
		$detalleCompra = DetalleCompra::where('recepcion_compra_id', $recepcionCompra->id)->get();

		// Obtiene todos los productos y bodegas
		$productos = Producto::all();
		$bodegas = Bodega::all();

		// Calcula el total final de los detalles de compra
		$totalFinal = 0;
		foreach ($detalleCompra as $item) {
			$totalFinal += $item->total;
		}

		// Muestra la vista de edición con los datos compactados
		return view('ingresoProducto.detalleCompra.indexEdit', compact('recepcionCompra', 'detalleCompra', 'productos', 'bodegas', 'totalFinal'));
	}



	/**
	 * Almacena un nuevo detalle de compra editado y actualiza registros relacionados.
	 *
	 * @param \App\Http\Requests\DetalleCompraRequest $request
	 * @param \App\Models\RecepcionCompra $recepcionCompra La recepción de compra asociada
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function storeEdit(DetalleCompraRequest $request, RecepcionCompra $recepcionCompra)
	{
		try {
			// Calcula el total para el detalle de compra
			$total = ($request->cantidadIngreso) * ($request->precioUnidad);

			// Crea un nuevo detalle de compra y almacena los datos editados
			$detalleCompra = new DetalleCompra();
			$detalleCompra->producto_id = $request->producto_id;
			$detalleCompra->recepcion_compra_id = $recepcionCompra->id;
			$detalleCompra->cantidadIngreso = $request->cantidadIngreso;
			$detalleCompra->fechaVencimiento = $request->fechaVenc;
			$detalleCompra->precioUnidad = $request->precioUnidad;
			$detalleCompra->total = $total;
			$detalleCompra->save();

			// Crea o actualiza los registros de los productos en la bodega
			$bodega_id = 1;
			$cantidadAlmacenar = $detalleCompra->cantidadIngreso;
			$productoExistente = ProductoBodega::where('producto_id', $request->producto_id)->where('bodega_id', $bodega_id)->first();
			if ($productoExistente) {
				$productoExistente->cantidadDisponible += $cantidadAlmacenar;
				$productoExistente->save();
			} else {
				ProductoBodega::create([
					'producto_id' => $request->producto_id,
					'bodega_id' => $bodega_id,
					'cantidadDisponible' => $cantidadAlmacenar
				]);
			}

			// Calcula y actualiza el costo promedio del producto
			$p = $request->producto_id;
			$cProm = $this->costoPromedioCalculo($p);
			$productoA = Producto::where('id', $p)->first();
			$productoA->costoPromedio = $cProm;
			$productoA->save();

			// Redirige de vuelta a la página de detalles de recepción editados con un mensaje de estado
			return redirect()->route('recepcionCompra.detalleEdit', $recepcionCompra)->with('status', 'Se ha agregado correctamente el producto');
		} catch (\Exception $e) {
			// Maneja cualquier excepción y muestra el mensaje de error
			return $e->getMessage();
		}
	}


	/**
	 * Actualiza un detalle de compra editado y gestiona cambios en registros relacionados.
	 *
	 * @param \App\Http\Requests\DetalleCompraRequest $request
	 * @param \App\Models\RecepcionCompra $recepcionCompra La recepción de compra asociada
	 * @param \App\Models\DetalleCompra $detalleCompra El detalle de compra a editar
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function updateEdit(DetalleCompraRequest $request, RecepcionCompra $recepcionCompra, DetalleCompra $detalleCompra)
	{
		try {
			// Calcula el total para el detalle de compra
			$total = ($request->cantidadIngreso) * ($request->precioUnidad);

			// Actualiza la cantidad en la bodega para los productos existentes
			$productoExistente = ProductoBodega::where('producto_id', $request->producto_id)->get();
			$cantidadCambiar = $detalleCompra->cantidadIngreso;
			foreach ($productoExistente as $item) {
				if ($item->cantidadDisponible >= $cantidadCambiar) {
					$item->cantidadDisponible -= $cantidadCambiar;
					$item->save();
					break;
				} else {
					$cantidadCambiar -= $item->cantidadDisponible;
					$item->cantidadDisponible = 0;
					$item->save();
				}
			}

			// Actualiza los datos del detalle del ingreso
			$detalleCompra->recepcion_compra_id = $recepcionCompra->id;
			$detalleCompra->producto_id = $request->producto_id;
			$detalleCompra->cantidadIngreso = $request->cantidadIngreso;
			$detalleCompra->fechaVencimiento = $request->fechaVenc;
			$detalleCompra->precioUnidad = $request->precioUnidad;
			$detalleCompra->total = $total;
			$detalleCompra->update();

			// Crea o actualiza los registros de los productos en la bodega
			$bodega_id = 1;
			$cantidadAlmacenar = $detalleCompra->cantidadIngreso;
			$productoExistente = ProductoBodega::where('producto_id', $request->producto_id)->where('bodega_id', $bodega_id)->first();
			if ($productoExistente) {
				$productoExistente->cantidadDisponible += $cantidadAlmacenar;
				$productoExistente->save();
			} else {
				ProductoBodega::create([
					'producto_id' => $request->producto_id,
					'bodega_id' => $bodega_id,
					'cantidadDisponible' => $cantidadAlmacenar
				]);
			}

			// Calcula y actualiza el costo promedio del producto
			$p = $request->producto_id;
			$cProm = $this->costoPromedioCalculo($p);
			$productoA = Producto::where('id', $p)->first();
			$productoA->costoPromedio = $cProm;
			$productoA->save();

			// Redirige de vuelta a la página de detalles de recepción editados con un mensaje de estado
			return redirect()->route('recepcionCompra.detalleEdit', $recepcionCompra)->with('status', 'Se ha agregado correctamente el producto');
		} catch (\Exception $e) {
			// Maneja cualquier excepción y muestra el mensaje de error
			return $e->getMessage();
		}
	}


	/**
	 * Elimina un detalle de compra editado y gestiona los cambios en registros relacionados.
	 *
	 * @param \App\Models\RecepcionCompra $recepcionCompra La recepción de compra asociada
	 * @param \App\Models\DetalleCompra $detalleCompra El detalle de compra a eliminar
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroyEdit(RecepcionCompra $recepcionCompra, DetalleCompra $detalleCompra)
	{
		try {
			$producto_id = $detalleCompra->producto_id;
			$cantidadAlmacenar = $detalleCompra->cantidadIngreso;
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

			// Elimina el detalle de compra y actualiza el costo promedio del producto
			$detalleCompra->delete();
			$cProm = $this->costoPromedioCalculo($producto_id);
			$productoA = Producto::where('id', $producto_id)->first();
			$productoA->costoPromedio = $cProm;
			$productoA->save();

			// Redirige de vuelta a la página de detalles de recepción editados con un mensaje de eliminación exitosa
			return redirect()->route('recepcionCompra.detalleEdit', $recepcionCompra)->with('delete', 'Se ha eliminado el detalle del producto');
		} catch (\Exception $e) {
			// Maneja cualquier excepción y muestra el mensaje de error
			return $e->getMessage();
		}
	}

	/**
	 * Calcula el costo promedio de un producto en base a sus registros de compra y requisición.
	 *
	 * @param int $producto El ID del producto para el cual se calculará el costo promedio.
	 * @return float El costo promedio calculado para el producto.
	 */
	public function costoPromedioCalculo($producto)
	{
		// Inicialización de variables para cálculos
		$existencias = $saldoTotal = $costoPromedioVar = $sumaCompras = $sumaRequi = $cantidadCompra = $cantidadRequi = 0;

		// Obtención de los detalles de compra asociados a recepciones finalizadas para el producto
		$detalleCompras = DetalleCompra::whereHas('recepcionCompra', function ($query) {
			$query->where('finalizado', 1);
		})->where('producto_id', $producto)->get();

		// Cálculo de sumas de compras y cantidades de compra
		foreach ($detalleCompras as $itemCompra) {
			$cantidadCompra += $itemCompra->cantidadIngreso;
			$sumaCompras += $itemCompra->total;
		}

		// Obtención de los detalles de requisición asociados a requisiciones entregadas para el producto
		$ENTREGADA = config('constantes.ENTREGADA');
		$detalleRequisicion = DetalleRequisicion::whereHas('requisicionProducto', function ($query) use ($ENTREGADA) {
			$query->where('estado_id', $ENTREGADA);
		})->where('producto_id', $producto)->get();

		// Cálculo de sumas de requisiciones y cantidades de requisición
		foreach ($detalleRequisicion as $itemRequi) {
			$cantidadRequi += $itemRequi->cantidad;
			$sumaRequi += $itemRequi->total;
		}

		// Cálculo del saldo total y existencias
		$saldoTotal = $sumaCompras - $sumaRequi;
		$existencias = $cantidadCompra - $cantidadRequi;
		// Cálculo del costo promedio
		if ($existencias > 0) {
			$costoPromedioVar = $saldoTotal / $existencias;
		} else {
			$costoPromedioVar = $saldoTotal / 1; // Evitar división por cero
		}
		return $costoPromedioVar;
	}
}

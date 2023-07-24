<?php

namespace App\Http\Controllers;

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


	public function index(RecepcionCompra $recepcionCompra)
	{
		try {
			$detalleCompra = DetalleCompra::where('recepcion_compra_id', $recepcionCompra->id)->get();
			$productos = Producto::all();
			$bodegas = Bodega::all();

			$currentStep = "3.Ingreso de productos"; //Paso actual
			$labelBar = ["1.Recepcion de compra", "2.Subir documentos del ingreso", "3.Ingreso de productos"]; // Array con los números de los pasos
			$totalFinal = 0;
			$detalleCompra = DetalleCompra::where('recepcion_compra_id', $recepcionCompra->id)->get();
			$productos = Producto::all();
			foreach ($detalleCompra as $item) {
				$totalFinal += $item->total;
			}
			$documentos  = DocumentoXCompra::where('recepcion_compra_id', $recepcionCompra->id)->get();
			return view('detalleCompra.index', compact('recepcionCompra', 'detalleCompra', 'productos', 'bodegas', 'documentos', 'totalFinal', 'labelBar', 'currentStep'));
		} catch (\Exception $e) {
			$e->getMessage();
		}
	}

	//Funcion para crear un nuevo detalle de compra
	public function store(DetalleCompraRequest $request, RecepcionCompra $recepcionCompra)
	{
		$total = ($request->cantidadIngreso) * ($request->precioUnidad);
		try {
			$detalleCompra =  new DetalleCompra();
			$detalleCompra->producto_id = $request->producto_id;
			$detalleCompra->recepcion_compra_id = $recepcionCompra->id;
			$detalleCompra->cantidadIngreso = $request->cantidadIngreso;
			$detalleCompra->fechaVencimiento = $request->fechaVenc;
			$detalleCompra->precioUnidad = $request->precioUnidad;
			$detalleCompra->total = $total;
			$detalleCompra->save();
			return redirect()->route('recepcionCompra.detalle', $recepcionCompra)->with('status', 'Se ha agregado correctamente el producto');
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function edit(RecepcionCompra $recepcionCompra, DetalleCompra $detalleCompra)
	{
		$productos = Producto::all();
		return view('detalleCompra.editPorDetalle', compact('recepcionCompra', 'detalleCompra', 'productos'));
	}

	//Funcion para editar un detalle de compra
	public function update(DetalleCompraRequest $request, RecepcionCompra $recepcionCompra, DetalleCompra $detalleCompra)
	{
		$total = ($request->cantidadIngreso) * ($request->precioUnidad);
		// $producto_id = $request->producto_id;
		try {
			//Se guardan los nuevos datos del detalle del ingreso
			$detalleCompra->recepcion_compra_id = $recepcionCompra->id;
			$detalleCompra->producto_id = $request->producto_id;
			$detalleCompra->cantidadIngreso = $request->cantidadIngreso;
			$detalleCompra->fechaVencimiento = $request->fechaVenc;
			$detalleCompra->precioUnidad = $request->precioUnidad;
			$detalleCompra->total = $total;
			$detalleCompra->update();

			return redirect()->route('recepcionCompra.detalle', $recepcionCompra)->with('status', 'Se ha agregado correctamente el producto');
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	//Funcion para eliminar un detalle de compra
	public function destroy(RecepcionCompra $recepcionCompra, DetalleCompra $detalleCompra)
	{
		$detalleCompra->delete();
		return redirect()->route('recepcionCompra.detalle', $recepcionCompra)->with('delete', 'Se ha eliminado el detalle del producto');
	}





	public function indexEdit(RecepcionCompra $recepcionCompra, DetalleCompra $detalleCompra)
	{
		$detalleCompra = DetalleCompra::where('recepcion_compra_id', $recepcionCompra->id)->get();
		$productos = Producto::all();
		$bodegas = Bodega::all();
		$totalFinal = 0;
		$detalleCompra = DetalleCompra::where('recepcion_compra_id', $recepcionCompra->id)->get();
		$productos = Producto::all();
		foreach ($detalleCompra as $item) {
			$totalFinal += $item->total;
		}
		return view('detalleCompra.indexEdit', compact('recepcionCompra', 'detalleCompra', 'productos', 'bodegas', 'totalFinal'));
	}



	public function storeEdit(DetalleCompraRequest $request, RecepcionCompra $recepcionCompra)
	{
		$total = ($request->cantidadIngreso) * ($request->precioUnidad);
		try {
			$detalleCompra =  new DetalleCompra();
			$detalleCompra->producto_id = $request->producto_id;
			$detalleCompra->recepcion_compra_id = $recepcionCompra->id;
			$detalleCompra->cantidadIngreso = $request->cantidadIngreso;
			$detalleCompra->fechaVencimiento = $request->fechaVenc;
			$detalleCompra->precioUnidad = $request->precioUnidad;
			$detalleCompra->total = $total;
			$detalleCompra->save();

			//Crear los registros de los productos en la bodega
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

			$p = $request->producto_id;
			$cProm = $this->costoPromedioCalculo($p);
			$productoA = Producto::where('id', $p)->first();
			$productoA->costoPromedio = $cProm;
			$productoA->save();
			return redirect()->route('recepcionCompra.detalleEdit', $recepcionCompra)->with('status', 'Se ha agregado correctamente el producto');
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	//Funcion para editar un detalle de compra
	public function updateEdit(DetalleCompraRequest $request, RecepcionCompra $recepcionCompra, DetalleCompra $detalleCompra)
	{
		$total = ($request->cantidadIngreso) * ($request->precioUnidad);
		// $producto_id = $request->producto_id;
		try {
			//Se guardan los nuevos datos del detalle del ingreso
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

			$detalleCompra->recepcion_compra_id = $recepcionCompra->id;
			$detalleCompra->producto_id = $request->producto_id;
			$detalleCompra->cantidadIngreso = $request->cantidadIngreso;
			$detalleCompra->fechaVencimiento = $request->fechaVenc;
			$detalleCompra->precioUnidad = $request->precioUnidad;
			$detalleCompra->total = $total;
			$detalleCompra->update();

			//Crear los registros de los productos en la bodega
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

			$p = $request->producto_id;
			$cProm = $this->costoPromedioCalculo($p);
			$productoA = Producto::where('id', $p)->first();
			$productoA->costoPromedio = $cProm;
			$productoA->save();
			return redirect()->route('recepcionCompra.detalleEdit', $recepcionCompra)->with('status', 'Se ha agregado correctamente el producto');
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}



	public function destroyEdit(RecepcionCompra $recepcionCompra, DetalleCompra $detalleCompra)
	{
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
		$detalleCompra->delete();
		$cProm = $this->costoPromedioCalculo($producto_id);
		$productoA = Producto::where('id', $producto_id)->first();
		$productoA->costoPromedio = $cProm;
		$productoA->save();
		return redirect()->route('recepcionCompra.detalleEdit', $recepcionCompra)->with('delete', 'Se ha eliminado el detalle del producto');
	}



	public function costoPromedioCalculo($producto)
	{
		$existencias = 0;
		$saldoTotal = 0;
		$costoPromedioVar = 0;
		$sumaCompras = 0;
		$sumaRequi = 0;
		$cantidadCompra = 0;
		$cantidadRequi = 0;
		$detalleCompras = DetalleCompra::where('producto_id', $producto)->get();
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

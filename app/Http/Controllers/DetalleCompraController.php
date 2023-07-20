<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetalleCompraRequest;
use App\Models\Bodega;
use App\Models\DetalleCompra;
use App\Models\DocumentoXCompra;
use App\Models\Producto;
use App\Models\RecepcionCompra;


class DetalleCompraController extends Controller
{
	//

	//Funcion para revisar detalle de compra
	public function index(RecepcionCompra $recepcionCompra)
	{
		$detalleCompra = DetalleCompra::where('recepcion_compra_id', $recepcionCompra->id)->get();
		$productos = Producto::all();
		$bodegas = Bodega::all();
		return view('detalleCompra.index', compact('detalleCompra', 'productos', 'bodegas'));
	}


	public function create(RecepcionCompra $recepcionCompra)
	{
		try {
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
			return view('detalleCompra.create', compact('recepcionCompra', 'detalleCompra', 'productos', 'bodegas', 'documentos', 'totalFinal', 'labelBar', 'currentStep'));
		} catch (\Exception $e) {
			$e->getMessage();
		}
	}

	public function editCompra(RecepcionCompra $recepcionCompra)
	{
		try {
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
			return view('detalleCompra.editCompra', compact('recepcionCompra', 'detalleCompra', 'productos', 'bodegas', 'documentos', 'totalFinal', 'labelBar', 'currentStep'));
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
		return view('detalleCompra.edit', compact('recepcionCompra', 'detalleCompra', 'productos'));
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

		//Funcion para editar un detalle de compra
		public function updateCompra(DetalleCompraRequest $request, RecepcionCompra $recepcionCompra, DetalleCompra $detalleCompra)
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
	
				return redirect()->route('detalleCompra.editCompra', $recepcionCompra)->with('status', 'Se ha agregado correctamente el producto');
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
}

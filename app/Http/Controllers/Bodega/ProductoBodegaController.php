<?php

namespace App\Http\Controllers\Bodega;

use App\Http\Controllers\Controller;
use App\Models\ProductoBodega;
use Illuminate\Http\Request;

class ProductoBodegaController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{

		try {
			$productos_bodegas = ProductoBodega::all();
			return view('bodega.productoBodega.bodegaPrincipal', compact('productos_bodegas'));
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}



	public function store(Request $request, ProductoBodega $productoBodega)
	{
		// Get input values
		$cantidad = $request->input('cantidadProducto');
		$producto = $productoBodega->producto_id;
		$bodega = $productoBodega->bodega_id;
		$var = ($bodega == 1) ? 2 : 1;

		try {
			// Search for secondary warehouse
			$bodegaSecundaria = ProductoBodega::where('producto_id', $producto)
				->where('bodega_id', $var)
				->first();

			// Create secondary warehouse if it does not exist
			if (!$bodegaSecundaria) {
				if ($cantidad > $productoBodega->cantidadDisponible) {
					return redirect()->back()->with('catch', 'Error, no hay suficiente cantidad disponible en la bodega');
				}
				$bodegaSecundaria = new ProductoBodega([
					'producto_id' => $producto,
					'bodega_id' => $var,
					'cantidadDisponible' => $cantidad
				]);
				$bodegaSecundaria->save();
			} else {
				// Check if there is enough available quantity in primary warehouse
				if ($cantidad > $productoBodega->cantidadDisponible) {
					return redirect()->back()->with('catch', 'Error, no hay suficiente cantidad disponible en la bodega');
				}
				// Move quantity from primary to secondary warehouse
				$productoBodega->cantidadDisponible -= $cantidad;
				$productoBodega->save();

				$bodegaSecundaria->cantidadDisponible += $cantidad;
				$bodegaSecundaria->save();
			}

			return redirect()->route('productoBodega.index')->with('status', 'Se ha agregado correctamente!');
		} catch (\Exception $e) {
			// Handle exception
			return redirect()->back()->with('catch', 'Error de servidor: ' . $e->getMessage());
		}
	}
}

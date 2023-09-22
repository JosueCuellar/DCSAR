<?php

namespace App\Http\Controllers\Bodega;

use App\Http\Controllers\Controller;
use App\Models\ProductoBodega;
use Illuminate\Http\Request;

class ProductoBodegaController extends Controller
{

	/**
	 * Muestra la vista principal de la bodega con la lista de productos en las bodegas.
	 *
	 * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
	 */
	public function index()
	{
		try {
			// Obtiene todos los registros de productos en bodegas
			$productos_bodegas = ProductoBodega::all();

			// Retorna la vista de la bodega principal con la lista de productos en bodegas
			return view('bodega.productoBodega.bodegaPrincipal', compact('productos_bodegas'));
		} catch (\Exception $e) {
			// En caso de error, devuelve el mensaje de la excepción
			return $e->getMessage();
		}
	}

	/**
	 * Almacena o mueve productos entre bodegas según la cantidad especificada.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\ProductoBodega  $productoBodega
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(Request $request, ProductoBodega $productoBodega)
	{
		// Obtén los valores de entrada
		$cantidad = $request->input('cantidadProducto');
		$producto = $productoBodega->producto_id;
		$bodega = $productoBodega->bodega_id;
		$var = ($bodega == 1) ? 2 : 1;

		// Verifica si hay suficiente cantidad disponible en la bodega principal
		if ($cantidad > $productoBodega->cantidadDisponible) {
			return redirect()->back()->with('catch', 'Error, no hay suficiente cantidad disponible en la bodega');
		}

		try {
			// Busca la bodega secundaria
			$bodegaSecundaria = ProductoBodega::where('producto_id', $producto)
				->where('bodega_id', $var)
				->first();

			// Crea la bodega secundaria si no existe
			if (!$bodegaSecundaria) {
				// Crea el registro de la bodega secundaria
				$bodegaSecundaria = new ProductoBodega([
					'producto_id' => $producto,
					'bodega_id' => $var,
					'cantidadDisponible' => 0 // Inicializa con 0
				]);
			}

			// Aumenta la cantidad disponible en la bodega secundaria en la cantidad especificada
			$bodegaSecundaria->cantidadDisponible += $cantidad;
			// Guarda los cambios en la bodega secundaria
			$bodegaSecundaria->save();

			// Reduce la cantidad disponible en la bodega principal en la cantidad especificada
			$productoBodega->cantidadDisponible -= $cantidad;
			// Guarda los cambios en la bodega principal
			$productoBodega->save();

			return redirect()->route('productoBodega.index')->with('status', '¡Se ha agregado correctamente!');
		} catch (\Exception $e) {
			// Manejo de excepciones
			return redirect()->back()->with('catch', 'Error de servidor: ' . $e->getMessage());
		}
	}
}

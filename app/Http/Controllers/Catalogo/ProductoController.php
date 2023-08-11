<?php

namespace App\Http\Controllers\Catalogo;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductoRequest;
use App\Models\Marca;
use App\Models\Medida;
use App\Models\Producto;
use App\Models\Rubro;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class ProductoController extends Controller
{
	/**
	 * Muestra una lista de todos los registros de productos almacenados en la base de datos y los envía a la vista del índice.
	 *
	 * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
	 */
	public function index()
	{
		try {
			// Retorna la vista del índice de productos
			return view('catalogo.producto.index');
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error: ' . $e->getMessage());
		}
	}

	/**
	 * Obtiene y formatea los datos de productos con información de marca, rubro y medida para DataTables.
	 *
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 */
	public function datosProducto()
	{
		try {
			// Obtiene los datos de productos con relaciones de marca, rubro y medida
			$productos = Producto::with(['marca', 'rubro', 'medida'])->get()->map(function ($producto) {
				$producto->marca_id = $producto->marca->nombre;
				$producto->rubro_id = $producto->rubro->descripRubro;
				$producto->medida_id = $producto->medida->nombreMedida;
				unset($producto->marca, $producto->rubro, $producto->medida);
				return $producto;
			});

			// Formatea y devuelve los datos para DataTables
			return DataTables::of($productos)->make(true);
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error: ' . $e->getMessage());
		}
	}

	/**
	 * Muestra la vista de creación de un nuevo producto y envía datos necesarios como arreglos de marcas, medidas y rubros, así como los últimos códigos generados para cada categoría.
	 *
	 * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
	 */
	public function create()
	{
		try {
			// Obtiene arreglos de marcas, medidas, rubros y productos
			$marcas = Marca::all();
			$medidas = Medida::all();
			$rubros = Rubro::all();
			$productos = Producto::all();

			// Crea un arreglo para almacenar los últimos códigos para cada categoría
			$lastCodes = [];

			// Itera a través de cada categoría (rubro)
			foreach ($rubros as $rubro) {
				// Obtiene todos los productos para el rubro actual
				$productos = Producto::where('rubro_id', $rubro->id)->get();

				// Verifica si se encontraron productos
				if ($productos->count() > 0) {
					// Crea una variable para almacenar el número más grande después del guion
					$maxNumber = 0;

					// Itera a través de cada producto
					foreach ($productos as $producto) {
						// Obtiene el valor de codProducto del producto actual
						$codProducto = $producto->codProducto;
						// Divide el valor de codProducto en sus partes
						list($part1, $part2) = explode('-', $codProducto);
						// Convierte la segunda parte del valor de codProducto en un entero
						$number = (int)$part2;
						// Verifica si el número actual es mayor que el máximo actual
						if ($number > $maxNumber) {
							// Si lo es, actualiza el número máximo
							$maxNumber = $number;
						}
					}
					// Incrementa el número máximo
					$maxNumber++;
					// Agrega ceros a la izquierda si es necesario
					if ($maxNumber < 10) {
						$maxNumber = '0' . $maxNumber;
					}
					// Agrega el número máximo incrementado al arreglo de últimos códigos
					$lastCodes[$rubro->id] = $part1 . '-' . $maxNumber;
				} else {
					// Si no se encontraron productos para la categoría actual, obtiene el valor de codigoPresupuestario y agrega -01
					$codigoPresupuestario = Rubro::where('id', $rubro->id)->value('codigoPresupuestario');
					$lastCodes[$rubro->id] = $codigoPresupuestario . '-01';
				}
			}

			// Retorna la vista de creación de producto junto con los datos necesarios
			return view('catalogo.producto.create', compact('marcas', 'medidas', 'rubros', 'productos', 'lastCodes'));
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error: ' . $e->getMessage());
		}
	}

	/**
	 * Crea y almacena un nuevo registro de producto en la base de datos, utilizando la clase ProductoRequest para validación y manejo de imágenes.
	 *
	 * @param  \App\Http\Requests\ProductoRequest  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(ProductoRequest $request)
	{
		try {
			// Obtiene la imagen del formulario y define la ruta para guardarla
			$imagen = $request->file('imagen');
			$rutaGuardarImagen = 'imagen/';
			$imagenProducto = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
			$imagen->move($rutaGuardarImagen, $imagenProducto);

			// Crea un nuevo objeto Producto y asigna los valores desde el formulario
			$producto = new Producto();
			$producto->codProducto = $request->codProductoCon;
			$producto->descripcion = $request->descripcion;
			$producto->observacion = $request->observacion;
			$producto->perecedero = $request->perecedero;
			$producto->imagen = $imagenProducto;
			$producto->marca_id = $request->marca_id;
			$producto->medida_id = $request->medida_id;
			$producto->rubro_id = $request->rubro_id;
			$producto->save();

			// Redirige al listado de todos los registros de productos con mensaje de éxito
			return redirect()->route('producto.index')->with('status', 'Producto agregado');
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Error, no se puede registrar: ' . $e->getMessage());
		}
	}

	/**
	 * Muestra la vista de edición para un registro de producto existente y envía datos necesarios como arreglos de marcas, medidas y rubros.
	 *
	 * @param  \App\Models\Producto  $producto
	 * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
	 */
	public function edit(Producto $producto)
	{
		try {
			// Obtiene arreglos de marcas, medidas, rubros y productos
			$marcas = Marca::all();
			$medidas = Medida::all();
			$rubros = Rubro::all();
			$productos = Producto::all();

			// Retorna la vista de edición de producto junto con los datos necesarios
			return view('catalogo.producto.edit', compact('producto', 'productos', 'marcas', 'medidas', 'rubros'));
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Error, no se puede registrar: ' . $e->getMessage());
		}
	}

	/**
	 * Actualiza los detalles de un registro de producto existente en la base de datos, utilizando la clase ProductoRequest para validación y manejo de imágenes.
	 *
	 * @param  \App\Http\Requests\ProductoRequest  $request
	 * @param  \App\Models\Producto  $producto
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(ProductoRequest $request, Producto $producto)
	{
		try {
			// Obtiene los datos del formulario
			$prod = $request->all();

			// Verifica si se proporciona una nueva imagen
			if ($imagen = $request->file('imagen')) {
				$rutaGuardarImagen = 'imagen/';
				$imagenProducto = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
				$imagen->move($rutaGuardarImagen, $imagenProducto);
				$prod['imagen'] = "$imagenProducto";
			} else {
				unset($prod['imagen']);
			}

			// Actualiza los detalles del producto con los nuevos valores
			$producto->codProducto = $request->codProductoCon;
			$producto->perecedero = $request->perecedero;
			$producto->medida_id = $request->medida_id;
			$producto->update($prod);

			// Redirige al listado de todos los registros de productos con mensaje de éxito
			return redirect()->route('producto.index')->with('status', 'Producto actualizado');
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'Error, no se puede actualizar: ' . $e->getMessage());
		}
	}

	/**
	 * Elimina un registro de producto de la base de datos y su imagen asociada si existe.
	 *
	 * @param  \App\Models\Producto  $producto
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy(Producto $producto)
	{
		try {
			// Obtiene la URL de la imagen y verifica su existencia
			$url = public_path('imagen/' . $producto->imagen);
			if (File::exists($url)) {
				// Elimina el registro de producto y la imagen asociada
				$producto->delete();
				File::delete($url);
				// Redirige al listado de todos los registros de productos con mensaje de éxito
				return redirect()->route('producto.index')->with('delete', 'Producto eliminado');
			} else {
				// Si la imagen no existe, redirige con un mensaje de error
				return redirect()->back()->with('catch', 'No existe la imagen!');
			}
		} catch (\Exception $e) {
			// Manejo de excepciones en caso de error
			return redirect()->back()->with('catch', 'El registro no se puede eliminar, otra tabla lo utiliza: ' . $e->getMessage());
		}
	}
}

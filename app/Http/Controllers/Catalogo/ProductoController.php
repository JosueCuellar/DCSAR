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
	//Función que trae un listado de todos los registros de la base de datos, los almacena y envía a la vista del index
	public function index()
	{
		try {
			return view('catalogo.producto.index');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	public function datosProducto()
	{
		try {
			$productos = Producto::with(['marca', 'rubro', 'medida'])->get()->map(function ($producto) {
				$producto->marca_id = $producto->marca->nombre;
				$producto->rubro_id = $producto->rubro->descripRubro;
				$producto->medida_id = $producto->medida->nombreMedida;
				unset($producto->marca, $producto->rubro, $producto->medida);
				return $producto;
			});
			return DataTables::of($productos)->make(true);
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}
	//Envia un arreglo de estados
	public function create()
	{
		try {
			$marcas = Marca::all();
			$medidas = Medida::all();
			$rubros = Rubro::all();
			$productos = Producto::all();

			// Create an array to store the last codes for each category
			$lastCodes = [];

			// Loop through each category
			foreach ($rubros as $rubro) {
				// Get all the products for the current category
				$productos = Producto::where('rubro_id', $rubro->id)->get();
				// Check if any products were found
				if ($productos->count() > 0) {
					// Create a variable to store the largest number after the hyphen
					$maxNumber = 0;
					// Loop through each product
					foreach ($productos as $producto) {
						// Get the codProducto value from the current product
						$codProducto = $producto->codProducto;
						// Split the codProducto value into its parts
						list($part1, $part2) = explode('-', $codProducto);
						// Convert the second part of the codProducto value to an integer
						$number = (int)$part2;
						// Check if the current number is larger than the current maximum
						if ($number > $maxNumber) {
							// If it is, update the maximum number
							$maxNumber = $number;
						}
					}
					// Increment the maximum number
					$maxNumber++;
					// Zero-pad the maximum number if necessary
					if ($maxNumber < 10) {
						$maxNumber = '0' . $maxNumber;
					}
					// Add the incremented maximum number to the array of last codes
					$lastCodes[$rubro->id] = $part1 . '-' . $maxNumber;
				} else {
					// If no products were found for the current category, get the codigoPresupuestario value and append -01 to it
					$codigoPresupuestario = Rubro::where('id', $rubro->id)->value('codigoPresupuestario');
					$lastCodes[$rubro->id] = $codigoPresupuestario . '-01';
				}
			}
			return view('catalogo.producto.create', compact('marcas', 'medidas', 'rubros', 'productos', 'lastCodes'));
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	//Función que permite la creación de un nuevo registro que será almacenado dentro de la base de datos
	//Se hace uso de la clase Request para los mensajes de validación
	public function store(ProductoRequest $request)
	{
		try {
			$imagen = $request->file('imagen');
			$rutaGuardarImagen = 'imagen/';
			$imagenProducto = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
			$imagen->move($rutaGuardarImagen, $imagenProducto);
			//Se crea y almacena un nuevo objeto
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
			//Se redirige al listado de todos los registros
			return redirect()->route('producto.index')->with('status', 'Producto agregado');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Error no se puede registrar' . $e->getMessage());
		}
	}
	//Función que permite la edición de un registro almacenado
	public function edit(Producto $producto)
	{
		try {
			$marcas = Marca::all();
			$medidas = Medida::all();
			$rubros = Rubro::all();
			$productos = Producto::all();
			return view('catalogo.producto.edit', compact('producto', 'productos', 'marcas', 'medidas', 'rubros'));
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Error no se puede registrar' . $e->getMessage());
		}
	}
	//Función que actualiza un registro
	public function update(ProductoRequest $request, Producto $producto)
	{
		try {
			$prod = $request->all();
			if ($imagen = $request->file('imagen')) {
				$rutaGuardarImagen = 'imagen/';
				$imagenProducto = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
				$imagen->move($rutaGuardarImagen, $imagenProducto);
				$prod['imagen'] = "$imagenProducto";
			} else {
				unset($prod['imagen']);
			}
			$producto->codProducto = $request->codProductoCon;
			$producto->perecedero = $request->perecedero;
			$producto->medida_id = $request->medida_id;
			$producto->update($prod);
			//Se redirige al listado de todos los registros
			return redirect()->route('producto.index')->with('status', 'Producto actualizado');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Error no se puede actualizar' . $e->getMessage());
		}
	}
	//Función que elimina un registro
	public function destroy(Producto $producto)
	{
		try {
			$url = public_path('imagen/' . $producto->imagen);
			if (File::exists($url)) {
				$producto->delete();
				File::delete($url);
				return redirect()->route('producto.index')->with('delete', 'Producto eliminado');
			} else {
				return redirect()->back()->with('catch', 'No existe la imagen!');
			}
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'El registro no se puede eliminar, otra tabla lo utiliza' . $e->getMessage());
		}
	}
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoRequest;
use App\Models\Marca;
use App\Models\Medida;
use App\Models\Producto;
use App\Models\Rubro;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class ProductoController extends Controller
{
	//Función que trae un listado de todos los registros de la base de datos, los almacena y envía a la vista del index
	public function index()
	{
		return view('producto.index');
	}
	public function datosProducto()
	{
		$productos = DB::table('productos')
			->join('marcas', 'productos.marca_id', '=', 'marcas.id')
			->join('rubros', 'productos.rubro_id', '=', 'rubros.id')
			->join('medidas', 'productos.medida_id', '=', 'medidas.id')
			->select('productos.*', 'marcas.nombre as marca_id', 'rubros.descripRubro as rubro_id', 'medidas.nombreMedida as medida_id')
			->get();
		return DataTables::of($productos)->make(true);
	}
	//Envia un arreglo de estados
	public function create()
	{
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


		return view('producto.create', compact('marcas', 'medidas', 'rubros', 'productos', 'lastCodes'));
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
			return redirect()->route('producto.index')->with('status', 'Registro correcto');
		} catch (\Exception $e) {
			return redirect()->back()->with('msg', 'Error no se puede registrar');
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
			return view('producto.edit', compact('producto', 'productos', 'marcas', 'medidas', 'rubros'));
		} catch (\Exception $e) {
			return $e->getMessage();
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
			return redirect()->route('producto.index')->with('status', 'Registro correcto');
		} catch (\Exception $e) {
			return redirect()->back()->with('msg', 'Error no se puede actualizar');
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
				return redirect()->route('producto.index')->with('delete', 'Registro eliminado');
			} else {
				return redirect()->back()->with('msg', 'No existe la imagen!');
			}
		} catch (\Exception $e) {
			return redirect()->back()->with('msg', 'El registro no se puede eliminar, otra tabla lo utiliza');
		}
	}
}

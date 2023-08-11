<?php

namespace App\Http\Controllers\RequisicionProducto;


use App\Http\Controllers\Controller;
use App\Http\Requests\DetalleRequisicionRequest;
use App\Models\DetalleRequisicion;
use App\Models\Producto;
use App\Models\RequisicionProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DetalleRequisicionController extends Controller
{
	/**
	 * Muestra el detalle de un producto en una requisición.
	 *
	 * @param RequisicionProducto $requisicionProducto La requisición de la que se mostrará el detalle.
	 * @param Request $request La solicitud HTTP actual.
	 * @return \Illuminate\View\View Vista que muestra el detalle del producto en la requisición.
	 */
	public function index(RequisicionProducto $requisicionProducto, Request $request)
	{
		try {
			$totalFinal = 0.0;
			$detalle_requisicion = DetalleRequisicion::where('requisicion_id', $requisicionProducto->id)->get();
			foreach ($detalle_requisicion as $item) {
				$totalFinal += $item->total;
			}
			return view('requisicionProducto.detalleRequisicion.detalleProducto', compact('detalle_requisicion', 'requisicionProducto', 'totalFinal'));
		} catch (\Exception $e) {
			// En caso de error, redirecciona hacia atrás con un mensaje de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	/**
	 * Recupera los detalles de productos y los devuelve en formato DataTables.
	 *
	 * @return \Yajra\DataTables\DataTables Datos de detalles de productos en formato DataTables.
	 */
	public function datosDetalleProducto()
	{
		try {
			// Definir constantes de estados
			$ENVIADA = config('constantes.ENVIADA');
			$ACEPTADA = config('constantes.ACEPTADA');
			$RECHAZADA = config('constantes.RECHAZADA');
			$ENTREGADA = config('constantes.ENTREGADA');
			$INICIALIZADA = config('constantes.INICIALIZADA');

			// Consulta SQL para recuperar detalles de productos
			$productos = DB::select(
				"SELECT p.id as id, p.descripcion as descripcion, p.imagen as imagen, 
            COALESCE(COALESCE(dcom.cantidad_ingreso_total, 0) - COALESCE(dreq.cantidad_entregada, 0),0) AS stockReal, 
            COALESCE(dreq.cantidad_aprobada_pendiente, 0) AS stockReservado, 
            m.nombreMedida as nombreMedida, r.descripRubro as rubro 
            FROM productos p 
            JOIN medidas m ON p.medida_id = m.id 
            JOIN rubros r ON p.rubro_id = r.id 
            LEFT JOIN (SELECT producto_id, SUM(cantidadIngreso) AS cantidad_ingreso_total 
            FROM detalle_compras dc 
            JOIN recepcion_compras rcom ON dc.recepcion_compra_id = rcom.id 
            WHERE rcom.finalizado = 1 
            GROUP BY producto_id) dcom ON p.id = dcom.producto_id 
            LEFT JOIN (SELECT producto_id, SUM(CASE WHEN estado_id IN ($ENVIADA, $ACEPTADA, $RECHAZADA, $INICIALIZADA) THEN cantidad ELSE 0 END) AS cantidad_aprobada_pendiente, 
            SUM(CASE WHEN estado_id = $ENTREGADA THEN cantidad ELSE 0 END) AS cantidad_entregada 
            FROM detalle_requisicions dr 
            JOIN requisicion_productos rp ON dr.requisicion_id = rp.id 
            WHERE rp.estado_id IN ($ENVIADA, $ACEPTADA, $RECHAZADA, $ENTREGADA, $INICIALIZADA) 
            GROUP BY producto_id) dreq ON p.id = dreq.producto_id 
            WHERE COALESCE(COALESCE(dcom.cantidad_ingreso_total, 0) - COALESCE(dreq.cantidad_entregada, 0),0) > 0;"
			);

			// Devolver los datos en formato DataTables
			return DataTables::of($productos)->make(true);
		} catch (\Exception $e) {
			// En caso de error, redireccionar hacia atrás con un mensaje de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	/**
	 * Este método se encarga de mostrar los detalles de una requisición de productos.
	 * Calcula el total final de la requisición y permite filtrar productos por código.
	 * 
	 * @param RequisicionProducto $requisicionProducto El objeto de la requisición de productos.
	 * @param Request $request La solicitud HTTP.
	 * @return Illuminate\View\View La vista que muestra los detalles de la requisición.
	 */
	public function detalle(RequisicionProducto $requisicionProducto, Request $request)
	{
		try {
			// Calcular el total final
			$totalFinal = 0.0;
			$detalle_requisicion = DetalleRequisicion::where('requisicion_id', $requisicionProducto->id)->get();
			foreach ($detalle_requisicion as $item) {
				$totalFinal += $item->total;
			}

			// Obtener el código de producto desde la solicitud
			$codProducto = $request->get('codProducto');

			// Verificar si se proporcionó un código de producto
			if ($codProducto) {
				// Filtrar los productos por el código proporcionado
				$productos = Producto::where('codProducto', 'LIKE', "%$codProducto%")->get();
			} else {
				// Obtener todos los productos si no se proporcionó un código
				$productos = Producto::all();
			}

			// Renderizar la vista con los datos obtenidos
			return view('requisicionProducto.detalleRequisicion.detalleRevision', compact('detalle_requisicion', 'productos', 'requisicionProducto', 'totalFinal'));
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	/**
	 * Este método se encarga de almacenar los detalles de una requisición de productos.
	 * Valida la cantidad ingresada, calcula el stock disponible y agrega el producto a la requisición.
	 * 
	 * @param Request $request La solicitud HTTP.
	 * @param RequisicionProducto $requisicionProducto El objeto de la requisición de productos.
	 * @param Producto $producto El objeto del producto.
	 * @return Illuminate\Http\RedirectResponse La redirección a la vista de detalles de la requisición.
	 */
	public function store(Request $request, RequisicionProducto $requisicionProducto, Producto $producto)
	{
		try {
			// Definir constantes para estados
			$ENVIADA = config('constantes.ENVIADA'); //1
			$ACEPTADA = config('constantes.ACEPTADA'); //2
			$RECHAZADA = config('constantes.RECHAZADA'); //3
			$ENTREGADA = config('constantes.ENTREGADA'); //4
			$INICIALIZADA = config('constantes.INICIALIZADA'); //5

			// Definir reglas de validación
			$rules = [
				'cantidadAdd' => 'required|numeric|min:1',
			];
			// Definir mensajes de validación
			$messages = [
				'cantidadAdd.required' => 'El campo cantidad es requerido',
				'cantidadAdd.numeric' => 'El campo cantidad debe ser numérico',
				'cantidadAdd.min' => 'El campo cantidad debe ser al menos 1'
			];
			// Validar la solicitud
			$this->validate($request, $rules, $messages);

			// Obtener el ID del producto y el código
			$producto_id = $producto->id;
			$codigo = $producto->id;
			// Este método ejecuta una consulta SQL para recuperar detalles de productos de una base de datos. 
			// La consulta recupera los campos id, descripcion, imagen, stockReal, stockReservado, nombreMedida y rubro para 
			// cada producto. El campo stockReal se calcula como la cantidad total del producto en stock menos la cantidad entregada, 
			// mientras que el campo stockReservado se calcula como la cantidad del producto aprobada pero aún no entregada. 
			// La consulta une varias tablas, incluyendo las tablas productos, medidas y rubros, y utiliza subconsultas para calcular 
			// la cantidad total de cada producto en stock y la cantidad aprobada pero aún no entregada. Los datos se devuelven en formato DataTables.
			$productos = DB::select("
			SELECT p.id as id, p.descripcion as descripcion, p.imagen as imagen,
					COALESCE(COALESCE(dcom.cantidad_ingreso_total, 0) - COALESCE(dreq.cantidad_entregada, 0),0) AS stockReal,
					COALESCE(dreq.cantidad_aprobada_pendiente, 0) AS stockReservado,
					m.nombreMedida as nombreMedida, r.descripRubro as rubro
					FROM productos p
					JOIN medidas m ON p.medida_id = m.id
					JOIN rubros r ON p.rubro_id = r.id
					LEFT JOIN (SELECT producto_id, SUM(cantidadIngreso) AS cantidad_ingreso_total
					FROM detalle_compras dc
					JOIN recepcion_compras rcom ON dc.recepcion_compra_id = rcom.id
					WHERE rcom.finalizado = 1
					GROUP BY producto_id) dcom ON p.id = dcom.producto_id
					LEFT JOIN (SELECT producto_id, SUM(CASE WHEN estado_id = ? OR estado_id = ? OR estado_id = ? OR estado_id = ? THEN cantidad ELSE 0 END) AS cantidad_aprobada_pendiente,
					SUM(CASE WHEN estado_id = ?  THEN cantidad ELSE 0 END) AS cantidad_entregada
					FROM detalle_requisicions dr
					JOIN requisicion_productos rp ON dr.requisicion_id = rp.id
					WHERE rp.estado_id IN (?, ?, ?, ?, ?)
					GROUP BY producto_id) dreq ON p.id = dreq.producto_id
            WHERE p.id = ?
            ", [$ENVIADA, $ACEPTADA, $RECHAZADA, $INICIALIZADA, $ENTREGADA, $ENVIADA, $ACEPTADA, $RECHAZADA, $ENTREGADA, $INICIALIZADA, $codigo]);

			$valorCantidadMinima = 0;
			foreach ($productos as $p) {
				$valorCantidadMinima = $p->stockReal - $p->stockReservado;
			};

			if ($request->cantidadAdd > $valorCantidadMinima) {
				return redirect()->back()->with('msg', 'Error, el numero supera a la cantida en stock! Unicamente hay ' . $valorCantidadMinima . ' disponibles');
			} else {

				$precioPromedio = 0;
				$existe =  DetalleRequisicion::where('requisicion_id', $requisicionProducto->id)->where('producto_id', $producto->id)->get();
				$productoA = Producto::where('id', $producto_id)->first();
				$precioPromedio = $productoA->costoPromedio;
				$cantidad_P = count($existe);
				if ($cantidad_P > 0) {
					$detalle_requisicion = DetalleRequisicion::find($existe[0]->id);
					$detalle_requisicion->precioPromedio = $productoA->costoPromedio;
					$detalle_requisicion->cantidad = ($detalle_requisicion->cantidad) + $request->cantidadAdd;
					$detalle_requisicion->cantidadEntregada = ($detalle_requisicion->cantidad) + $request->cantidadAdd;;
					$detalle_requisicion->total = ($detalle_requisicion->cantidad) * $precioPromedio;
					$detalle_requisicion->save();
				} else {
					$detalle_requisicion =  new DetalleRequisicion();
					$detalle_requisicion->cantidad = $request->cantidadAdd;
					$detalle_requisicion->cantidadEntregada = $request->cantidadAdd;
					$detalle_requisicion->precioPromedio = $productoA->costoPromedio;
					$detalle_requisicion->total = ($detalle_requisicion->cantidad) * $precioPromedio;
					$detalle_requisicion->requisicion_id = $requisicionProducto->id;
					$detalle_requisicion->producto_id = $producto->id;
					$detalle_requisicion->save();
				}
				return redirect()->route('requisicionProducto.detalle', $requisicionProducto)->with('status', 'Producto agregado!');
			}
		} catch (\Exception $e) {
			return redirect()->back()->with('msg', 'Error, debe de agregar un numero valido!' . $e->getMessage());
			// return response()->json(array($productoA));   
		}
	}


	/**
	 * Este método se encarga de actualizar la cantidad de un detalle de requisición.
	 * Valida la cantidad ingresada, calcula el stock disponible y actualiza la cantidad del detalle.
	 * 
	 * @param Request $request La solicitud HTTP que contiene los datos de la actualización.
	 * @param RequisicionProducto $requisicionProducto El objeto de la requisición de productos asociada al detalle.
	 * @param DetalleRequisicion $detalleRequisicion El objeto del detalle de requisición que se va a actualizar.
	 * @return Illuminate\Http\RedirectResponse La redirección a la vista de detalles de la requisición con un mensaje.
	 */
	public function update(Request $request, RequisicionProducto $requisicionProducto, DetalleRequisicion $detalleRequisicion)
	{
		try {
			// Definición de constantes de estado
			$ENVIADA = config('constantes.ENVIADA'); //1
			$ACEPTADA = config('constantes.ACEPTADA'); //2
			$RECHAZADA = config('constantes.RECHAZADA'); //3
			$ENTREGADA = config('constantes.ENTREGADA'); //4
			$INICIALIZADA = config('constantes.INICIALIZADA');

			// Reglas de validación para el campo cantidad
			$rules = [
				'cantidad' => 'required|numeric|min:1',
			];

			// Mensajes de error personalizados para las reglas de validación
			$messages = [
				'cantidad.required' => 'El campo cantidad es requerido',
				'cantidad.numeric' => 'El campo cantidad debe ser numérico',
				'cantidad.min' => 'El campo cantidad debe ser al menos 1'
			];

			// Validación de los campos según las reglas y mensajes definidos
			$this->validate($request, $rules, $messages);

			// Obtención del producto_id del detalle
			$producto_id = $detalleRequisicion->producto_id;
			$codigo = $producto_id;
			$productos = DB::select("
			SELECT p.id as id, p.descripcion as descripcion, p.imagen as imagen,
					COALESCE(COALESCE(dcom.cantidad_ingreso_total, 0) - COALESCE(dreq.cantidad_entregada, 0),0) AS stockReal,
					COALESCE(dreq.cantidad_aprobada_pendiente, 0) AS stockReservado,
					m.nombreMedida as nombreMedida, r.descripRubro as rubro
					FROM productos p
					JOIN medidas m ON p.medida_id = m.id
					JOIN rubros r ON p.rubro_id = r.id
					LEFT JOIN (SELECT producto_id, SUM(cantidadIngreso) AS cantidad_ingreso_total
					FROM detalle_compras dc
					JOIN recepcion_compras rcom ON dc.recepcion_compra_id = rcom.id
					WHERE rcom.finalizado = 1
					GROUP BY producto_id) dcom ON p.id = dcom.producto_id
					LEFT JOIN (SELECT producto_id, SUM(CASE WHEN estado_id = ? OR estado_id = ? OR estado_id = ? OR estado_id = ? THEN cantidad ELSE 0 END) AS cantidad_aprobada_pendiente,
					SUM(CASE WHEN estado_id = ?  THEN cantidad ELSE 0 END) AS cantidad_entregada
					FROM detalle_requisicions dr
					JOIN requisicion_productos rp ON dr.requisicion_id = rp.id
					WHERE rp.estado_id IN (?, ?, ?, ?, ?)
					GROUP BY producto_id) dreq ON p.id = dreq.producto_id
            WHERE p.id = ?
						", [$ENVIADA, $ACEPTADA, $RECHAZADA, $INICIALIZADA, $ENTREGADA, $ENVIADA, $ACEPTADA, $RECHAZADA, $ENTREGADA, $INICIALIZADA, $codigo]);

			// Cálculo del valor mínimo de cantidad permitida según el stock
			$valorCantidadMinima = 0;
			foreach ($productos as $p) {
				$valorCantidadMinima = $p->stockReal;
			};

			// Validación si la cantidad ingresada supera el stock disponible
			if ($request->cantidad > $valorCantidadMinima) {
				return redirect()->back()->with('msg', 'Error, el número supera la cantidad en stock! Únicamente hay ' . $valorCantidadMinima . ' disponibles');
			} else {
				// Actualización de los detalles del producto
				$detalle =  DetalleRequisicion::find($detalleRequisicion->id);
				$detalle->cantidad = $request->cantidad;
				$detalle->total = ($request->cantidad) * ($detalle->precioPromedio);
				$detalle->save();

				// Redirección a la página de detalles de la requisición con mensaje de éxito
				return redirect()->route('requisicionProducto.detalle', $requisicionProducto)->with('status', 'Producto actualizado');
			}
		} catch (\Exception $e) {
			// En caso de excepción, redirecciona de vuelta a la página anterior con un mensaje de error.
			return redirect()->back()->with('msg', $e->getMessage());
		}
	}

	/**
	 * Elimina un detalle de una requisición.
	 *
	 * @param RequisicionProducto $requisicionProducto El objeto de la requisición de producto asociada al detalle.
	 * @param DetalleRequisicion $detalleRequisicion El objeto del detalle de requisición que se va a eliminar.
	 * @return \Illuminate\Http\RedirectResponse Redirecciona a la página de detalles de la requisición con un mensaje.
	 */
	public function destroy(RequisicionProducto $requisicionProducto, DetalleRequisicion $detalleRequisicion)
	{
		try {
			// Elimina permanentemente el detalle de requisición de la base de datos.
			$detalleRequisicion->forceDelete();

			// Redirecciona a la página de detalles de la requisición con un mensaje de éxito.
			return redirect()->route('requisicionProducto.detalle', $requisicionProducto)
				->with('delete', 'Se ha eliminado el registro!');
		} catch (\Exception $e) {
			// En caso de excepción, redirecciona de vuelta a la página anterior con un mensaje de error.
			return redirect()->back()->with('catch', 'Error, debe agregar un número válido!');
		}
	}
}

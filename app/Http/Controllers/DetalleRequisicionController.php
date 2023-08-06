<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetalleRequisicionRequest;
use App\Models\DetalleRequisicion;
use App\Models\Producto;
use App\Models\RequisicionProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DetalleRequisicionController extends Controller
{
	//
	public function index(RequisicionProducto $requisicionProducto, Request $request)
	{
		$totalFinal = 0.0;
		$detalle_requisicion = DetalleRequisicion::where('requisicion_id', $requisicionProducto->id)->get();
		foreach ($detalle_requisicion as $item) {
			$totalFinal += $item->total;
		}
		return view('requisicionProducto.detalle', compact('detalle_requisicion', 'requisicionProducto', 'totalFinal'));
	}

	public function datosDetalleProducto()
	{
		// Este método ejecuta una consulta SQL para recuperar detalles de productos de una base de datos. 
		// La consulta recupera los campos id, descripcion, imagen, stockReal, stockReservado, nombreMedida y rubro para 
		// cada producto. El campo stockReal se calcula como la cantidad total del producto en stock menos la cantidad entregada, 
		// mientras que el campo stockReservado se calcula como la cantidad del producto aprobada pero aún no entregada. 
		// La consulta une varias tablas, incluyendo las tablas productos, medidas y rubros, y utiliza subconsultas para calcular 
		// la cantidad total de cada producto en stock y la cantidad aprobada pero aún no entregada. Los datos se devuelven en formato DataTables.
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
            LEFT JOIN (SELECT producto_id, SUM(CASE WHEN estado_id = 1 OR estado_id = 2 OR estado_id = 3 OR estado_id = 5 THEN cantidad ELSE 0 END) AS cantidad_aprobada_pendiente,
            SUM(CASE WHEN estado_id = 4  THEN cantidad ELSE 0 END) AS cantidad_entregada
            FROM detalle_requisicions dr
            JOIN requisicion_productos rp ON dr.requisicion_id = rp.id
            WHERE rp.estado_id IN (1, 2, 3, 4, 5)
            GROUP BY producto_id) dreq ON p.id = dreq.producto_id;"
		);

		// Este método recupera detalles de productos de una base de datos y los devuelve en formato DataTables.
		// Esta forma de pasar los datos optimiza de mejor forma la carga de datos en el DataTables en la view
		return DataTables::of($productos)->make(true);
	}


	public function detalle(RequisicionProducto $requisicionProducto, Request $request)
	{
		$totalFinal = 0.0;
		$detalle_requisicion = DetalleRequisicion::where('requisicion_id', $requisicionProducto->id)->get();
		$codProducto = $request->get('codProducto');
		foreach ($detalle_requisicion as $item) {
			$totalFinal += $item->total;
		}
		if ($codProducto) {
			$productos = Producto::where('codProducto', 'LIKE', "%$codProducto%")->get();
			return view('requisicionProducto.detalleRevision', compact('detalle_requisicion', 'productos', 'requisicionProducto', 'totalFinal'));
		} else {
			$productos = Producto::all();
			return view('requisicionProducto.detalleRevision', compact('detalle_requisicion', 'productos', 'requisicionProducto', 'totalFinal'));
		}
		$productos = Producto::all();
	}

	public function store(Request $request, RequisicionProducto $requisicionProducto, Producto $producto)
	{
		try {
			$rules = [
				'cantidadAdd' => 'required|numeric|min:1',
			];
			$messages = [
				'cantidadAdd.required' => 'El campo cantidad es requerido',
				'cantidadAdd.numeric' => 'El campo cantidad debe ser numérico',
				'cantidadAdd.min' => 'El campo cantidad debe ser al menos 1'
			];
			$this->validate($request, $rules, $messages);
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
					LEFT JOIN (SELECT producto_id, SUM(CASE WHEN estado_id = 1 OR estado_id = 2 OR estado_id = 3 OR estado_id = 5 THEN cantidad ELSE 0 END) AS cantidad_aprobada_pendiente,
					SUM(CASE WHEN estado_id = 4  THEN cantidad ELSE 0 END) AS cantidad_entregada
					FROM detalle_requisicions dr
					JOIN requisicion_productos rp ON dr.requisicion_id = rp.id
					WHERE rp.estado_id IN (1, 2, 3, 4, 5)
					GROUP BY producto_id) dreq ON p.id = dreq.producto_id
            WHERE p.id = ?
            ", [$codigo]);

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
				return redirect()->route('requisicionProducto.detalle', $requisicionProducto)->with('status', 'Se ha agregado correctamente!');
			}
		} catch (\Exception $e) {
			return redirect()->back()->with('msg', 'Error, debe de agregar un numero valido!' . $e->getMessage());
			// return response()->json(array($productoA));   
		}
	}

	//Metodo para actualizar la cantidad el detalla de una requisicion
	public function update(Request $request, RequisicionProducto $requisicionProducto, DetalleRequisicion $detalleRequisicion)
	{
		try {
			$rules = [
				'cantidad' => 'required|numeric|min:1',
			];
			$messages = [
				'cantidad.required' => 'El campo cantidad es requerido',
				'cantidad.numeric' => 'El campo cantidad debe ser numérico',
				'cantidad.min' => 'El campo cantidad debe ser al menos 1'
			];
			$this->validate($request, $rules, $messages);
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
					LEFT JOIN (SELECT producto_id, SUM(CASE WHEN estado_id = 1 OR estado_id = 2 OR estado_id = 3 OR estado_id = 5 THEN cantidad ELSE 0 END) AS cantidad_aprobada_pendiente,
					SUM(CASE WHEN estado_id = 4  THEN cantidad ELSE 0 END) AS cantidad_entregada
					FROM detalle_requisicions dr
					JOIN requisicion_productos rp ON dr.requisicion_id = rp.id
					WHERE rp.estado_id IN (1, 2, 3, 4, 5)
					GROUP BY producto_id) dreq ON p.id = dreq.producto_id
            WHERE p.id = ?
            ", [$codigo]);

			$valorCantidadMinima = 0;
			foreach ($productos as $p) {
				$valorCantidadMinima = $p->stockReal;
			};
			if ($request->cantidad > $valorCantidadMinima) {
				return redirect()->back()->with('msg', 'Error, el numero supera a la cantida en stock! Unicamente hay ' . $valorCantidadMinima . ' disponibles');
			} else {

				$detalle =  DetalleRequisicion::find($detalleRequisicion->id);
				$detalle->cantidad = $request->cantidad;
				$detalle->total = ($request->cantidad) * ($detalle->precioPromedio);
				$detalle->save();
				return redirect()->route('requisicionProducto.detalle', $requisicionProducto)->with('status', 'Se ha actualizado correctamente!');
			}
		} catch (\Exception $e) {
			return redirect()->back()->with('msg', $e->getMessage());
		}
	}

	//Elimina un detalle de una requisicion
	public function destroy(RequisicionProducto $requisicionProducto, DetalleRequisicion $detalleRequisicion)
	{
		try {
			$detalleRequisicion->forceDelete();
			return redirect()->route('requisicionProducto.detalle', $requisicionProducto)->with('delete', 'Se ha eliminado el registro!');
		} catch (\Exception $e) {
			return redirect()->back()->with('error', 'Error, debe de agregar un numero valido!');
		}
	}
}

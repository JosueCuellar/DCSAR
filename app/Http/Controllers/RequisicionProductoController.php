<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequisicionProductoUpdateRequest;
use App\Models\DetalleRequisicion;
use App\Models\Lote;
use App\Models\ProductoBodega;
use App\Models\RequisicionProducto;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Termwind\Components\BreakLine;

class RequisicionProductoController extends Controller
{
	//
	public function index(Request $request)
	{
		try {
			$fechaRequisicion = $request->get('fechaRequisicion');
			$requisiciones = RequisicionProducto::where('estado_id', 1)->fechaRequisicion($fechaRequisicion)->get();
			$requisicionesSinCompletar = RequisicionProducto::where('estado_id', 5)->get();
			foreach ($requisicionesSinCompletar as $item) {
				$item->delete();
			}
			return view('requisicionProducto.index', compact('requisiciones', 'request'));
		} catch (\Exception $e) {
			return redirect()->back()->with('error', 'Algo salio mal!');
		}
	}

	public function estado()
	{
		$requisicionesEnviadas = RequisicionProducto::where('estado_id', 1)->get();
		$nEnviadas = count($requisicionesEnviadas);
		$requisicionesAprobadas = RequisicionProducto::where('estado_id', 2)->get();
		$nAprobadas = count($requisicionesAprobadas);
		$requisicionesRechazadas = RequisicionProducto::where('estado_id', 3)->get();
		$nRechazadas = count($requisicionesRechazadas);

		return view('requisicionProducto.estado', compact('requisicionesEnviadas', 'requisicionesAprobadas', 'requisicionesRechazadas', 'nEnviadas', 'nAprobadas', 'nRechazadas'));
	}

	public function revisar()
	{
		$requisicionesEnviadas = RequisicionProducto::where('estado_id', 1)->get();
		return view('requisicionProducto.revisar', compact('requisicionesEnviadas'));
	}

	public function entrega()
	{
		$requisicionesAprobadas = RequisicionProducto::where('estado_id', 2)->get();
		return view('requisicionProducto.entrega', compact('requisicionesAprobadas'));
	}

	public function requisicionRecibida()
	{
		$requisicionRecibidas = RequisicionProducto::where('estado_id', 4)->get();

		return view('requisicionProducto.requiRealizada', compact('requisicionRecibidas'));
	}

	public function store(Request $request)
	{
		$requisicionProducto = new RequisicionProducto();
		$date =  new DateTime();
		$requisicionProducto->fechaRequisicion = $date->format('Y-m-d H:i:s');
		$requisicionProducto->estado_id = 5;
		$requisicionProducto->save();
		return redirect()->route('requisicionProducto.detalle', $requisicionProducto);
	}

	//Función que permite la edición de un registro almacenado
	public function edit(RequisicionProducto $requisicionProducto)
	{
		try {
			return view('requisicionProducto.edit', compact('requisicionProducto'));
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	//Función que actualiza un registro
	public function update(RequisicionProductoUpdateRequest $request, RequisicionProducto $requisicionProducto)
	{
		try {
			$requisicionProducto->fechaRequisicion = $request->fechaRequisicion;
			$requisicionProducto->descripcion = $request->descripcion;
			$requisicionProducto->save();
			//Se redirige al listado de todos los registros
			return redirect()->route('requisicionProducto.index')->with('actualizado', 'Registro correcto');
		} catch (\Exception $e) {
			return redirect()->back()->with('msg', 'Error no se puede actualizar');
		}
	}
	

	public function completar(Request $request, RequisicionProducto $requisicionProducto)
	{
			try {
					Validator::extend('not_only_numbers', function ($attribute, $value, $parameters, $validator) {
							return !preg_match('/^[0-9\s]*$/', $value);
					});
	
					$request->validate([
							'descripcion' => ['required', 'not_only_numbers']
					]);
	
					$requisicionProducto->estado_id = 1;
					$requisicionProducto->descripcion = $request->descripcion;
					$requisicionProducto->save();
					return redirect()->route('requisicionProducto.index')->with('status', 'Registro correcto');
			} catch (\Exception $e) {
					return redirect()->back()->with('msg', 'Debe de ingresar un a descripcion al finalizar, ademas esta no debe de contener solo numeros');
			}
	}
	


	public function requisicionEntregada(RequisicionProducto $requisicionProducto)
	{
		try {
			$requisicionProducto->estado_id =  4;
			$detallesRequi = DetalleRequisicion::where('requisicion_id', $requisicionProducto->id)->get();
			foreach ($detallesRequi as $detalle) {
				$producto_id = $detalle->producto_id;
				$this->reset($detalle->id);
				$detalle->save();


				// Se realiza la salida de cada lote dependiendo la cantidad de productos que se requieran
				// $lotes = Lote::where('producto_id', $producto_id)->where('cantidadDisponible', '>', 0)->orderBy('id', 'asc')->get();
				// foreach ($lotes as $lote) {
				// 	$deta = DetalleRequisicion::where('requisicion_id', $requisicionProducto->id)->where('producto_id', $producto_id)->first();
				// 	$cantidadDescontar = $deta->cantidadEntregada; //50
				// 	if ($cantidadDescontar > 0) {
				// 		if ($lote->cantidadDisponible < $cantidadDescontar) { //50
				// 			$deta->cantidadEntregada -= $lote->cantidadDisponible; //-10 hay 40
				// 			$deta->save();
				// 			$lote->cantidadDisponible = 0;
				// 		} else {
				// 			$diferencia = $lote->cantidadDisponible - $deta->cantidadEntregada; // 50 - 1
				// 			$deta->cantidadEntregada = 0; //-10 hay 40
				// 			$deta->save();
				// 			$lote->cantidadDisponible = $diferencia;
				// 		}
				// 		// Explicit save operation
				// 		$lote->save();
				// 	}

				// 	if ($cantidadDescontar === 0) {
				// 		break;
				// 	}
				// }

				$this->reset($detalle->id);


				$bodegas = ProductoBodega::where('producto_id', $producto_id)->where('cantidadDisponible', '>', 0)->orderBy('id', 'asc')->get();
				foreach ($bodegas as $bodega) {
					$detaBodega = DetalleRequisicion::where('requisicion_id', $requisicionProducto->id)->where('producto_id', $producto_id)->first();
					$cantDesc = $detaBodega->cantidadEntregada;
					if ($cantDesc > 0) {
						if ($bodega->cantidadDisponible < $cantDesc) { //50
							$detaBodega->cantidadEntregada -= $bodega->cantidadDisponible; //-10 hay 40
							$detaBodega->save();
							$bodega->cantidadDisponible = 0;
						} else {
							$dif = $bodega->cantidadDisponible - $detaBodega->cantidadEntregada; // 50 - 1
							$detaBodega->cantidadEntregada = 0; //-10 hay 40
							$detaBodega->save();
							$bodega->cantidadDisponible = $dif;
							$bodega->save();
						}
						// Explicit save operation
						$bodega->save();
					}
					if ($cantDesc === 0) {
						break;
					}
				}
			}

			$requisicionProducto->save();
			return  redirect()->route('requisicionProducto.entrega')->with('status', 'Registro correcto');
		} catch (\Exception $e) {
			return  redirect()->route('requisicionProducto.entrega')->with('msg', 'Error' . $e->getMessage());
		}
	}


	public function reset($id)
	{
		$registro = DetalleRequisicion::find($id);
		$registro->cantidadEntregada += $registro->cantidad;
		$registro->save();
	}

	public function aceptar(Request $request, RequisicionProducto $requisicionProducto)
	{
		$requisicionProducto->estado_id =  2;
		$nR = 1;
		$date = new Carbon();
		$n = DB::select("SELECT COUNT(id) AS nRequi FROM requisicion_productos WHERE nCorrelativo IS NOT NULL;");
		foreach ($n as $item) {
			$nR += $item->nRequi;
		}
		if ($nR < 10)
			$requisicionProducto->nCorrelativo =  '0' . $nR . '-' . $date->format('Y');
		else
			$requisicionProducto->nCorrelativo =  $nR . '-' . $date->format('Y');
		$requisicionProducto->observacion = $request->observacion;
		$requisicionProducto->save();
		return  redirect()->route('requisicionProducto.revisar');
	}

	public function denegar(Request $request, RequisicionProducto $requisicionProducto)
	{
		$requisicionProducto->estado_id =  3;
		$requisicionProducto->observacion = $request->observacion;
		$requisicionProducto->save();
		return  redirect()->route('requisicionProducto.revisar');
	}

	public function destroy(RequisicionProducto $requisicionProducto)
	{
		$requisicionProducto->delete();
		return redirect()->route('requisicionProducto.index')->with('delete', 'Registro eliminado');
	}
}

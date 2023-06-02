<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoteRequest;
use App\Models\DetalleRequisicion;
use App\Models\Lote;
use App\Models\Producto;
use App\Models\RequisicionProducto;
use Illuminate\Http\Request;

class LoteController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(RequisicionProducto $requisicionProducto)
	{
		//
		try {
			$detalle_id = [];

			$detalle_requisicion = DetalleRequisicion::where('requisicion_id', $requisicionProducto->id)->get();
			foreach ($detalle_requisicion as $item) {
				$detalle_id[] =  $item->producto_id;
			}
			$lote = Lote::whereIn('producto_id', $detalle_id)->get();
			return view('lote.index', compact('detalle_requisicion', 'lote', 'requisicionProducto'));
		} catch (\Throwable $th) {
			//throw $th;
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 *  a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\LoteRequest  $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(Request $request, RequisicionProducto $requisicionProducto, Lote $lote)
	{
		//
		$detalleRequi = DetalleRequisicion::where('requisicion_id', $requisicionProducto->id);
		$producto = $lote->producto_id;
		$d = $detalleRequi->where('producto_id', $producto)->first();
		$d->cantidadEntregada += $request->cantidadEntregada;
		$d->save();

		$lote->cantidadDisponible -= $request->cantidadEntregada;
		$lote->save();
		return redirect()->route('lote.index', $requisicionProducto)->with('status', 'Se ha agregado correctamente!');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Lote  $lote
	 * @return \Illuminate\Http\Response
	 */
	public function show(Lote $lote)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Lote  $lote
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Lote $lote)
	{
		//
	}

	/**
	 *  the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\LoteRequest  $request
	 * @param  \App\Models\Lote  $lote
	 * @return \Illuminate\Http\Response
	 */
	public function update(LoteRequest $request, Lote $lote)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Lote  $lote
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Lote $lote)
	{
		//
	}
}

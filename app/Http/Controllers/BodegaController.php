<?php
namespace App\Http\Controllers;
use App\Http\Requests\BodegaRequest;
use App\Models\Bodega;
class BodegaController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
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
	 * @param  \App\Http\Requests\BodegaRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(BodegaRequest $request)
	{
		//
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Bodega  $bodega
	 * @return \Illuminate\Http\Response
	 */
	public function show(Bodega $bodega)
	{
		//
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Bodega  $bodega
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Bodega $bodega)
	{
		//
	}
	/**
	 *  the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\BodegaRequest  $request
	 * @param  \App\Models\Bodega  $bodega
	 * @return \Illuminate\Http\Response
	 */
	public function update(BodegaRequest $request, Bodega $bodega)
	{
		//
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Bodega  $bodega
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Bodega $bodega)
	{
		//
	}
}

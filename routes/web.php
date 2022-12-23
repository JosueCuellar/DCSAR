<?php

use App\Http\Controllers\DetalleRequisicionController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\RequisicionProductoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
});


  //----------------------------Marca------------------------
    //listar
    Route::get('marca', [MarcaController::class,'index'])->name('marca.index');
    //crear
    Route::view('marca/crear','marca.create')->name('marca.create');
    Route::post('marca/store',[MarcaController::class,'store'])->name('marca.store');
    //actualizar
    Route::get('marca/edit/{marca}', [MarcaController::class,'edit'])->name('marca.edit');
    Route::put('marca/update/{marca}', [MarcaController::class,'update'])->name('marca.update');
    //eliminar
    Route::get('marca/destroy/{marca}', [MarcaController::class,'destroy'])->name('marca.destroy');

  //----------------------------Proveedor------------------------
    //listar
    Route::get('proveedor', [ProveedorController::class,'index'])->name('proveedor.index');
    //crear
    Route::view('proveedor/crear','proveedor.create')->name('proveedor.create');
    Route::post('proveedor/store',[ProveedorController::class,'store'])->name('proveedor.store');
    //actualizar
    Route::get('proveedor/edit/{proveedor}', [ProveedorController::class,'edit'])->name('proveedor.edit');
    Route::put('proveedor/update/{proveedor}', [ProveedorController::class,'update'])->name('proveedor.update');
    //eliminar
    Route::get('proveedor/destroy/{proveedor}', [ProveedorController::class,'destroy'])->name('proveedor.destroy');

    //---------------------------RequisicionProducto------------------------------------------------------
    Route::get('requisicionProducto', [RequisicionProductoController::class,'index'])->name('requisicionProducto.index');
    Route::post('requisicionProducto',[RequisicionProductoController::class,'store'])->name('requisicionProducto.store');
    Route::put('requisicionProducto/completar/{requisicionProducto}',[RequisicionProductoController::class,'update'])->name('requisicionProducto.pagar');
    //---------------------------Detalle requisicion------------------------------------------------------
    Route::get('requisicionProducto/detalle/{requisicionProducto}', [DetalleRequisicionController::class,'index'])->name('requisicionProducto.detalle');
    Route::post('requisicionProducto/detalle/{requisicionProducto}/{producto}',[DetalleRequisicionController::class,'store'])->name('detalleRequisicion.store');
    Route::put('requisicionProducto/detalle/{requisicionProducto}/{detalleRequisicion}',[DetalleRequisicionController::class,'update'])->name('detalleRequisicion.update');
    Route::get('requisicionProducto/detalle/{requisicionProducto}/eliminar/{detalleRequisicion}', [DetalleRequisicionController::class,'destroy'])->name('detalleRequisicion.destroy');

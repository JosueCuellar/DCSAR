<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetalleCompraController;
use App\Http\Controllers\DetalleRequisicionController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\MedidaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\RecepcionCompraController;
use App\Http\Controllers\RequisicionProductoController;
use App\Http\Controllers\RubroController;
use App\Http\Controllers\UnidadOrganizativaController;
use App\Models\DetalleCompra;
use App\Models\RecepcionCompra;
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

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');



//----------------------------Estado------------------------
//listar
Route::get('estado', [EstadoController::class, 'index'])->name('estado.index');
//crear
Route::view('estado/crear', 'estado.create')->name('estado.create');
Route::post('estado/store', [EstadoController::class, 'store'])->name('estado.store');
//actualizar
Route::get('estado/edit/{estado}', [EstadoController::class, 'edit'])->name('estado.edit');
Route::put('estado/update/{estado}', [EstadoController::class, 'update'])->name('estado.update');
//eliminar
Route::get('estado/destroy/{estado}', [EstadoController::class, 'destroy'])->name('estado.destroy');

//----------------------------Marca------------------------
//listar
Route::get('marca', [MarcaController::class, 'index'])->name('marca.index');
//crear
Route::view('marca/crear', 'marca.create')->name('marca.create');
Route::post('marca/store', [MarcaController::class, 'store'])->name('marca.store');
//actualizar
Route::get('marca/edit/{marca}', [MarcaController::class, 'edit'])->name('marca.edit');
Route::put('marca/update/{marca}', [MarcaController::class, 'update'])->name('marca.update');
//eliminar
Route::get('marca/destroy/{marca}', [MarcaController::class, 'destroy'])->name('marca.destroy');

//----------------------------Proveedor------------------------
//listar
Route::get('proveedor', [ProveedorController::class, 'index'])->name('proveedor.index');
//crear
Route::view('proveedor/crear', 'proveedor.create')->name('proveedor.create');
Route::post('proveedor/store', [ProveedorController::class, 'store'])->name('proveedor.store');
//actualizar
Route::get('proveedor/edit/{proveedor}', [ProveedorController::class, 'edit'])->name('proveedor.edit');
Route::put('proveedor/update/{proveedor}', [ProveedorController::class, 'update'])->name('proveedor.update');
//eliminar
Route::get('proveedor/destroy/{proveedor}', [ProveedorController::class, 'destroy'])->name('proveedor.destroy');

//----------------------------Medida------------------------
//listar
Route::get('medida', [MedidaController::class, 'index'])->name('medida.index');
//crear
Route::view('medida/crear', 'medida.create')->name('medida.create');
Route::post('medida/store', [MedidaController::class, 'store'])->name('medida.store');
//actualizar
Route::get('medida/edit/{medida}', [MedidaController::class, 'edit'])->name('medida.edit');
Route::put('medida/update/{medida}', [MedidaController::class, 'update'])->name('medida.update');
//eliminar
Route::get('medida/destroy/{medida}', [MedidaController::class, 'destroy'])->name('medida.destroy');

//----------------------------UnidadOrganizativa------------------------
//listar
Route::get('unidadOrganizativa', [UnidadOrganizativaController::class, 'index'])->name('unidadOrganizativa.index');
//crear
Route::view('unidadOrganizativa/crear', 'unidadOrganizativa.create')->name('unidadOrganizativa.create');
Route::post('unidadOrganizativa/store', [UnidadOrganizativaController::class, 'store'])->name('unidadOrganizativa.store');
//actualizar
Route::get('unidadOrganizativa/edit/{unidadOrganizativa}', [UnidadOrganizativaController::class, 'edit'])->name('unidadOrganizativa.edit');
Route::put('unidadOrganizativa/update/{unidadOrganizativa}', [UnidadOrganizativaController::class, 'update'])->name('unidadOrganizativa.update');
//eliminar
Route::get('unidadOrganizativa/destroy/{unidadOrganizativa}', [UnidadOrganizativaController::class, 'destroy'])->name('unidadOrganizativa.destroy');

//----------------------------Rubro------------------------
//listar
Route::get('rubro', [RubroController::class, 'index'])->name('rubro.index');
//crear
Route::get('rubro/crear', [RubroController::class, 'create'])->name('rubro.create');
Route::post('rubro/store', [RubroController::class, 'store'])->name('rubro.store');
//actualizar
Route::get('rubro/edit/{rubro}', [RubroController::class, 'edit'])->name('rubro.edit');
Route::put('rubro/update/{rubro}', [RubroController::class, 'update'])->name('rubro.update');
//eliminar
Route::get('rubro/destroy/{rubro}', [RubroController::class, 'destroy'])->name('rubro.destroy');

//----------------------------Producto------------------------
//listar
Route::get('producto', [ProductoController::class, 'index'])->name('producto.index');
//crear
Route::get('producto/crear', [ProductoController::class, 'create'])->name('producto.create');
Route::post('producto/store', [ProductoController::class, 'store'])->name('producto.store');
//actualizar
Route::get('producto/edit/{producto}', [ProductoController::class, 'edit'])->name('producto.edit');
Route::put('producto/update/{producto}', [ProductoController::class, 'update'])->name('producto.update');
//eliminar
Route::get('producto/destroy/{producto}', [ProductoController::class, 'destroy'])->name('producto.destroy');


//---------------------------RequisicionProducto------------------------------------------------------
Route::get('requisicionProducto', [RequisicionProductoController::class, 'index'])->name('requisicionProducto.index');
Route::get('requisicionProducto/estado', [RequisicionProductoController::class, 'estado'])->name('requisicionProducto.estado');
Route::get('requisicionProducto/revisar', [RequisicionProductoController::class, 'revisar'])->name('requisicionProducto.revisar');
Route::post('requisicionProducto', [RequisicionProductoController::class, 'store'])->name('requisicionProducto.store');
Route::put('requisicionProducto/completar/{requisicionProducto}', [RequisicionProductoController::class, 'update'])->name('requisicionProducto.pagar');
Route::put('requisicionProducto/aceptar/{requisicionProducto}', [RequisicionProductoController::class, 'aceptar'])->name('requisicionProducto.aceptarRequi');
Route::put('requisicionProducto/denegar/{requisicionProducto}', [RequisicionProductoController::class, 'denegar'])->name('requisicionProducto.denegarRequi');
Route::get('requisicionProducto/destroy/{requisicionProducto}', [RequisicionProductoController::class, 'destroy'])->name('requisicionProducto.destroy');


//---------------------------Detalle requisición------------------------------------------------------
Route::get('requisicionProducto/detalle/{requisicionProducto}', [DetalleRequisicionController::class, 'index'])->name('requisicionProducto.detalle');
Route::get('requisicionProducto/detalleRevision/{requisicionProducto}', [DetalleRequisicionController::class, 'detalle'])->name('requisicionProducto.detalleRevision');
Route::post('requisicionProducto/detalle/{requisicionProducto}/{producto}', [DetalleRequisicionController::class, 'store'])->name('detalleRequisicion.store');
Route::put('requisicionProducto/detalle/{requisicionProducto}/{detalleRequisicion}', [DetalleRequisicionController::class, 'update'])->name('detalleRequisicion.update');
Route::get('requisicionProducto/detalle/{requisicionProducto}/eliminar/{detalleRequisicion}', [DetalleRequisicionController::class, 'destroy'])->name('detalleRequisicion.destroy');



//---------------------------RecepcionCompra------------------------------------------------------
Route::controller(RecepcionCompraController::class)->group(function () {
  //Ingresar compras de productos
  Route::get('recepcionCompra', 'index')->name('recepcionCompra.index');
  Route::post('recepcionCompra/store', 'store')->name('recepcionCompra.store');
  Route::put('recepcionCompra/completar/{recepcionCompra}','update')->name('recepcionCompra.completar');
  Route::get('recepcionCompra/consultar', 'consultar')->name('recepcionCompra.consultar');
  Route::get('recepcionCompra/destroy/{recepcionCompra}',  'destroy')->name('recepcionCompra.destroy');
  Route::get('recepcionCompra/revisar', 'revisar')->name('recepcionCompra.revisar');

});

//---------------------------DetalleCompra------------------------------------------------------

Route::controller(DetalleCompraController::class)->group(function () {
  //Ingresar detalle
  Route::get('detalleCompra/revisar/{recepcionCompra}', 'index')->name('detalleCompra.detalle');
  Route::get('detalleCompra/detalle/{recepcionCompra}', 'create')->name('recepcionCompra.detalle'); //2
  Route::post('detalleCompra/detalle/{recepcionCompra}', 'store')->name('detalleCompra.store');

  //Editar recepcionCompra 
  Route::get('detalleCompra/detalle/edit/{recepcionCompra}/{detalleCompra}', 'edit')->name('detalleCompra.edit');
  Route::put('detalleCompra/detalle/update/{recepcionCompra}/{detalleCompra}', 'update')->name('detalleCompra.update');

  //Dar de baja el detalle del recepcionCompra
  Route::get('detalleCompra/detalle/destroy/{recepcionCompra}/{detalleCompra}', 'destroy')->name('detalleCompra.destroy');
});

//---------------------------Inventario------------------------------------------------------

Route::get('inventario', [InventarioController::class,'index'])->name('inventario.index');


<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\IngresoProducto\DetalleCompraController;
use App\Http\Controllers\RequisicionProducto\DetalleRequisicionController;
use App\Http\Controllers\IngresoProducto\DocumentoXCompraController;
use App\Http\Controllers\Catalogo\EstadoController;
use App\Http\Controllers\Inventario\InventarioController;
use App\Http\Controllers\Catalogo\MarcaController;
use App\Http\Controllers\Catalogo\MedidaController;
use App\Http\Controllers\Bodega\ProductoBodegaController;
use App\Http\Controllers\Catalogo\ProductoController;
use App\Http\Controllers\Catalogo\ProveedorController;
use App\Http\Controllers\IngresoProducto\RecepcionCompraController;
use App\Http\Controllers\Reporte\ReporteController;
use App\Http\Controllers\RequisicionProducto\RequisicionProductoController;
use App\Http\Controllers\Usuario\RolController;
use App\Http\Controllers\Catalogo\RubroController;
use App\Http\Controllers\Catalogo\UnidadOrganizativaController;
use App\Http\Controllers\Usuario\UserController;
use Illuminate\Support\Facades\Auth;
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
//Dashboard, esta ruta contiene la vista dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
//Esta ruta contiene la vista de el panel de administracion
Route::get('admin', [DashboardController::class, 'indexAdmin'])->name('dashboardAdmin')->middleware('can:Ver panel admin');
//----------------------------Estado------------------------
//listar
Route::get('estado', [EstadoController::class, 'index'])->name('estado.index')->middleware('can:Ver panel admin');
//crear
Route::view('estado/crear', 'catalogo.estado.create')->name('estado.create');
Route::post('estado/store', [EstadoController::class, 'store'])->name('estado.store');
//actualizar
Route::get('estado/edit/{estado}', [EstadoController::class, 'edit'])->name('estado.edit');
Route::put('estado/update/{estado}', [EstadoController::class, 'update'])->name('estado.update');
//eliminar
Route::get('estado/destroy/{estado}', [EstadoController::class, 'destroy'])->name('estado.destroy');
//----------------------------Marca------------------------
//listar
Route::get('marca', [MarcaController::class, 'index'])->name('marca.index')->middleware('can:SideBar: Catalogos');;
//crear
Route::view('marca/crear', 'catalogo.marca.create')->name('marca.create');
Route::post('marca/store', [MarcaController::class, 'store'])->name('marca.store');
//actualizar
Route::get('marca/edit/{marca}', [MarcaController::class, 'edit'])->name('marca.edit');
Route::put('marca/update/{marca}', [MarcaController::class, 'update'])->name('marca.update');
//eliminar
Route::get('marca/destroy/{marca}', [MarcaController::class, 'destroy'])->name('marca.destroy');
//----------------------------Proveedor------------------------
//listar
Route::get('proveedor', [ProveedorController::class, 'index'])->name('proveedor.index')->middleware('can:SideBar: Catalogos');
//crear
Route::view('proveedor/crear', 'catalogo.proveedor.create')->name('proveedor.create');
Route::post('proveedor/store', [ProveedorController::class, 'store'])->name('proveedor.store');
//actualizar
Route::get('proveedor/edit/{proveedor}', [ProveedorController::class, 'edit'])->name('proveedor.edit');
Route::put('proveedor/update/{proveedor}', [ProveedorController::class, 'update'])->name('proveedor.update');
//eliminar
Route::get('proveedor/destroy/{proveedor}', [ProveedorController::class, 'destroy'])->name('proveedor.destroy');
//----------------------------Medida------------------------
//listar
Route::get('medida', [MedidaController::class, 'index'])->name('medida.index')->middleware('can:SideBar: Catalogos');
//crear
Route::view('medida/crear', 'catalogo.medida.create')->name('medida.create');
Route::post('medida/store', [MedidaController::class, 'store'])->name('medida.store');
//actualizar
Route::get('medida/edit/{medida}', [MedidaController::class, 'edit'])->name('medida.edit');
Route::put('medida/update/{medida}', [MedidaController::class, 'update'])->name('medida.update');
//eliminar
Route::get('medida/destroy/{medida}', [MedidaController::class, 'destroy'])->name('medida.destroy');
//----------------------------UnidadOrganizativa------------------------
//listar
Route::get('unidadOrganizativa', [UnidadOrganizativaController::class, 'index'])->name('unidadOrganizativa.index')->middleware('can:SideBar: Catalogos');;
//crear
Route::view('unidadOrganizativa/crear', 'catalogo.unidadOrganizativa.create')->name('unidadOrganizativa.create');
Route::post('unidadOrganizativa/store', [UnidadOrganizativaController::class, 'store'])->name('unidadOrganizativa.store');
//actualizar
Route::get('unidadOrganizativa/edit/{unidadOrganizativa}', [UnidadOrganizativaController::class, 'edit'])->name('unidadOrganizativa.edit');
Route::put('unidadOrganizativa/update/{unidadOrganizativa}', [UnidadOrganizativaController::class, 'update'])->name('unidadOrganizativa.update');
//eliminar
Route::get('unidadOrganizativa/destroy/{unidadOrganizativa}', [UnidadOrganizativaController::class, 'destroy'])->name('unidadOrganizativa.destroy');
//----------------------------Rubro------------------------
//listar
Route::get('rubro', [RubroController::class, 'index'])->name('rubro.index')->middleware('can:SideBar: Catalogos');
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
Route::get('producto', [ProductoController::class, 'index'])->name('producto.index')->middleware('can:SideBar: Catalogos');
Route::get('productoDatos', [ProductoController::class, 'datosProducto'])->name('producto.datos')->middleware('can:SideBar: Catalogos');
//crear
Route::get('producto/crear', [ProductoController::class, 'create'])->name('producto.create');
Route::post('producto/store', [ProductoController::class, 'store'])->name('producto.store');
//actualizar
Route::get('producto/edit/{producto}', [ProductoController::class, 'edit'])->name('producto.edit');
Route::put('producto/update/{producto}', [ProductoController::class, 'update'])->name('producto.update');
//eliminar
Route::get('producto/destroy/{producto}', [ProductoController::class, 'destroy'])->name('producto.destroy');
//---------------------------RequisicionProducto------------------------------------------------------
// Ruta que contiene la vista 
Route::get('requisicionProducto', [RequisicionProductoController::class, 'index'])->name('requisicionProducto.index')->middleware('can:SideBar: Requisicion de producto');
Route::get('requisicionProducto/estado', [RequisicionProductoController::class, 'estado'])->name('requisicionProducto.estado')->middleware('can:SideBar: Requisicion de producto');
Route::get('requisicionProducto/revisar', [RequisicionProductoController::class, 'revisar'])->name('requisicionProducto.revisar')->middleware('can:SideBar: Revisar solicitudes');
Route::get('requisicionProducto/entregaSolicitud', [RequisicionProductoController::class, 'entrega'])->name('requisicionProducto.entrega')->middleware('can:SideBar: Solicitudes a entregar');
Route::get('requisicionProducto/recibida', [RequisicionProductoController::class, 'requisicionRecibida'])->name('requisicionProducto.recibida')->middleware('can:SideBar: Requisicion de producto');
Route::get('requisicionProducto/historialRecibidas', [RequisicionProductoController::class, 'historialRequi'])->name('requisicionProducto.historialRecibida')->middleware('can:SideBar: Historial requisiciones');

//Metodo para poner el estado de entregada 
Route::put('requisicionProducto/entregada/{requisicionProducto}', [RequisicionProductoController::class, 'requisicionEntregada'])->name('requisicionProducto.entregada');
Route::post('requisicionProducto', [RequisicionProductoController::class, 'store'])->name('requisicionProducto.store');
Route::get('requisicionProducto/edit/{requisicionProducto}', [RequisicionProductoController::class, 'edit'])->name('requisicionProducto.edit');
Route::put('requisicionProducto/update/{requisicionProducto}', [RequisicionProductoController::class, 'update'])->name('requisicionProducto.update');
Route::put('requisicionProducto/completar/{requisicionProducto}', [RequisicionProductoController::class, 'completar'])->name('requisicionProducto.completar');
Route::put('requisicionProducto/aceptar/{requisicionProducto}', [RequisicionProductoController::class, 'aceptar'])->name('requisicionProducto.aceptarRequi');
Route::put('requisicionProducto/denegar/{requisicionProducto}', [RequisicionProductoController::class, 'denegar'])->name('requisicionProducto.denegarRequi');
Route::get('requisicionProducto/destroy/{requisicionProducto}', [RequisicionProductoController::class, 'destroy'])->name('requisicionProducto.destroy');
//---------------------------Detalle requisición------------------------------------------------------
Route::get('requisicionProducto/detalle/{requisicionProducto}', [DetalleRequisicionController::class, 'index'])->name('requisicionProducto.detalle');
Route::get('datosDetalleProducto', [DetalleRequisicionController::class, 'datosDetalleProducto'])->name('requisicionProducto.datos');
Route::get('requisicionProducto/detalleRevision/{requisicionProducto}', [DetalleRequisicionController::class, 'detalle'])->name('requisicionProducto.detalleRevision');
Route::post('requisicionProducto/detalle/{requisicionProducto}/{producto}', [DetalleRequisicionController::class, 'store'])->name('detalleRequisicion.store');
Route::put('requisicionProducto/detalle/{requisicionProducto}/{detalleRequisicion}', [DetalleRequisicionController::class, 'update'])->name('detalleRequisicion.update');
Route::get('requisicionProducto/detalle/{requisicionProducto}/eliminar/{detalleRequisicion}', [DetalleRequisicionController::class, 'destroy'])->name('detalleRequisicion.destroy');
//---------------------------RecepcionCompra------------------------------------------------------
Route::controller(RecepcionCompraController::class)->group(function () {
	//Ingresar compras de productos
	Route::get('recepcionCompra', 'index')->name('recepcionCompra.index')->middleware('can:SideBar: Ingreso de producto');
	Route::post('recepcionCompra/store', 'store')->name('recepcionCompra.store');
	//Edicion de la recepcion de compra  como tal
	Route::get('recepcionCompra/edit/{recepcionCompra}', 'edit')->name('recepcionCompra.edit');
	Route::put('recepcionCompra/updateCompra/{recepcionCompra}', 'updateCompra')->name('recepcionCompra.updateCompra');

	Route::put('recepcionCompra/completar/{recepcionCompra}', 'update')->name('recepcionCompra.completar');
	Route::get('recepcionCompra/consultar', 'consultar')->name('recepcionCompra.consultar')->middleware('can:SideBar: Ingreso de producto');
	Route::get('recepcionCompra/destroy/{recepcionCompra}',  'destroy')->name('recepcionCompra.destroy');
	Route::get('recepcionCompra/revisar/{recepcionCompra}', 'revisar')->name('recepcionCompra.revisar');
});
Route::controller(DocumentoXCompraController::class)->group(function () {
	Route::get('documento/{recepcionCompra}', 'documentoBar')->name('recepcionCompra.documento');
	Route::get('documentoEdit/{recepcionCompra}', 'documentoEdit')->name('recepcionCompra.documentoEdit');
	Route::post('documentoPost/{recepcionCompra}', 'documentoBarPost')->name('recepcionCompra.documentoPost'); //2
	Route::get('leerDocumento/{documento}', 'leerDocumento')->name('leer.documento');
	Route::post('upload/{recepcionCompra}', 'upload')->name('upload.documento');
	Route::post('delete/{recepcionCompra}', 'delete')->name('delete.documento');
	Route::get('deleteEdit/{recepcionCompra}', 'deleteEdit')->name('deleteEdit.documento');
});
//---------------------------DetalleCompra------------------------------------------------------
Route::controller(DetalleCompraController::class)->group(function () {



	//DETALLE DE UNA RECEPCION DE UNA COMPRA QUE SE ESTA INGRESANDO

	//Ruta que dirige a la pantalla de creacion de los nuevos detalles
	Route::get('detalleCompra/detalleNuevo/{recepcionCompra}', 'index')->name('recepcionCompra.detalle');
	//Creacion de un nuevo detalle de productos
	Route::post('detalleCompra/detalleNuevo/{recepcionCompra}', 'store')->name('detalleCompra.store');
	//Edicion individual de un detalle
	Route::get('detalleCompra/detalleNuevo/{recepcionCompra}/{detalleCompra}', 'edit')->name('detalleCompra.edit');
	//Edicion de un detalle de compra no  inicializada
	Route::put('detalleCompra/detalleNuevo/update/{recepcionCompra}/{detalleCompra}', 'update')->name('detalleCompra.update');
	//Dar de baja el detalle del recepcionCompra no inicializada
	Route::get('detalleCompra/detalleNuevo/destroy/{recepcionCompra}/{detalleCompra}', 'destroy')->name('detalleCompra.destroy');

	//DETALLE DE UNA RECEPCION DE UNA COMPRA YA EXISTENTE Y REGISTRADA EN EL SISTEMA

	//Ruta que dirige a la pantalla de creacion de los nuevos detalles 
	Route::get('detalleCompra/detalleRegistrado/{recepcionCompra}', 'indexEdit')->name('recepcionCompra.detalleEdit');
	//Crear una nuevo detalle de una recepcion ya registrada
	Route::post('detalleCompra/detalleRegistrado/{recepcionCompra}', 'storeEdit')->name('detalleCompra.storeEdit');
	//Edicion individual de un detalle
	// Route::get('detalleCompra/detalleRegistrado/{recepcionCompra}', 'edit')->name('detalleCompra.editEdit');
	//Edicion de una detalle de compra ya finalizado
	Route::put('detalleCompra/detalleRegistrado/update/{recepcionCompra}/{detalleCompra}', 'updateEdit')->name('detalleCompra.updateEdit');
	//Dar de baha detalle cuando ya ha sido creada una recepcion ya inicializada 
	Route::get('detalleCompra/detalleRegistrado/destroy/{recepcionCompra}/{detalleCompra}', 'destroyEdit')->name('detalleCompra.destroyEdit');
});
//---------------------------Inventario------------------------------------------------------
Route::get('inventario', [InventarioController::class, 'index'])->name('inventario.index')->middleware('can:SideBar: Inventario');
Route::get('inventarioDatos', [InventarioController::class, 'datosInventario'])->name('inventario.datos')->middleware('can:SideBar: Inventario');

//--------------------------Salida de bodegas------------------------------------------------------
Route::get('productoBodega/principal', [ProductoBodegaController::class, 'index'])->name('productoBodega.index')->middleware('can:SideBar: Productos Bodega');
Route::get('productoBodega/secundaria', [ProductoBodegaController::class, 'index2'])->name('productoBodega.index2')->middleware('can:SideBar: Productos Bodega');
Route::post('productoBodega/{productoBodega}/', [ProductoBodegaController::class, 'store'])->name('productoBodega.store');

Auth::routes();

Route::middleware(['can:Ver panel admin'])->group(function () {

	//----------------------------Usuarios------------------------
	//listar
	Route::get('usuario', [UserController::class, 'index'])->name('usuario.index')->middleware('can:Ver panel admin');
	//crear
	Route::get('usuario/crear', [UserController::class, 'create'])->name('usuario.create');
	Route::post('usuario/store', [UserController::class, 'store'])->name('usuario.store');
	//actualizar
	Route::get('usuario/edit/{usuario}', [UserController::class, 'edit'])->name('usuario.edit')->middleware('can:Ver panel admin');
	Route::put('usuario/update/{usuario}', [UserController::class, 'update'])->name('usuario.update');
	//eliminar
	Route::get('usuario/destroy/{usuario}', [UserController::class, 'destroy'])->name('usuario.destroy');

	//----------------------------Asignar roles a usuario------------------------
	Route::get('rolesAssign', [RolController::class, 'indexRolesAssing'])->name('roles.indexAssign')->middleware('can:Ver panel admin');
	Route::get('/roles/{role}/assign-permissions', [RolController::class, 'showAssignPermissionsForm'])->name('roles.assign-permissions')->middleware('can:Ver panel admin');
	Route::post('/roles/{role}/assign-permissions', [RolController::class, 'assignPermissions'])->name('roles.assign-permissions');

	//----------------------------Roles------------------------
	//Listar
	Route::get('rol', [RolController::class, 'indexRoles'])->name('rol.index')->middleware('can:Ver panel admin');
	//crear
	Route::get('rol/crear', [RolController::class, 'createRoles'])->name('rol.create');
	Route::post('rol/store', [RolController::class, 'storeRoles'])->name('rol.store');
	//actualizar
	Route::get('rol/edit/{rol}', [RolController::class, 'editRoles'])->name('rol.edit')->middleware('can:Ver panel admin');
	Route::put('rol/update/{rol}', [RolController::class, 'updateRoles'])->name('rol.update');
	//eliminar
	Route::get('rol/destroy/{rol}', [RolController::class, 'destroyRoles'])->name('rol.destroy');
});
//----------------------------Reportes------------------------
//Reportes mensuales
//Pantalla de inicio
Route::get('reporte', [ReporteController::class, 'index'])->name('reporte.index')->middleware('can:SideBar: Reportes');
//Metodo para escoger
Route::post('reporte/reportesMensuales', [ReporteController::class, 'reportesMensuales'])->name('reporte.reportesMensuales');
Route::post('reporte/reportesGenerales', [ReporteController::class, 'reportesGenerales'])->name('reporte.reportesGenerales');
//---------------------------PDFs------------------------------------------------------
Route::get('requisicionProducto/pdf/comprobante/{requisicionProducto}', [ReporteController::class, 'comprobanteRequiProductoPDF'])->name('pdf.requisicionProducto');
Route::get('ingresoProducto/pdf/{recepcionCompra}', [ReporteController::class, 'ingresoProductoPDF'])->name('pdf.ingresoProducto');
Route::get('inventario/excel/', [InventarioController::class, 'downloadData'])->name('inventario.excel');
Route::get('requisicionProducto/pdf/aprobar/{requisicionProducto}', [ReporteController::class, 'aprobarRequiProductoPDF'])->name('pdf.aprobarRequisicionProducto');

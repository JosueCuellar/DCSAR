@extends('layoutsGeneral.admin.layouts.index')
@section('title', 'Dashboard')
@section('content')
    <div class="content">
        <div class="container-fluid">
            @can('Ver dashboard: Cantidad de solicitudes')
                <h5 class="text-bold">Cantidad de solicitudes</h5>
                <div class="row p-2">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box shadow">
                            <span class="info-box-icon text-white" style="background-color: #003f5c"><i
                                    class="far fa-envelope"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Enviadas</span>
                                <span class="info-box-number">{{ $nEnviadas }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box shadow">
                            <span class="info-box-icon text-white" style="background-color: #3e8e41">
                                <ion-icon name="checkmark-done-sharp" class="text-white"></ion-icon>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Aprobadas</span>
                                <span class="info-box-number">{{ $nAprobadas }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box shadow">
                            <span class="info-box-icon text-white" style="background-color: #e63946">
                                <ion-icon name="alert-circle-sharp" class="text-white"></ion-icon>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Rechazadas</span>
                                <span class="info-box-number">{{ $nRechazadas }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box shadow">
                            <span class="info-box-icon text-white" style="background-color: #dd8b26">
                                <ion-icon name="documents-sharp" class="text-white"></ion-icon>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Recibidas</span>
                                <span class="info-box-number">{{ $nRecibidas }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            @can('Ver dashboard: Accesos directos 1')
                <h5 class="text-bold">Accesos directos 1</h5>
                <div class="row p-2">
                    <div class="col-lg-3 col-6">
                        <div class="text-white small-box" style="background-color: #003f5c">
                            <div class="inner">
                                <h5>Requisición productos</h5>
                                <p>Agregar una nueva solicitud</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag">
                                    <ion-icon name="add-circle-sharp"></ion-icon>
                                </i>
                            </div>
                            <a href="{{ asset('requisicionProducto') }}" class="small-box-footer">Ver <i
                                    class="fas fa-external-link-square-alt"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="text-white small-box" style="background-color: #3e8e41">
                            <div class="inner">
                                <h5>Estado requisiciones</h5>
                                <p>Requisiciones en proceso</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag">
                                    <ion-icon name="hourglass-sharp"></ion-icon>
                                </i>
                            </div>
                            <a href="{{ asset('requisicionProducto/estado') }}" class="small-box-footer">Ver <i
                                    class="fas fa-external-link-square-alt"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="text-white small-box" style="background-color: #e63946 ">
                            <div class="inner">
                                <h5>Inventario</h5>
                                <p>Cantidad en existencias</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag">
                                    <ion-icon name="cube-sharp"></ion-icon>
                                </i>
                            </div>
                            <a href="{{ asset('inventario') }}" class="small-box-footer">Ver <i
                                    class="fas fa-external-link-square-alt"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="text-white small-box" style="background-color: #dd8b26 ">
                            <div class="inner">
                                <h5>Requisiciones Realizadas</h5>
                                <p>Historial de requisiciones recibidas</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag">
                                    <ion-icon name="pencil-sharp"></ion-icon>
                                </i>
                            </div>
                            <a href="{{ asset('requisicionProducto/recibida') }}" class="small-box-footer">Ver <i
                                    class="fas fa-external-link-square-alt"></i></a>
                        </div>
                    </div>
                </div>
            @endcan

            @can('Ver dashboard: Accesos directos 2')
                <h5 class="text-bold">Accesos directos 2</h5>
                <div class="row p-2">
                    <div class="col-lg-3 col-6">
                        <div class="text-white small-box" style="background-color: #003f5c">
                            <div class="inner">
                                <h5>Recepción de ingresos</h5>
                                <p>Agregar una entrada nueva de productos</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag">
                                    <ion-icon name="push-sharp"></ion-icon>
                                </i>
                            </div>
                            <a href="{{ asset('recepcionCompra') }}" class="small-box-footer">Ver <i
                                    class="fas fa-external-link-square-alt"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="text-white small-box" style="background-color: #3e8e41">
                            <div class="inner">
                                <h5>Producto nuevo</h5>
                                <p>Agregar un producto nuevo</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag">
                                    <ion-icon name="cafe-sharp"></ion-icon>
                                </i>
                            </div>
                            <a href="{{ asset('producto/crear') }}" class="small-box-footer">Ver <i
                                    class="fas fa-external-link-square-alt"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="text-white small-box" style="background-color: #e63946 ">
                            <div class="inner">
                                <h5>Consultar ingresos</h5>
                                <p>Ingresos registrados</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag">
                                    <ion-icon name="archive-sharp"></ion-icon>
                                </i>
                            </div>
                            <a href="{{ asset('recepcionCompra/consultar') }}" class="small-box-footer">Ver <i
                                    class="fas fa-external-link-square-alt"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="text-white small-box" style="background-color: #dd8b26  ">
                            <div class="inner">
                                <h5>Historial requisiciones</h5>
                                <p>Requisiciones entregadas</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag">
                                    <ion-icon name="file-tray-full-sharp"></ion-icon>
                                </i>
                            </div>
                            <a href="{{ asset('requisicionProducto/recibida') }}" class="small-box-footer">Ver <i
                                    class="fas fa-external-link-square-alt"></i></a>
                        </div>
                    </div>
                </div>
            @endcan

        </div>
    </div>
    {{-- Notificacion para saber si hay solicitudes por revisar --}}
    @if (Auth::user()->hasRole('Gerente Unidad Organizativa'))
        @if ($existe)
            @section('js_datatable')
                <script>
                    $(document).Toasts('create', {
                        title: 'Solicitudes',
                        position: 'topRight',
                        body: 'Hay {{ $n }} solicitudes enviadas por revisar.',
                        class: 'bg-info',
                        icon: ' far fa-file',
                    })
                </script>
            @endsection
        @endif
    @endif

@endsection

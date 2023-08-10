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
@section('js_datatable')
    @if (Auth::user()->hasRole('Gerente Unidad Organizativa'))
        @if ($existeEnviadas)
            <script>
                toastr.info('Hay {{ $nEnviadas }} solicitudes enviadas por revisar.', 'Solicitudes', {
                    positionClass: 'toast-top-right',
                    closeButton: true,
                    onclick: function() {
                        window.location.href = '/requisicionProducto/revisar';
                    }
                });
            </script>
        @endif
    @endif

    @if (Auth::user()->hasRole('Solicitante Unidad Organizativa'))
        @if ($existeRechazadas)
            <script>
                toastr.error('Tienes {{ $nRechazadas }} solicitudes rechazadas por revisar, click sobre la notificacion.',
                    'Solicitudes', {
                        positionClass: 'toast-top-right',
                        closeButton: true,
                        onclick: function() {
                            window.location.href = '/requisicionProducto/estado';
                        }
                    });
            </script>
        @endif
    @endif

    @if (Auth::user()->hasRole('Tecnico Encargado Almacen'))
        @if ($existeAceptadas)
            <script>
                toastr.info('Hay {{ $nAprobadasTodas }} solicitudes para entregar, click sobre la notificacion.', 'Solicitudes', {
                    closeButton: true,
                    onclick: function() {
                        window.location.href = '/requisicionProducto/entregaSolicitud';
                    }
                });
            </script>
        @endif
    @endif

@endsection

@endsection

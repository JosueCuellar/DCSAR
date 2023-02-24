@extends('admin.layouts.index')
@section('title', 'Dashboard')
@section('content')
    <div class="content">
        <div class="container-fluid">
            {{-- <h5 class="text-bold">Cantidad de solicitudes</h5>
            <div class="row p-2">
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box shadow">
                        <span class="info-box-icon text-white" style="background-color: #003f5c"><i
                                class="far fa-envelope"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Enviadas</span>
                            <span class="info-box-number">{{ $nEnviadas }}</span>
                        </div>

                    </div>

                </div>

                <div class="col-md-4 col-sm-6 col-12">
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

                <div class="col-md-4 col-sm-6 col-12">
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
            </div> --}}

            <h5 class="text-bold">Accesos directos</h5>
            <div class="row p-2">
                {{-- <div class="col-lg-4 col-6">
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

                <div class="col-lg-4 col-6">

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

                <div class="col-lg-4 col-6">
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
                </div> --}}

                <div class="col-lg-4 col-6">
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

                <div class="col-lg-4 col-6">

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

                <div class="col-lg-4 col-6">
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

            </div>
{{-- 
            <h5 class="text-bold">Proceso de requisiciones</h5>
            <div class="row p-2">
                <div class="col-lg-12">
                    <div class="card card-dark card-outline">
                        <ul class="list-group">
                            <li class="list-group-item "><b class="text-info">Enviada:</b> Indica que la solicitud ha
                                sido realizada y enviada por el solicitante para su revisión</li>
                            <li class="list-group-item"><b class="text-success">Aprobada:</b> Indica que la solicitud ha
                                sido aprobada con éxito por el jefe de la unidad organizativa</li>
                            <li class="list-group-item"><b class="text-danger">Rechazada:</b> Indica que la solicitud ha
                                sido rechazada y puede modificarse por el solicitante</li>
                        </ul>
                    </div>
                </div>

            </div> --}}

        </div>
    </div>


    {{-- @if ($existe)
        @section('js_datatable')
            <script>
                $(document).Toasts('create', {
                    title: 'Solicitudes',
                    position: 'topRight',
                    body: 'Hay {{ $n }} solicitudes recibidas por revisar.',
                    class: 'bg-info',
                    icon: '	far fa-file',
                })
            </script>
        @endsection
    @endif --}}

@endsection

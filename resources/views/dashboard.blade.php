@extends('admin.layouts.index')
@section('title', 'Dashboard')

@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">

                    <div class="text-white small-box" style="background-color: #992c4b">
                        <div class="inner">
                            <h5>Requisicion productos</h5>
                            <p>Agregar una nueva solicitud</p><br>
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

                    <div class="text-white small-box" style="background-color: #66324c">
                        <div class="inner">
                            <h5>Inventario</h5>
                            <p>Productos y su cantidad en existencia</p><br>
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

                    <div class="text-white small-box" style="background-color: #33384e">
                        <div class="inner">
                            <h5>Estado requisiciones</h5>
                            <p>Requisiciones en proceso</p><br>
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

                    <div class="text-white small-box" style="background-color: #003e4f">
                        <div class="inner">
                            <h5>Historial de requisiciones</h5>
                            <p>Requisiciones realizadas</p><br>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag">
                                <ion-icon name="documents-sharp"></ion-icon>
                            </i>
                        </div>
                        <a href="{{ asset('') }}" class="small-box-footer">Ver <i
                                class="fas fa-external-link-square-alt"></i></a>
                    </div>
                </div>



            </div>

            {{-- <div class="row">
                <div class="col-lg-3 col-6">

                    <div class="text-white small-box" style="background-color: #E74C3C">
                        <div class="inner">
                            <h5>Realizar solicitud</h5>
                            <p>Requisiciones de productos</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag">
                                <ion-icon name="hammer-outline"></ion-icon>
                            </i>
                        </div>
                        <a href="{{ asset('producto/crear') }}" class="small-box-footer">Ver  <i class="fas fa-external-link-square-alt"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="text-white small-box" style="background-color: #74766f
                    ">
                        <div class="inner">
                            <h5>Gris</h5>
                            <p>Ingresar nuevos productos</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag">
                                <ion-icon name="hammer-outline"></ion-icon>
                            </i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-success">
                        <div class="inner">
                            <h5>Productos</h5>
                            <p>Ingresar nuevos productos</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag">
                                <ion-icon name="hammer-outline"></ion-icon>
                            </i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="text-white small-box" style="background-color: #213058">
                        <div class="inner">
                            <h5>Productos</h5>
                            <p>Ingresar nuevos productos</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag">
                                <ion-icon name="hammer-outline"></ion-icon>
                            </i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>



            </div> --}}

            <div class="row">

                <div class="col-lg-12">
                    <div class="card border-dark card-dark card-outline">
                        <div class="card-header">
                            <h5 class="m-0"><b> Proceso de requisiciones</b></h5>
                        </div>
                        <div class="card-body">
                            <h5 class="m-0">Estado de las solicitudes
                                de bienes y/o insumos de los empleados de la Defensoría del
                                Consumidor</h5><br>
                            <ul class="list-group">
                                <li class="list-group-item "><b class="text-info">Enviada:</b> Indica que la solicitud ha
                                    sido realizada y enviada por le solicitante para su revisión</li>
                                <li class="list-group-item"><b class="text-success">Aprobada:</b> Indica que la solicitud ha
                                    sido aprobada con éxito por el jefe de la unidad organizativa</li>
                                <li class="list-group-item"><b class="text-danger">Rechazada:</b> Indica que la solicitud ha
                                    sido rechazada y puede modificarse por el solicitante</li>
                            </ul>
                            <p></p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>



@section('js_datatable')
    <script>
        if({{$existe}}){
            $(document).Toasts('create', {
            title: 'Solicitudes',
            position: 'topRight',
            body: 'Hay {{$n}} solicitudes recibidas por revisar.',
            class: 'bg-info',
            icon: '	far fa-file',
            buttons: 'xd'
        })
        }
    </script>
@endsection
@endsection

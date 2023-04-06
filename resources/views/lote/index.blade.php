@extends('admin.layouts.index')
@section('title', 'Entrega de productos')
@section('header')
    <h3 class="text-center">Salida lotes</h3>
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row">

                        <div class="col-6">
                            {{-- <h5 class="text-center">Selecciona los lotes y despacha</h5> --}}
                            <h5 class="text-center">Lotes disponibles</h5>

                            <div class="table-responsive">
                                <table class="table  table-sm table-striped table-bordered text-center" id="dataTable12"
                                    width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Descripcion</th>
                                            <th scope="col">Ubicacion</th>
                                            <th scope="col">Cant. Dispo</th>
                                            <th scope="col">Fecha de venc.</th>
                                            <th scope="col"></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $n = 0;
                                        @endphp
                                        @foreach ($lote as $item)
                                            <tr>
                                                {{-- <th scope="row">{{ $n = $n + 1 }}</th> --}}
                                                <td>{{ $item->producto->descripcion }}</td>
                                                <td>{{ $item->bodega->nombreBodega }}</td>
                                                <td>{{ $item->cantidadDisponible }}</td>
                                                <td>{{ $item->fechaVencimiento }}</td>
                                                <td>
                                                    <button type="submit" data-toggle="modal"
                                                        data-target="#exampleModalCenter"
                                                        data-requi="{{ $requisicionProducto->id }}"
                                                        data-producto="{{ $item->id }}"
                                                        class="btn btn-sm btn-outline-dark">Despachar</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>

                        </div>

                        <div class="col-6">
                            <h5 class="text-center">Productos a entregar</h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-bordered text-center" id="dataTable13"
                                    width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Eliminar</th>
                                            <th scope="col">Descripcion</th>
                                            <th scope="col">U. de Medida</th>
                                            <th scope="col">Cant. Solicitada</th>
                                            <th scope="col">Cant. Entregada</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($detalle_requisicion as $item)
                                        @php
                                            $var1 = $item->cantidad;
                                            $var2 = $item->cantidadEntregada;
                                        @endphp
                                            @if ($var1 != $var2)
                                                <tr >
                                                    {{-- <th scope="row">{{ $n = $n + 1 }}</th> --}}
                                                    <th scope="row" class="dtr-control sorting_1" tabindex="0"
                                                        style="">
                                                        <a href="#" data-toggle="modal" data-target="#deleteModal"
                                                            data-ventaid="1" data-detalleid="1">
                                                            <ion-icon name="trash-outline"
                                                                class="fa-lg text-danger md hydrated" role="img"
                                                                aria-label="trash outline"></ion-icon>
                                                        </a>
                                                    </th>
                                                    <td>{{ $item->producto->descripcion }}</td>
                                                    <td>{{ $item->producto->medida->nombreMedida }}</td>
                                                    <td>{{ $item->cantidad }}</td>
                                                    <td>{{ $item->cantidadEntregada }}</td>

                                                </tr>
                                            @else
                                            <tr class="table-success">
                                                {{-- <th scope="row">{{ $n = $n + 1 }}</th> --}}
                                                    <th scope="row" class="dtr-control sorting_1" tabindex="0"
                                                        style="">
                                                        <a href="#" data-toggle="modal" data-target="#deleteModal"
                                                            data-ventaid="1" data-detalleid="1">
                                                            <ion-icon name="trash-outline"
                                                                class="fa-lg text-danger md hydrated" role="img"
                                                                aria-label="trash outline"></ion-icon>
                                                        </a>
                                                    </th>
                                                    <td>{{ $item->producto->descripcion }}</td>
                                                    <td>{{ $item->producto->medida->nombreMedida }}</td>
                                                    <td>{{ $item->cantidad }}</td>
                                                    <td>{{ $item->cantidadEntregada }}</td>

                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>

                        </div>


                    </div>

                </div>
            </div>


        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form method="POST" class="form-horizontal" action="">
                @csrf
                @method('POST')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Ingrese la cantidad a despachar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group has-feedback row">
                                        <label for="cantidad" class="col-12 control-label">Cantidad de
                                            productos:</label>
                                        <div class="col-12">
                                            <input id="cantidadEntregada" type="number" class="form-control"
                                                name="cantidadEntregada" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <a class="btn btn-dark" onclick="$(this).closest('form').submit();">Guardar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>


@section('js_datatable')
    <script>
        $(document).ready(function() {
            $('#dataTable12').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                "paging": false,
                "ordering": false,
                "info": false,
                "scrollY": 350,
                "autoWidth": false,
                "responsive": true,
                "columnDefs": [{
                        "responsivePriority": 10001,
                        "targets": 1
                    },
                    {
                        "responsivePriority": 10002,
                        'targets': 2
                    }
                ]
            });
        });
    </script>


    <script>
        $('#exampleModalCenter').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var requi = button.data('requi')
            var producto = button.data('producto')
            var modal = $(this)
            console.log(producto)
            modal.find('form').attr('action', '{{ asset('/lote/despacho/') }}' + '/' +
                requi + '/' + producto);
        })
    </script>
    <script>
        $(document).ready(function() {
            $('#dataTable13').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                "paging": false,
                "ordering": false,
                "info": false,
                "scrollY": 350,
                "autoWidth": false,
                "responsive": true,
                "columnDefs": [{
                        "responsivePriority": 10001,
                        "targets": 1
                    },
                    {
                        "responsivePriority": 10002,
                        'targets': 2
                    }
                ]
            });
        });
    </script>

    <script>
        $(function() {
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });

            $('.filter-container').filterizr({
                gutterPixels: 3
            });
            $('.btn[data-filter]').on('click', function() {
                $('.btn[data-filter]').removeClass('active');
                $(this).addClass('active');
            });
        })
    </script>


@endsection

@endsection

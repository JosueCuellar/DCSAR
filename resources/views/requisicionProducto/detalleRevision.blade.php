@extends('admin.layouts.index')
@section('title', 'Detalle requisición')
@section('header')
    <div class="col-md-12">
        <h2>Revisión de solicitud</h2>
    </div>
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 p-2">
                    <div class="card mb-3">
                        <div class="card-header">
                            <b>Detalles de la Requisición de Productos</b>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">Unidad Organizativa: <label>------------------------------------</label>
                                </div>
                                <div class="col-6">Fecha de solicitud:
                                    <label>{{ $requisicionProducto->fecha_requisicion }}</label>
                                </div>
                            </div>
                            <br>

                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header">
                            <b>Detalle de Solicitud</b>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped text-center" id="dataTable12" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Codigo de Producto</th>
                                            <th scope="col">Unidad de Medida</th>
                                            <th scope="col">Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($detalle_requisicion as $item)
                                            <tr>
                                                <th scope="row">{{ $item->producto->cod_producto }}</th>
                                                <td>{{ $item->producto->medida->nombreMedida }}</td>
                                                <td>{{ $item->cantidad }}</td>
                                            </tr>
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

@section('js_datatable')
    <script>
        $(document).ready(function() {
            $('#dataTable12').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },                "autoWidth": false,
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

@extends('admin.layouts.index')
@section('title', 'Detalle requisición')
@section('header')
    <div class="col-md-12">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2 class="text-center">Revisión de solicitud</h2>
                <div class="pull-right">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm float-right"
                        data-toggle="tooltip" data-placement="left" title
                        data-original-title="Regresar a lista de marcas">Regresar</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <style>
        .row {
            font-size: 16px;
            line-height: 1.2;
            padding: 4px;
        }
    </style>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 p-2">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                @if (!empty($requisicionProducto->nCorrelativo))
                                    <div class="col-6">Numero Correlativo:
                                        <label>{{ $requisicionProducto->nCorrelativo }}</label>
                                    </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-6">Unidad Organizativa:
                                    <label>{{ $requisicionProducto->user->unidadOrganizativa->nombreUnidadOrganizativa ?? '' }}</label>
                                </div>
                                <div class="col-6">Fecha de solicitud:
                                    <label>{{ $requisicionProducto->fechaRequisicion }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">Descripcion: <label>{{ $requisicionProducto->descripcion }}</label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped text-center" id="dataTable12" width="100%"
                                    cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">N</th>
                                            <th scope="col">Codigo de Producto</th>
                                            <th scope="col">Cantidad</th>
                                            <th scope="col">Unidad de Medida</th>
                                            <th scope="col">Descripcion</th>
                                            <th scope="col">Precio Unit</th>
                                            <th scope="col">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $n = 0;
                                        @endphp
                                        @foreach ($detalle_requisicion as $item)
                                            <tr>
                                                <th scope="row">{{ $n = $n + 1 }}</th>
                                                <td>{{ $item->producto->codProducto }}</td>
                                                <td>{{ $item->cantidad }}</td>
                                                <td>{{ $item->producto->medida->nombreMedida }}</td>
                                                <td>{{ $item->producto->descripcion }}</td>
                                                <td>${{ $item->producto->costoPromedio }}</td>
                                                <td>${{ $item->total  }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="thead-light">
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col">Total</th>
                                        <th scope="col">${{ $totalFinal }}</th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    @if (!empty($requisicionProducto->observacion))
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5>Observaciones</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <label>{{ $requisicionProducto->observacion }}</label>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
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
@endsection

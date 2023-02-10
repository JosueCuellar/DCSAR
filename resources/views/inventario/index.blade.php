@extends('admin.layouts.index')
@section('title', 'Inventario')
@section('header')
    <div class="row">
        <div class="col-12">
            <h2>Inventario</h2>
        </div>
    </div>
@endsection
@section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="card card-secondary card-outline" style="width: 100%">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped text-center" id="dataTable25" width="100%"
                                    cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Codigo producto</th>
                                            <th scope="col">Descripción producto</th>
                                            <th scope="col">Observacion</th>
                                            <th scope="col">Cantidad disponible</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($inventarios as $item)
                                            <tr>
                                                <th scope="row">{{ $item->cod_producto }}</th>
                                                <td>{{ $item->descripcion }}</td>
                                                <td>{{ $item->observacion }}</td>
                                                <td>{{ $item->stock }}</td>
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
@section('js_datatable')

    <script>
        $(document).ready(function() {
            $('#dataTable25').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
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
@endsection

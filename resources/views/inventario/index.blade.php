@extends('admin.layouts.index')
@section('title', 'Inventario')
@section('content')


    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <h2>Inventario</h2>
                </div>
            </div>
            <div class="row">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable25" width="100%" cellspacing="0">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Nombre comercial medicamento</th>
                                    <th scope="col">Presentacion medicamento</th>
                                    <th scope="col">Observacion</th>
                                    <th scope="col">Cantidad disponible</th>
                                </tr>
                            </thead>
                            <tfoot class="thead-light">
                                <tr>
                                    <th scope="col">Nombre comercial medicamento</th>
                                    <th scope="col">Presentacion medicamento</th>
                                    <th scope="col">Observacion</th>
                                    <th scope="col">Cantidad disponible</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($inventarios as $item)
                                    <tr>
                                        <td scope="row">{{ $item->cod_producto }}</td>
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
@section('js_datatable')

    <script>
        $(document).ready(function() {
            $('#dataTable25').DataTable({
                dom: '<"top"i>rt<"bottom"flp><"clear">',
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });
        });
    </script>

@endsection
@endsection

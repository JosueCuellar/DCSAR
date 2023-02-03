@extends('admin.layouts.index')
@section('title', 'Revisicion de requisicion')
@section('content')

    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-6">
                    <h2>Revision de Solicitudes</h2>
                </div>
            </div>


            <div class="row">
                <div class="card card-secondary card-outline" style="width: 100%">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-edit"></i>
                            Estado de requisiciones
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <h4></h4>
                        </div>

                        <div class="row">
                            <div class="table-responsive">
                                <table class="table" id="dataTable11" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Numero correlativo</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Estado</th>
                                            <th scope="col">Opciones</th>

                                        </tr>
                                    </thead>
                                    <tfoot class="thead-light">
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Numero correlativo</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Estado</th>
                                            <th scope="col">Opciones</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($requisicionesEnviadas as $item)
                                            <tr>
                                                <th scope="row">{{ $item->id }}</th>
                                                <td>{{ $item->nCorrelativo }}</td>
                                                <td>{{ $item->fecha_requisicion }}</td>
                                                <td><span class="badge badge-info">{{ $item->estado->nombreEstado }}</span>
                                                </td>
                                                <td>
                                                    <form
                                                        action="{{ route('requisicionProducto.detalleRevision', $item->id) }}"
                                                        method="GET">
                                                        @csrf
                                                        @method('get')
                                                        <button type="submit" class="btn btn-block bg-gradient-info"
                                                            style="margin-bottom:1em">Ver</button>
                                                    </form>
                                                </td>
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
            $('#dataTable10').DataTable({
                dom: '<"top"i>rt<"bottom"flp><"clear">',
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });
            $('#dataTable11').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });
        });
    </script>

@endsection

@endsection

@extends('admin.layouts.index')
@section('title', 'Estados requisiciones')
@section('content')

    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-6">
                    <h2>Requisiciones de productos</h2>
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
                            <div class="col-5 col-sm-3">
                                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <a class="nav-link active" id="vert-tabs-home-tab" data-toggle="pill"
                                        href="#vert-tabs-home" role="tab" aria-controls="vert-tabs-home"
                                        aria-selected="true">Requisiciones Aprobadas</a>
                                    <a class="nav-link" id="vert-tabs-profile-tab" data-toggle="pill"
                                        href="#vert-tabs-profile" role="tab" aria-controls="vert-tabs-profile"
                                        aria-selected="false">Requisiciones Enviadas</a>
                                    <a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill"
                                        href="#vert-tabs-messages" role="tab" aria-controls="vert-tabs-messages"
                                        aria-selected="false">Requisiciones Rechazadas</a>

                                </div>
                            </div>
                            <div class="col-7 col-sm-9">
                                <div class="tab-content" id="vert-tabs-tabContent">

                                    <div class="tab-pane text-left fade show active" id="vert-tabs-home" role="tabpanel"
                                        aria-labelledby="vert-tabs-home-tab">                                        
                                        <div class="table-responsive">
                                            <table class="table" id="dataTable11" width="100%" cellspacing="0">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Numero correlativo</th>
                                                        <th scope="col">Fecha</th>
                                                        <th scope="col">Estado</th>
                                                        <th scope="col">Ver</th>
                                                    </tr>
                                                </thead>
                                                <tfoot class="thead-light">
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Numero correlativo</th>
                                                        <th scope="col">Fecha</th>
                                                        <th scope="col">Estado</th>
                                                        <th scope="col">Ver</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    @foreach ($requisicionesAprobadas as $item)
                                                        <tr>
                                                            <th scope="row">{{ $item->id }}</th>
                                                            <td>{{ $item->nCorrelativo }}</td>
                                                            <td>{{ $item->fecha_requisicion }}</td>
                                                            <td><span class="badge badge-success">{{ $item->estado->nombreEstado }}</span></td>
                                                            <td>
                                                                <a href="{{ route('requisicionProducto.detalle', $item->id) }}"><ion-icon name="eye-outline" class="fa-lg text-success"></ion-icon></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>                                        
                                    </div>

                                    <div class="tab-pane fade" id="vert-tabs-profile" role="tabpanel"
                                        aria-labelledby="vert-tabs-profile-tab">
                                        <div class="table-responsive">
                                            <table class="table" id="dataTable12" width="100%" cellspacing="0">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Numero correlativo</th>
                                                        <th scope="col">Fecha</th>
                                                        <th scope="col">Estado</th>
                                                        <th scope="col">Editar</th>
                                                    </tr>
                                                </thead>
                                                <tfoot class="thead-light">
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Numero correlativo</th>
                                                        <th scope="col">Fecha</th>
                                                        <th scope="col">Estado</th>
                                                        <th scope="col">Editar</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    @foreach ($requisicionesEnviadas as $item)
                                                        <tr>
                                                            <th scope="row">{{ $item->id }}</th>
                                                            <td>{{ $item->nCorrelativo }}</td>
                                                            <td>{{ $item->fecha_requisicion }}</td>
                                                            <td><span class="badge badge-info">{{ $item->estado->nombreEstado }}</span></td>
                                                            <td>
                                                                <a href="{{ route('requisicionProducto.detalle', $item->id) }}"><ion-icon name="create-outline" class="fa-lg text-primary"></ion-icon></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div> 
                                    </div>

                                    <div class="tab-pane fade" id="vert-tabs-messages" role="tabpanel"
                                        aria-labelledby="vert-tabs-messages-tab">
                                        <div class="table-responsive">
                                            <table class="table" id="dataTable13" width="100%" cellspacing="0">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Numero correlativo</th>
                                                        <th scope="col">Fecha</th>
                                                        <th scope="col">Estado</th>
                                                        <th scope="col">Editar</th>
                                                    </tr>
                                                </thead>
                                                <tfoot class="thead-light">
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Numero correlativo</th>
                                                        <th scope="col">Fecha</th>
                                                        <th scope="col">Estado</th>
                                                        <th scope="col">Editar</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    @foreach ($requisicionesRechazadas as $item)
                                                        <tr>
                                                            <th scope="row">{{ $item->id }}</th>
                                                            <td>{{ $item->nCorrelativo }}</td>
                                                            <td>{{ $item->fecha_requisicion }}</td>
                                                            <td><span class="badge badge-danger">{{ $item->estado->nombreEstado }}</span></td>
                                                            <td>
                                                                <a href="{{ route('requisicionProducto.detalle', $item->id) }}"><ion-icon name="create-outline" class="fa-lg text-primary"></ion-icon></a>
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
            $('#dataTable12').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });

            $('#dataTable13').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });
            $('#dataTable14').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });
        });
    </script>

@endsection

@endsection

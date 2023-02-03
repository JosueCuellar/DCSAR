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
                    <div class="card-body card-secondary">
                        <div class="row">
                            <div class="col-5 col-sm-3">
                                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <a class="nav-link active" id="vert-tabs-enviadas-tab" data-toggle="pill"
                                        href="#vert-tabs-enviadas" role="tab" aria-controls="vert-tabs-enviadas"
                                        aria-selected="true">
                                        <p>
                                            <h5>Enviadas
                                                <b><span class="badge badge-info float-right">{{ $nEnviadas }}</span></b>
                                            </h5>
                                        </p>
                                    </a>
                                    <a class="nav-link" id="vert-tabs-aceptadas-tab" data-toggle="pill"
                                        href="#vert-tabs-aceptadas" role="tab" aria-controls="vert-tabs-aceptadas"
                                        aria-selected="false">
                                        <p>
                                            <h5>Aprobadas
                                                <b><span class="badge badge-success float-right">{{ $nAprobadas }}</b>
                                            </h5></span>
                                        </p>
                                    </a>
                                    <a class="nav-link" id="vert-tabs-rechazadas-tab" data-toggle="pill"
                                        href="#vert-tabs-rechazadas" role="tab" aria-controls="vert-tabs-rechazadas"
                                        aria-selected="false">
                                        <p>
                                            <h5>Rechazadas
                                                <b><span class="badge badge-danger float-right">{{ $nRechazadas }}</b>
                                            </h5></span>
                                        </p>
                                    </a>

                                </div>
                            </div>
                            <div class="col-7 col-sm-9">
                                <div class="tab-content" id="vert-tabs-tabContent">

                                    {{-- Enviadas --}}
                                    <div class="tab-pane text-left fade show active" id="vert-tabs-enviadas" role="tabpanel"
                                        aria-labelledby="vert-tabs-enviadas-tab">
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
                                                            <td><span
                                                                    class="badge badge-info">{{ $item->estado->nombreEstado }}</span>
                                                            </td>
                                                            <td>
                                                                <a
                                                                    href="{{ route('requisicionProducto.detalle', $item->id) }}">
                                                                    <ion-icon name="create-outline"
                                                                        class="fa-lg text-primary"></ion-icon>
                                                                </a>

                                                                <a href="{{ route('requisicionProducto.destroy', $item) }}"
                                                                data-toggle="modal" data-target="#deleteModal"
                                                                data-categoriaid="{{ $item->id }}">
                                                                <ion-icon name="trash-outline" class="fa-lg text-danger">></ion-icon>
                                                            </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    {{-- Aceptadas --}}
                                    <div class="tab-pane fade" id="vert-tabs-aceptadas" role="tabpanel"
                                        aria-labelledby="vert-tabs-aceptadas-tab">
                                        <div class="table-responsive">
                                            <table class="table" id="dataTable12" width="100%" cellspacing="0">
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
                                                            <td><span
                                                                    class="badge badge-success">{{ $item->estado->nombreEstado }}</span>
                                                            </td>
                                                            <td>
                                                                <a
                                                                    href="{{ route('requisicionProducto.detalleRevision', $item->id) }}">
                                                                    <ion-icon name="eye-outline"
                                                                        class="fa-lg text-success">
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    {{-- Denegadas --}}
                                    <div class="tab-pane fade" id="vert-tabs-rechazadas" role="tabpanel"
                                        aria-labelledby="vert-tabs-rechazadas-tab">
                                        <div class="table-responsive">
                                            <table class="table" id="dataTable13" width="100%" cellspacing="0">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Numero correlativo</th>
                                                        <th scope="col">Fecha</th>
                                                        <th scope="col">Estado</th>
                                                        <th scope="col">Observacion</th>
                                                        <th scope="col">Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tfoot class="thead-light">
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Numero correlativo</th>
                                                        <th scope="col">Fecha</th>
                                                        <th scope="col">Estado</th>
                                                        <th scope="col">Observacion</th>
                                                        <th scope="col">Opciones</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    @foreach ($requisicionesRechazadas as $item)
                                                        <tr>
                                                            <th scope="row">{{ $item->id }}</th>
                                                            <td>{{ $item->nCorrelativo }}</td>
                                                            <td>{{ $item->fecha_requisicion }}</td>
                                                            <td><span
                                                                    class="badge badge-danger">{{ $item->estado->nombreEstado }}</span>
                                                            </td>
                                                            <td>{{ $item->observacion }}</td>
                                                            <td>
                                                                <a
                                                                    href="{{ route('requisicionProducto.detalle', $item->id) }}">
                                                                    <ion-icon name="create-outline"
                                                                        class="fa-lg text-primary"></ion-icon>
                                                                </a>
                                                                <a href="{{ route('requisicionProducto.destroy', $item) }}"
                                                                data-toggle="modal" data-target="#deleteModal"
                                                                data-categoriaid="{{ $item->id }}">
                                                                <ion-icon name="trash-outline" class="fa-lg text-danger">></ion-icon>
                                                            </a>

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
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">¿Estás seguro de que quieres eliminar esto?
                        </h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Seleccione "eliminar" Si realmente desea eliminar a este registro
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                        <form method="POST" action="">
                            @method('GET')
                            @csrf
                            <!--{{-- <input type="hidden" id="user_id" name="user_id" value=""> --}}-->
                            <a class="btn btn-danger" onclick="$(this).closest('form').submit();">Borrar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('js_datatable')

    <script>
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var categoria_id = button.data('categoriaid')

            var modal = $(this)
            // modal.find('.modal-footer #user_id').val(user_id)
            modal.find('form').attr('action', '{{ asset('/requisicionProducto/destroy/') }}' + '/' +
                categoria_id);
        })
    </script>

    <script>
        $(document).ready(function() {

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
        });
    </script>

@endsection

@endsection

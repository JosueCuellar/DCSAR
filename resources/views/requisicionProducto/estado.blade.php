@extends('admin.layouts.index')
@section('title', 'Estados requisiciones')
@section('header')
    <div class="col-md-12">
        <h2>Estado de las requisiciones</h2>
    </div>
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-secondary card-outline card-outline-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="enviadas-tab" data-toggle="pill" href="#enviadas"
                                        role="tab" aria-controls="enviadas" aria-selected="true"><h6>Enviadas <span class="badge badge-info">{{$nEnviadas}}</span></h6>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="aceptadas-tab" data-toggle="pill" href="#aceptadas"
                                        role="tab" aria-controls="aceptadas" aria-selected="false"><h6>Aprobadas <span class="badge badge-success">{{$nAprobadas}}</span></h6></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="denegadas-tab" data-toggle="pill" href="#denegadas"
                                        role="tab" aria-controls="denegadas" aria-selected="false"><h6>Denegadas <span class="badge badge-danger">{{$nRechazadas}}</span></h6></a>
                                </li>

                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">

                                {{-- Enviadas --}}
                                <div class="tab-pane fade active show" id="enviadas" role="tabpanel"
                                    aria-labelledby="enviadas-tab">
                                    <table class="table table-sm table-striped text-center" id="dataTable11" width="100%"
                                        cellspacing="0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Fecha</th>
                                                <th scope="col">Descripción</th>
                                                <th scope="col">Estado</th>
                                                <th scope="col">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($requisicionesEnviadas as $item)
                                                    <td scope="row">{{ $item->fecha_requisicion }}</td>
                                                    <td>{{ $item->descripcion }}</td>
                                                    <td><span
                                                            class="badge badge-info">{{ $item->estado->nombre_estado }}</span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('requisicionProducto.detalle', $item->id) }}">
                                                            <ion-icon name="create-outline" class="fa-lg text-primary">
                                                            </ion-icon>
                                                        </a>

                                                        <a href="{{ route('requisicionProducto.destroy', $item) }}"
                                                            data-toggle="modal" data-target="#deleteModal"
                                                            data-categoriaid="{{ $item->id }}">
                                                            <ion-icon name="trash-outline" class="fa-lg text-danger">
                                                            </ion-icon>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Aceptadas --}}
                                <div class="tab-pane fade" id="aceptadas" role="tabpanel" aria-labelledby="aceptadas-tab">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped text-center" id="dataTable12" width="100%"
                                            cellspacing="0">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">Número correlativo</th>
                                                    <th scope="col">Fecha</th>
                                                    <th scope="col">Descripción</th>
                                                    <th scope="col">Observacion</th>
                                                    <th scope="col">Estado</th>
                                                    <th scope="col">Ver</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($requisicionesAprobadas as $item)
                                                    <tr>
                                                        <th scope="row">{{ $item->nCorrelativo }}</th>
                                                        <td>{{ $item->fecha_requisicion }}</td>
                                                        <td>{{ $item->descripcion }}</td>
                                                        <td>{{ $item->observacion }}</td>

                                                        <td><span
                                                                class="badge badge-success">{{ $item->estado->nombre_estado }}</span>
                                                        </td>
                                                        <td>
                                                            <a
                                                                href="{{ route('requisicionProducto.detalleRevision', $item->id) }}">
                                                                <ion-icon name="eye-outline" class="fa-lg text-success"></ion-icon>
                                                            </a>
                                                            <a
                                                            href="{{ route('pdf.aprobarRequisicionProducto', $item->id) }}">
                                                            <ion-icon name="document-text-outline"  class="fa-lg text-secondary"></ion-icon>
                                                        </a>
                                                        </td>
                                                        
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- Denegadas --}}
                                <div class="tab-pane fade" id="denegadas" role="tabpanel" aria-labelledby="denegadas-tab">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped text-center" id="dataTable13" width="100%"
                                            cellspacing="0">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">Fecha</th>
                                                    <th scope="col">Descripción</th>
                                                    <th scope="col">Observacion</th>
                                                    <th scope="col">Estado</th>
                                                    <th scope="col">Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($requisicionesRechazadas as $item)
                                                    <tr>
                                                        <td scope="row">{{ $item->fecha_requisicion }}</td>
                                                        <td>{{ $item->descripcion }}</td>
                                                        <td>{{ $item->observacion }}</td>

                                                        <td><span
                                                                class="badge badge-danger">{{ $item->estado->nombre_estado }}</span>
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
                                                                <ion-icon name="trash-outline" class="fa-lg text-danger">
                                                                </ion-icon>
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
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">¿Estás seguro de que quieres eliminar esto?
                        </h6>
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
            $('a[data-toggle="pill"]').on('shown.bs.tab', function(e) {
                $.fn.dataTable.tables({
                    visible: true,
                    api: true
                }).columns.adjust();
            });
            
            $('#dataTable11').DataTable({
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

            $('#dataTable12').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                "autoWidth": false,
                "responsive": true,
                "columnDefs": [{
                        "responsivePriority": 10043,
                        "targets": 2
                    },
                    {
                        "responsivePriority": 10003,
                        'targets': 3
                    },
                    {
                    "responsivePriority": 10002,
                        "targets": 4
                    },
                    {
                    "responsivePriority": 10001,
                        "targets": 1
                    }
                ]
            });

            $('#dataTable13').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                "autoWidth": false,
                "responsive": true,
                "columnDefs": [{
                        "responsivePriority": 10002,
                        "targets": 1
                    },
                    {
                        "responsivePriority": 10003,
                        'targets': 2
                    },
                    {
                        "responsivePriority": 10001,
                        'targets': 3
                    }
                ]
            });
        });
    </script>

@endsection
@endsection

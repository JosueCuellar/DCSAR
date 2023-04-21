@extends('admin.layouts.index')
@section('title', 'Recepción Ingreso')
@section('header')
    <div class="col-md-12">
        <h2>Registros del ingreso de productos</h2>
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
                                        role="tab" aria-controls="enviadas" aria-selected="true">
                                        <h6>Ingresos registrados</h6>
                                    </a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a class="nav-link" id="aceptadas-tab" data-toggle="pill" href="#aceptadas"
                                        role="tab" aria-controls="aceptadas" aria-selected="false"><h6>Compras SIN COMPLETAR</h6></a>
                                </li> --}}
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">

                                {{-- Completas --}}
                                <div class="tab-pane fade active show" id="enviadas" role="tabpanel"
                                    aria-labelledby="enviadas-tab">
                                    <table class="table table-sm table-striped text-center" id="dataTable11" width="100%"
                                        cellspacing="0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Fecha realización</th>
                                                <th scope="col">Número de orden de compra</th>
                                                <th scope="col">Número presupuestario</th>
                                                <th scope="col">Código factura</th>
                                                <th scope="col">Proveedor</th>
                                                <th scope="col">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recepcionesCompletas as $item)
                                                <td scope="row">{{ $item->created_at }}</td>
                                                <td>{{ $item->nOrdenCompra }}</td>
                                                <td>{{ $item->nPresupuestario }}</td>
                                                <td>{{ $item->codigoFactura }}</td>
                                                <td>{{ $item->proveedor->nombreComercial }}</td>

                                                <td>
                                                    <a href="{{ route('recepcionCompra.revisar', $item->id) }}">
                                                        <ion-icon name="eye-outline" class="fa-lg text-success">
                                                        </ion-icon>
                                                    </a>

                                                    <a href="{{ route('recepcionCompra.detalle', $item->id) }}">
                                                        <ion-icon name="create-outline" class="fa-lg text-primary">
                                                        </ion-icon>
                                                    </a>

                                                    <a href="{{ route('recepcionCompra.destroy', $item) }}"
                                                        data-toggle="modal" data-target="#deleteModal"
                                                        data-delete="{{ $item->id }}">
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
@endsection

@section('js_datatable')

    <script>
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var delete_id = button.data('delete')
            var modal = $(this)
            modal.find('form').attr('action', '{{ asset('/recepcionCompra/destroy/') }}' + '/' +
                delete_id);
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

        });
    </script>

@endsection

@section('js')
    @if (session('status'))
        <script>
            $(document).Toasts('create', {
                title: 'Registro de ingreso correcto',
                position: 'topRight',
                body: '{{ session('status') }}',
                class: 'bg-info',
                autohide: true,
                icon: 'fas fa-solid fa-check',
                delay: 3500,
                close: false,
            })
        </script>
    @endif

    @if (session('delete'))
        <script>
            $(document).Toasts('create', {
                position: 'topRight',
                title: 'Registro de ingreso eliminada',
                body: '{{ session('delete') }}, se ha actualizado la tabla',
                class: 'bg-danger',
                autohide: true,
                icon: 'fas fa-solid fa-trash',
                delay: 3500,
                close: false,
            })
        </script>
    @endif

    @if (session('error'))
        <script>
            $(document).Toasts('create', {
                title: 'Notificación',
                position: 'topRight',
                body: '{{ session('error') }}',
                class: 'bg-warning',
                autohide: true,
                icon: 'fas fa-solid fa-xmark',
                delay: 3500,
                close: false,
            })
        </script>
    @endif
@endsection

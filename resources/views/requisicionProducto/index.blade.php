@extends('admin.layouts.index')
@section('title', 'Requisición producto')
@section('header')
    <div class="col-12">
        <h2>Requisiciones de productos</h2>
    </div>
    <div class="col-12">
        <form action="{{ route('requisicionProducto.store') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success text-left" role="button" aria-pressed="true">
                <i class="fa fa-plus"></i> Crear una requisición</button>
        </form>
    </div>
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card-body">
                <h4>Solicitudes enviadas</h4>
                <div class="table-responsive">
                    <table class="table table-sm text-center table-striped table-bordered" id="dataTable11" width="100%"
                        cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Fecha de realización</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requisiciones as $item)
                                <tr>
                                    <td scope="row">{{ $item->fechaRequisicion }}</td>
                                    <td>{{ $item->descripcion }}</td>
                                    <td><span class="badge badge-primary">{{ $item->estado->nombreEstado }}</span></td>
                                    <td>
                                        <a href="{{ route('requisicionProducto.detalle', $item->id) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i> Editar Detalles
                                        </a>
                                        <a href="{{ route('requisicionProducto.edit', $item->id) }}"
                                            class="btn btn-success btn-sm">
                                            <i class="fas fa-edit"></i> Editar Requisición
                                        </a>
                                        <a href="{{ route('requisicionProducto.destroy', $item) }}" data-toggle="modal"
                                            data-target="#deleteModal" data-delete="{{ $item->id }}"
                                            class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Eliminar
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
    <!-- delete Modal-->
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
                <div class="modal-body">Seleccione "eliminar" Si realmente desea eliminar el registro
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <form method="POST" action="">
                        @method('GET')
                        @csrf
                        <a class="btn btn-danger" onclick="$(this).closest('form').submit();">Borrar</a>
                    </form>
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
            modal.find('form').attr('action', '{{ asset('/requisicionProducto/destroy/') }}' + '/' +
                delete_id);
        })
    </script>
    <script>
        $(document).ready(function() {
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
        });
    </script>
@endsection
@section('js')
    @if (session('status'))
        <script>
            $(document).Toasts('create', {
                title: 'Solicitud enviada',
                position: 'topRight',
                body: '{{ session('status') }} se ha enviado la solicitud para su revisión',
                class: 'bg-info',
                autohide: true,
                icon: 'fas fa-solid fa-check',
                delay: 3500,
                close: false,
            })
        </script>
    @endif
    @if (session('actualizado'))
        <script>
            $(document).Toasts('create', {
                title: 'Registro actualizado',
                position: 'topRight',
                body: '{{ session('actualizado') }} se ha actualizado el registro',
                class: 'bg-success',
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
                title: 'Solicitud eliminada',
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

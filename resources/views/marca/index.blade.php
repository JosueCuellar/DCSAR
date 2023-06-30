@extends('admin.layouts.index')
@section('title', 'Marca')
@section('header')
    <div class="col-md-12">
        <h2>Lista de marcas</h2>
    </div>
    <div class="col-md-12 d-grid gap-2 d-md-flex">
        <form action="{{ route('marca.create') }}" method="GET">
            @csrf
            <button type="submit" class="btn btn-success text-left" role="button" aria-pressed="true"><i
                    class="fa fa-plus"></i> Nueva marca</button>
        </form>
    </div>
@endsection
@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-striped text-center" id="dataTable6" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($marcas as $item)
                            <tr>
                                <th scope="row">{{ $item->id }}</th>
                                <td>{{ $item->nombre }}</td>
                                <td>
                                    <a href="{{ route('marca.edit', $item->id) }}">
                                        <ion-icon name="create-outline" class="fa-lg text-primary"></ion-icon>
                                    </a>
                                    <a href="{{ route('marca.destroy', $item) }}" data-toggle="modal"
                                        data-target="#deleteModal" data-delete="{{ $item->id }}">
                                        <ion-icon name="trash-outline" class="fa-lg text-danger"></ion-icon>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- delete Modal-->
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">¿Estás seguro de que quieres eliminar esto?</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">Seleccione "eliminar" Si realmente desea eliminar a este registro</div>
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
        </div>
        <div class="card-footer small text-muted"></div>
    </div>
@endsection
@section('js_datatable')
    <script>
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var delete_id = button.data('delete')
            var modal = $(this)
            // modal.find('.modal-footer #user_id').val(user_id)
            modal.find('form').attr('action', 'marca/destroy/' + delete_id);
        })
    </script>
    <script>
        $(document).ready(function() {
            $('#dataTable6').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                "autoWidth": false,
                "responsive": true,
                "columnDefs": [{
                    "responsivePriority": 10001,
                    "targets": 1
                }]
            });
        });
    </script>
@endsection
@section('js')
    @if (session('msg'))
        <script>
            $(document).Toasts('create', {
                title: 'Error',
                position: 'topRight',
                body: '{{ session('msg') }}',
                class: 'bg-danger',
                autohide: true,
                icon: 'fas fa-exclamation-triangle ',
                delay: 3500,
                close: false,
            })
        </script>
    @endif
    @if (session('status'))
        <script>
            $(document).Toasts('create', {
                title: 'Marca agregado',
                position: 'topRight',
                body: '{{ session('status') }} se ha actualizado la tabla',
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
                title: 'Marca eliminado',
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
                icon: 'fas fa-exclamation-triangle',
                delay: 3500,
                close: false,
            })
        </script>
    @endif
@endsection

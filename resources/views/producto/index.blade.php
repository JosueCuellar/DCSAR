@extends('admin.layouts.index')
@section('title', 'Producto')
@section('header')
    <div class="col-md-12">
        <h2>Lista de productos</h2>
    </div>

    @if (\Session::has('msg'))
        <div class="alert alert-danger" role="alert">
            <ul>
                <li>{!! \Session::get('msg') !!}</li>
            </ul>
        </div>
    @endif
    <div class="row p-3">
        <div class="col-md-12 d-grid gap-2 d-md-flex">
            <form action="{{ route('producto.create') }}" method="GET">
                @csrf
                <button type="submit" class="btn btn-success text-left" role="button" aria-pressed="true"><i
                        class="fa fa-plus"></i> Nuevo producto</button>
            </form>
        </div>
    </div>
@endsection
@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped text-center" id="dataTable6" width="100%"
                    cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Rubro</th>
                            <th scope="col">Codigo producto</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Perecedero</th>
                            <th scope="col">Imagen</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Medida</th>
                            <th scope="col">Observacion</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $item)
                            <tr>
                                <td>{{ $item->rubro->descripcionRubro }}</td>
                                <td>{{ $item->cod_producto }}</td>
                                <td>{{ $item->descripcion }}</td>
                                @if ($item->perecedero == 1)
                                    <td><span class="badge bg-success">Perecedero</span> </td>
                                @else
                                <td><span class="badge bg-danger">No Perecedero</span> </td>

                                @endif
                                <td>
                                    <div class="filter-container row">
                                        <div class="filtr-item col-sm-2">
                                            <a href="/imagen/{{ $item->imagen }}" data-toggle="lightbox">
                                                <img src="/imagen/{{ $item->imagen }}" class="img-fluid"
                                                    style="width:40px;max-width:100px">
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $item->marca->nombre }}</td>
                                <td>{{ $item->medida->nombreMedida }}</td>
                                <td>{{ $item->observacion }}</td>
                                <td>
                                    <a href="{{ route('producto.edit', $item->id) }}">
                                        <ion-icon name="create-outline" class="fa-lg text-primary"></ion-icon>
                                    </a>
                                    <a href="{{ route('producto.destroy', $item) }}" data-toggle="modal"
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
        <div class="card-footer small text-muted"></div>
    </div>

@section('js_datatable')

    <script>
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var delete_id = button.data('delete')

            var modal = $(this)
            // modal.find('.modal-footer #user_id').val(user_id)
            modal.find('form').attr('action', 'producto/destroy/' + delete_id);

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

    <script>
        $(function() {
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });
        })
    </script>

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
                title: 'Producto agregado',
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
                title: 'Producto eliminado',
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

@endsection

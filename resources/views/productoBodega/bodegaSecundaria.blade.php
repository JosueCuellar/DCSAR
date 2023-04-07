@extends('admin.layouts.index')
@section('title', 'Bodega secundaria')
@section('header')
    <div class="row">
        <div class="col-12">
            <h2 class="text-center">Bodega secundaria</h2>
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
                            <table class="table table-sm table-striped text-center" id="dataTable25" width="100%"
                                cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Codigo producto</th>
                                        <th scope="col">Descripción producto</th>
                                        <th scope="col">Nombre bodega</th>
                                        <th scope="col">Cantidad disponible</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productos_bodegas as $item)
                                        <tr>
                                            <th scope="row">{{ $item->producto->cod_producto }}</th>
                                            <th scope="row">{{ $item->producto->descripcion }}</th>
                                            <td>{{ $item->bodega->nombre_bodega }}</td>
                                            <td>{{ $item->cantidad_disponible }}</td>
                                            <td>
                                                @if ($item->cantidad_disponible > 0)
                                                    <button type="submit" data-toggle="modal"
                                                        data-target="#exampleModalCenter" data-bodega="{{ $item->id }}"
                                                        class="btn btn-sm btn-primary">Mover productos</button>
                                                @else
                                                    <button type="submit" data-toggle="modal"
                                                        data-target="#exampleModalCenter" data-id="{{ $item->id }}"
                                                        data-bodega="{{ $item->id }}" class="btn btn-sm btn-primary"
                                                        disabled>Mover productos</button>
                                                @endif
                                            </td>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form method="POST" class="form-horizontal" action="">
                    @csrf
                    @method('POST')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Ingrese la cantidad de productos</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group has-feedback row">
                                            <label for="cantidad" class="col-12 control-label">Cantidad de
                                                productos:</label>
                                            <div class="col-12">
                                                <input id="cantidadProducto" type="number" min="1" class="form-control"
                                                    name="cantidadProducto" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <a class="btn btn-success" onclick="$(this).closest('form').submit();">Guardar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


@section('js')

    @if (session('msg'))
        <script>
            $(document).Toasts('create', {
                title: 'Error',
                position: 'topRight',
                body: '{{ session('msg') }}',
                class: 'bg-warning',
                autohide: true,
                icon: 'fas fa-exclamation-triangle',
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

@endsection

@section('js_datatable')

    <script>
        $('#exampleModalCenter').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var bodega = button.data('bodega')
            var modal = $(this)
            modal.find('form').attr('action', '{{ asset('productoBodega/') }}' + '/' +
                bodega);
        })
    </script>

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

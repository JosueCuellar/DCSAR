@extends('layoutsGeneral.admin.layouts.index')
@section('title', 'Bodega principal')
@section('header')
    <div class="col-12">
        <h2 class="text-center">Bodega productos</h2>
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
                                        <th scope="col">Ubicacion bodega</th>
                                        <th scope="col">Cantidad disponible</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productos_bodegas as $item)
                                        <tr>
                                            <th scope="row">{{ $item->producto->codProducto }}</th>
                                            <th scope="row">{{ $item->producto->descripcion }}</th>
                                            <td>{{ $item->bodega->nombreBodega }}</td>
                                            <td>{{ $item->cantidadDisponible }}</td>
                                            <td>
                                                @if ($item->cantidadDisponible > 0)
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
                                        </tr>
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
                                                <input id="cantidadProducto" type="number" min="1"
                                                    class="form-control" name="cantidadProducto" value="">
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
@endsection
@section('js_datatable')
    <script>
        document.getElementById('cantidadProducto').addEventListener('input', function(e) {
            if (e.target.value.includes('.')) {
                e.target.value = e.target.value.replace('.', '');
            }
            e.target.value = e.target.value.replace(/\./g, '');
        });
    </script>
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

        // Save the search value in localStorage
        $('#dataTable25').on('search.dt', function() {
            localStorage.setItem('searchBodega', $('.dataTables_filter input').val());
        });

        // Get the search value from localStorage and set it as the search value
        $(document).ready(function() {
            var search = localStorage.getItem('searchBodega');
            if (search) {
                $('.dataTables_filter input').val(search);
                $('#dataTable25').DataTable().search(search).draw();
            }
        });
    </script>
@endsection

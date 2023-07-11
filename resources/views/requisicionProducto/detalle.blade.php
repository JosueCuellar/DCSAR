@extends('admin.layouts.index')
@section('title', 'Requisición producto')
@section('header')
    <div class="col-12">
        <h2 class="text-center">REQUISICIÓN DE MATERIALES Y SUMINISTROS DE OFICINA</h2>
        <x-errores class="mb-4" />
    </div>
    <div class="m-1">

        @if ($requisicionProducto->estado_id == 3)
            <button type="submit" data-toggle="modal" data-target="#modalDescripcion"
                data-categoriaid="{{ $requisicionProducto->id }}" class="btn btn-success  text-left"><i
                    class="fa fa-check"></i>
                Reenviar Requisición</button>
        @else
            @if ($requisicionProducto->estado_id == 1)
                <a href="{{ route('requisicionProducto.index') }}" class="btn btn-secondary float-right"
                    data-toggle="tooltip" data-placement="left" title
                    data-original-title="Regresar a lista de usuarios">Regresar</a>
            @else
                <button type="submit" data-toggle="modal" data-target="#modalDescripcion"
                    data-categoriaid="{{ $requisicionProducto->id }}" class="btn btn-warning  text-left"><i
                        class="fa fa-check"></i>
                    Finalizar
                    Requisición</button>
            @endif
        @endif



        <button type="submit" data-toggle="modal" data-target="#modalDetalle"
            data-categoriaid="{{ $requisicionProducto->id }}" class="btn btn-info  text-left"><i class="fa fa-eye"></i>
            Detalles Requisición</button>
    </div>
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="text-center">Ingresa los productos a pedir</h4>
                    <div class="table-responsive">
                        <table class="table table-sm text-center table-striped" id="dataTable13" width="100%"
                            cellspacing="0">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Rubro</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Imagen</th>
                                    <th scope="col">Medida</th>
                                    <th scope="col">Disponible</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-6">
                    <h4 class="text-center">Productos solicitados</h4>
                    <div class="table-responsive">
                        <table class="table table-sm text-center table-striped" id="dataTable14" width="100%"
                            cellspacing="0">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Eliminar</th>
                                    <th scope="col">Producto</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Medida</th>
                                    <th scope="col">P. Prom</th>
                                    <th scope="col">Sub-total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detalle_requisicion as $item)
                                    <tr>
                                        <th scope="row">
                                            <a href="{{ route('detalleRequisicion.destroy', ['requisicionProducto' => $requisicionProducto, 'detalleRequisicion' => $item]) }}"
                                                data-toggle="modal" data-target="#deleteModal"
                                                data-ventaid="{{ $requisicionProducto->id }}"
                                                data-detalleid="{{ $item->id }}">
                                                <ion-icon name="trash-outline" class="fa-lg text-danger"></ion-icon>
                                            </a>
                                        </th>
                                        <td>{{ $item->producto->descripcion }}</td>
                                        <td>
                                            <form
                                                action="{{ route('detalleRequisicion.update', ['requisicionProducto' => $requisicionProducto->id, 'detalleRequisicion' => $item->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('put')
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <button class="btn btn-success" type="submit" id="button-addon2">
                                                            <ion-icon name="save-outline"></ion-icon>
                                                        </button>
                                                    </div>
                                                    <input type="number" id="cantidad"
                                                        value="{{ old('cantidad', $item->cantidad) }}" name="cantidad"
                                                        class="form-control" placeholder="Cantidad" aria-label="Cantidad"
                                                        aria-describedby="button-addon2">
                                                </div>
                                                @error('cantidad')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </form>
                                        </td>
                                        <td>{{ $item->producto->medida->nombreMedida }}</td>
                                        <td>${{ $item->precioPromedio }}</td>
                                        <td>${{ $item->total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="thead-ligth">
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col">Total</th>
                                    <th scope="col">${{ $totalFinal }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalDescripcion" style="display: none;" aria-hidden="true">
            <form method="POST" class="form-horizontal" action="" id="descripcionModal">
                @csrf
                @method('put')
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ingresa una descripcion de la requisición</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="descripcion" class="col-sm-2 col-form-label">Descripción</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"
                                        placeholder="Ingresa una descripcion" required>{{ old('descripcion', $requisicionProducto->descripcion) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <a id="guardar" class="btn btn-warning"
                                onclick="$(this).closest('form').submit();">Guardar</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal fade" id="modalDetalle" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><b>Detalles de la Requisición de Productos</b></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">Fecha de solicitud:
                                <label>{{ $requisicionProducto->fechaRequisicion }}</label>
                            </div>
                            <br>
                            <div class="col-6">Unidad Organizativa: <label>Unidad de Logistica</label>
                            </div>
                            <br>
                        </div>
                        <div class="row">
                            <div class="col-6">Descripción:
                                <label>{{ $requisicionProducto->descripcion }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
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
                    <div class="modal-body">Seleccione "eliminar" Si realmente desea eliminar a este producto de la
                        requisición
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                        <form method="POST" action="">
                            @method('GET')
                            @csrf
                            <!--{{-- <input type="hidden" id="user_id" name="user_id" value=""> --}}-->
                            <a class="btn btn-primary" onclick="$(this).closest('form').submit();">Borrar</a>
                        </form>
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
                                                <input id="cantidadAdd" type="number" class="form-control"
                                                    name="cantidadAdd" value="">
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
        document.getElementById('cantidadAdd').addEventListener('input', function(e) {
            if (e.target.value.includes('.')) {
                e.target.value = e.target.value.replace('.', '');
            }
            e.target.value = e.target.value.replace(/\./g, '');
        });
    </script>

    <script>
        let initialValue = document.getElementById('cantidad').value;
        console.log(initialValue)
        document.getElementById('cantidad').addEventListener('input', function(e) {
            if (e.target.value.includes('.')) {
                e.target.value = e.target.value.replace('.', initialValue);
            }
            e.target.value = e.target.value.replace(/\./g, initialValue);
        });
    </script>

    <script>
        $('#exampleModalCenter').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var requi = button.data('requi')
            var producto = button.data('producto')
            var modal = $(this)
            console.log(producto);
            modal.find('form').attr('action', '{{ asset('/requisicionProducto/detalle/') }}' + '/' +
                requi + '/' + producto);
        })
    </script>
    <script>
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var venta_id = button.data('ventaid')
            var detalle_id = button.data('detalleid')
            var modal = $(this)
            modal.find('form').attr('action', '' + venta_id + '/eliminar/' + detalle_id);
        })
    </script>
    <script>
        $('#modalDescripcion').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var categoria_id = button.data('categoriaid')
            var modal = $(this)
            // modal.find('.modal-footer #user_id').val(user_id)
            modal.find('form').attr('action', '{{ asset('/requisicionProducto/completar/') }}' + '/' +
                categoria_id);
        })
    </script>
    <script>
        $(document).ready(function() {
            $('#dataTable14').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                "autoWidth": false,
                "responsive": true,
                "columnDefs": [{
                        "responsivePriority": 1,
                        "targets": 0
                    },
                    {
                        "responsivePriority": 10001,
                        'targets': 3
                    }
                ]
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var requisicionProductoId = "{{ $requisicionProducto->id }}";
            $('#dataTable13').DataTable({
                // processing: true, 
                serverSide: true,
                ajax: '{{ route('requisicionProducto.datos') }}',
                columns: [{
                        data: 'rubro',
                        name: 'rubro'
                    },
                    {
                        data: 'descripcion',
                        name: 'descripcion'
                    },
                    {
                        data: 'imagen',
                        name: 'imagen',
                        render: function(data, type, row) {
                            return '<div class="filter-container row">' +
                                '<div class="filtr-item col-sm-2">' +
                                '<a href="/imagen/' + data + '" data-toggle="lightbox">' +
                                '<img src="/imagen/' + data +
                                '" class="img-fluid" style="width:40px;max-width:100px">' +
                                '</a>' +
                                '</div>' +
                                '</div>';
                        }
                    },
                    {
                        data: 'nombreMedida',
                        name: 'nombreMedida'
                    },
                    {
                        data: null,
                        name: 'total',
                        render: function(data, type, row) {
                            return Number(row.stockReal) - Number(row.stockReservado);
                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            if (row.stockReal - row.stockReservado > 0) {
                                return '<button type="submit" data-toggle="modal" data-target="#exampleModalCenter" data-requi="' +
                                    requisicionProductoId + '" data-producto="' + row.id +
                                    '" class="btn btn-sm btn-success">Agregar</button>';
                            } else {
                                return '<button type="submit" data-toggle="modal" data-target="#exampleModalCenter" data-requi="' +
                                    requisicionProductoId + '" data-producto="' + row.id +
                                    '" class="btn btn-sm btn-success" disabled>Agregar</button>';
                            }
                        }
                    }
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                autoWidth: false,
                responsive: true,
                columnDefs: [{
                        "responsivePriority": 10003,
                        "targets": 2
                    },
                    {
                        "responsivePriority": 10002,
                        'targets': 3
                    }
                ]
            });
        });
    </script>
    <script>
        // Save the search value in localStorage
        $('#dataTable13').on('search.dt', function() {
            localStorage.setItem('searchRequi', $('.dataTables_filter input').val());
        });

        // Get the search value from localStorage and set it as the search value
        $(document).ready(function() {
            var search = localStorage.getItem('searchRequi');
            if (search) {
                $('.dataTables_filter input').val(search);
                $('#dataTable13').DataTable().search(search).draw();
            }
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

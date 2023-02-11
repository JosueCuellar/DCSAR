@extends('admin.layouts.index')
@section('title', 'Requisición producto')
@section('header')
    <div class="col-md-12">
        <h2>REQUISICIÓN DE MATERIALES Y SUMINISTROS DE OFICINA</h2>
    </div>
    <div class="row">
        <div class="col-md-12 d-grid gap-2 d-md-flex">
            <div class="m-1">
                <button type="submit" data-toggle="modal" data-target="#modalDescripcion"
                    data-categoriaid="{{ $requisicionProducto->id }}" class="btn btn-warning  text-left"><i
                        class="fa fa-check"></i> Finalizar
                    Requisición</button>
            </div>
            <div class="m-1">
                <button type="submit" data-toggle="modal" data-target="#modalDetalle"
                    data-categoriaid="{{ $requisicionProducto->id }}" class="btn btn-info  text-left"><i
                        class="fa fa-eye"></i> Detalles Requisición</button>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="text-center">Ingresa los productos a pedir</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center table-striped" id="dataTable13"
                            width="100%" cellspacing="0">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Producto</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Imagen</th>
                                    <th scope="col">Medida</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($productos as $item)
                                    <tr>
                                        <td scope="row">{{ $item->id }}</td>
                                        <td>{{ $item->cod_producto }}</td>
                                        <td>{{ $item->descripcion }}</td>
                                        <td>
                                            {{-- <img src="/imagen/{{ $item->imagen }}" class="img-fluid mb-2"
                                            style="width:100%;max-width:300px"> --}}
                                            <div class="filter-container row">
                                                <div class="filtr-item col-sm-2">
                                                    <a href="/imagen/{{ $item->imagen }}" data-toggle="lightbox">
                                                        <img src="/imagen/{{ $item->imagen }}" class="img-fluid"
                                                            style="width:40px;max-width:100px">
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $item->medida->nombreMedida }}</td>

                                        <td>
                                            <form
                                                action="{{ route('detalleRequisicion.store', ['requisicionProducto' => $requisicionProducto->id, 'producto' => $item->id]) }}"
                                                method="POST">
                                                @csrf
                                                    <button type="submit" class="btn btn-success">Agregar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-6">
                    <h4 class="text-center">Productos ingresados</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center table-striped" id="dataTable14" width="100%"
                            cellspacing="0">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Eliminar</th>
                                    <th scope="col">Producto</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Medida</th>
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
                                        <td>{{ $item->producto->cod_producto }}</td>
                                        <td>
                                            <form
                                                action="{{ route('detalleRequisicion.update', ['requisicionProducto' => $requisicionProducto->id, 'detalleRequisicion' => $item->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('put')
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <button class="btn btn-success" type="submit"
                                                            id="button-addon2"><ion-icon name="refresh-outline"></ion-icon></ion-icon></button>
                                                    </div>
                                                    <input type="number" value="{{ old('cantidad', $item->cantidad) }}"
                                                        name="cantidad" class="form-control" placeholder="Cantidad"
                                                        aria-label="Cantidad" aria-describedby="button-addon2">
                                                </div>
                                                @error('cantidad')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </form>

                                        </td>
                                        <td>{{ $item->producto->medida->nombreMedida }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalDescripcion" style="display: none;" aria-hidden="true">
            <form method="POST" class="form-horizontal" action="">
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
                                        placeholder="Ingresa una descripcion">{{ old('descripcion', $requisicionProducto->descripcion) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <a class="btn btn-warning" onclick="$(this).closest('form').submit();">Guardar</a>
                        </div>
                    </div>

                </div>
            </form>
        </div>

        <div class="modal fade" id="modalDetalle" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg">
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
                                <label>{{ $requisicionProducto->fecha_requisicion }}</label>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12">Unidad Organizativa: <label>--------------------------</label>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12">Descripción: <label>{{ $requisicionProducto->descripcion }}</label>
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
    </div>
@section('js_datatable')

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
            $('#dataTable13').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },

                "autoWidth": false,
                "responsive": true,
                "columnDefs": [{
                        "responsivePriority": 10001,
                        "targets": 2
                    },
                    {
                        "responsivePriority": 10002,
                        'targets': 3
                    }
                ]

            });

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
        $(function() {
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });

            $('.filter-container').filterizr({
                gutterPixels: 3
            });
            $('.btn[data-filter]').on('click', function() {
                $('.btn[data-filter]').removeClass('active');
                $(this).addClass('active');
            });
        })
    </script>


@endsection
@endsection

@extends('admin.layouts.index')
@section('title', 'Detalle requisicion')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-1"></div>
                <div class="col-10">
                    @if (!($requisicionProducto->estado_id == 3))
                        <div class="row">
                            <div class="col-6">
                                <form action="{{ route('requisicionProducto.aceptarRequi', $requisicionProducto->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('put')
                                    <button type="submit" class="btn btn-block bg-gradient-success btn-lg"
                                        style="margin-bottom:1em">Aceptar</button>
                                </form>
                            </div>

                            <div class="col-6">
                                    <button type="submit" data-toggle="modal" data-target="#modalObservacion"
                                    data-categoriaid="{{ $requisicionProducto->id }}" class="btn btn-block bg-gradient-danger btn-lg"
                                        style="margin-bottom:1em">Rechazar</button>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header">
                                <b>Detalles de la Requisicion de Productos</b>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">Numero Requisicion:
                                        <label>{{ $requisicionProducto->nCorrelativo }}</label>
                                    </div>
                                    <div class="col-6">Fecha de solicitud:
                                        <label>{{ $requisicionProducto->fecha_requisicion }}</label>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12">Unidad Organizativa:
                                        <label>------------------------------------</label>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12">Descripción: <label>{{ $requisicionProducto->descripcion }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header">
                                <b>Detalle de Solicitud</b>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable12" width="100%" cellspacing="0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Id</th>
                                                <th scope="col">Codigo de Producto</th>
                                                <th scope="col">Unidad de Medida</th>
                                                <th scope="col">Cantidad</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($detalle_requisicion as $item)
                                                <tr>
                                                    <th scope="row">{{ $item->id }}</th>
                                                    <td>{{ $item->producto->cod_producto }}</td>
                                                    <td>{{ $item->producto->medida->nombreMedida }}</td>
                                                    <td>{{ $item->cantidad }}</td>
                                                </tr>
                                            @endforeach
                                        <tfoot class="thead-light">
                                            <tr>
                                                <th scope="col">Id</th>
                                                <th scope="col">Codigo de Producto</th>
                                                <th scope="col">Unidad de Medida</th>
                                                <th scope="col">Cantidad</th>
                                            </tr>
                                        </tfoot>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col-1"></div>
            @else
                <div class="card mb-3">
                    <div class="card-header">
                        <b>Detalles de la Requisicion de Productos</b>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">Numero Requisicion:
                                <label>{{ $requisicionProducto->nCorrelativo }}</label>
                            </div>
                            <div class="col-6">Fecha de solicitud:
                                <label>{{ $requisicionProducto->fecha_requisicion }}</label>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12">Unidad Organizativa: <label>------------------------------------</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header">
                        <b>Detalle de Solicitud</b>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable12" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Codigo de Producto</th>
                                        <th scope="col">Unidad de Medida</th>
                                        <th scope="col">Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detalle_requisicion as $item)
                                        <tr>
                                            <th scope="row">{{ $item->id }}</th>
                                            <td>{{ $item->producto->cod_producto }}</td>
                                            <td>{{ $item->producto->medida->nombreMedida }}</td>
                                            <td>{{ $item->cantidad }}</td>
                                        </tr>
                                    @endforeach
                                <tfoot class="thead-light">
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Codigo de Producto</th>
                                        <th scope="col">Unidad de Medida</th>
                                        <th scope="col">Cantidad</th>
                                    </tr>
                                </tfoot>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-1"></div>

            @endif
        </div>

        <div class="modal fade" id="modalObservacion" style="display: none;" aria-hidden="true">
            <form method="POST" class="form-horizontal" action="">
                @csrf
                @method('put')
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ingresa una observacion de la requisicion rechazada</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="observacion" class="col-sm-2 col-form-label">Observacion</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="observacion" name="observacion" rows="3"
                                        placeholder="Ingresa una observacion">{{ old('observacion', $requisicionProducto->observacion) }}</textarea>
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
                        requisicion
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
        $('#modalObservacion').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var categoria_id = button.data('categoriaid')

            var modal = $(this)
            // modal.find('.modal-footer #user_id').val(user_id)
            modal.find('form').attr('action', '{{ asset('/requisicionProducto/denegar/') }}' + '/' +
                categoria_id);
        })
    </script>

    <script>
        $(document).ready(function() {
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
            $('#dataTable14').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
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

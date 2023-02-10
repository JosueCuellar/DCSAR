@extends('admin.layouts.index')
@section('title', 'Revisicion de requisición')
@section('header')
    <div class="col-md-12">
        <h2>Revisión de solicitudes</h2>
    </div>
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="card card-secondary card-outline" style="width: 100%">
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-striped text-center" id="dataTable11" width="100%"
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
                                            <tr>
                                                <td scope="row">{{ $item->fecha_requisicion }}</td>
                                                <td>{{ $item->descripcion }}</td>
                                                <td><span class="badge badge-info">{{ $item->estado->nombreEstado }}</span>
                                                </td>
                                                <td>
                                                    <div class="margin">
                                                        <div class="btn-group">
                                                            <button
                                                                onclick="location.href = '{{ asset('/requisicionProducto/detalleRevision/') }}/{{ $item->id }}';"
                                                                type="button" id="myButton"
                                                                class="btn btn-info">Ver</button>
                                                        </div>

                                                        <div class="btn-group">
                                                            <button type="submit" data-toggle="modal"
                                                                data-target="#modalObservacionAceptar"
                                                                data-aceptar="{{ $item->id }}"
                                                                class="btn bg-gradient-success">Aceptar</button>
                                                        </div>

                                                        <div class="btn-group">
                                                            <button type="submit" data-toggle="modal"
                                                                data-target="#modalObservacionDenegar"
                                                                data-categoriaid="{{ $item->id }}"
                                                                class="btn bg-gradient-danger">Rechazar</button>
                                                        </div>

                                                    </div>
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

    <div class="modal fade" id="modalObservacionAceptar" style="display: none;" aria-hidden="true">
        <form method="POST" class="form-horizontal" action="">
            @csrf
            @method('put')
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ingresa una observacion de la requisición por aceptar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="observacion" class="col-sm-2 col-form-label">Observacion</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="observacion" name="observacion" rows="3" placeholder="Ingresa una observacion"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <a class="btn btn-success" onclick="$(this).closest('form').submit();">Guardar</a>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <div class="modal fade" id="modalObservacionDenegar" style="display: none;" aria-hidden="true">
        <form method="POST" class="form-horizontal" action="">
            @csrf
            @method('put')
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ingresa una observacion de la requisición por rechazar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="observacion" class="col-sm-2 col-form-label">Observacion</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="observacion" name="observacion" rows="3" placeholder="Ingresa una observacion"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <a class="btn btn-danger" onclick="$(this).closest('form').submit();">Guardar</a>
                    </div>
                </div>

            </div>
        </form>
    </div>
@section('js_datatable')

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

    <script>
        $('#modalObservacionAceptar').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var aceptar_id = button.data('aceptar')

            var modal = $(this)
            // modal.find('.modal-footer #user_id').val(user_id)
            modal.find('form').attr('action', '{{ asset('/requisicionProducto/aceptar/') }}' + '/' +
                aceptar_id);
        })
    </script>

    <script>
        $('#modalObservacionDenegar').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var categoria_id = button.data('categoriaid')

            var modal = $(this)
            // modal.find('.modal-footer #user_id').val(user_id)
            modal.find('form').attr('action', '{{ asset('/requisicionProducto/denegar/') }}' + '/' +
                categoria_id);
        })
    </script>


@endsection

@endsection

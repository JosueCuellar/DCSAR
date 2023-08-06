@extends('layoutsGeneral.admin.layouts.index')
@section('title', 'Requisiciones recibidas')
@section('header')
    <div class="col-md-12">
        <h2>Requisiciones a entregar</h2>
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
                                <table class="table tbale-sm table-striped  text-center" id="dataTable11" width="100%"
                                    cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Numero correlativo</th>
                                            <th scope="col">Estado</th>
                                            <th scope="col">Unidad Organizativa</th>
                                            <th scope="col">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($requisicionesAprobadas as $item)
                                            <tr>
                                                <td scope="row"> <?php
                                                $date = new DateTime($item->fechaRequisicion);
                                                echo $date->format('Y-m-d');
                                                ?></td>
                                                <td scope="row">{{ $item->nCorrelativo }}</td>
                                                <td><span
                                                        class="badge badge-success">{{ $item->estado->nombreEstado }}</span>
                                                </td>
                                                <td scope="row">
                                                    {{ $item->user->unidadOrganizativa->nombreUnidadOrganizativa ?? '' }}
                                                </td>
                                                <td>
                                                    <div>
                                                        <button
                                                            onclick="location.href = '{{ asset('/requisicionProducto/detalleRevision/') }}/{{ $item->id }}';"
                                                            type="button" class="btn btn-primary"><i class="fa fa-eye"></i>
                                                            Detalles</button>
                                                        {{-- <button
                                                            onclick="location.href = '{{ asset('/requisicionProducto/pdf/aprobar/') }}/{{ $item->id }}';"
                                                            type="button" class="btn btn-success"><i
                                                                class="fa fa-download"></i> Autorizacion</button> --}}
                                                        <button
                                                            onclick="location.href = '{{ asset('/requisicionProducto/pdf/comprobante/') }}/{{ $item->id }}';"
                                                            type="button" class="btn btn-secondary"><i
                                                                class="fa fa-download"></i> Comprobante</button>
                                                        <button type="submit" data-toggle="modal"
                                                            data-target="#modalConfirmar" data-aceptar="{{ $item->id }}"
                                                            class="btn btn-dark"><i class="fa fa-check"></i> Confirmar
                                                            entrega</button>
                                                        <button type="submit" data-toggle="modal"
                                                            data-target="#modalObservacionDenegar"
                                                            data-categoriaid="{{ $item->id }}"
                                                            class="btn bg-danger">Rechazar</button>
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
    <div class="modal fade" id="modalConfirmar" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" class="form-horizontal" action="">
                    @csrf
                    @method('put')
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">¿Estás seguro confirmar la entrega?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Asegurate de haber entregado los productos de la requisicion antes de confirmar la entrega
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <a class="btn btn-dark" onclick="$(this).closest('form').submit();">Confirmar</a>
                    </div>
                </form>
            </div>
        </div>
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
@endsection
@section('js')

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
    @if (session('status'))
        <script>
            $(document).Toasts('create', {
                title: 'Solicitud confirmada',
                position: 'topRight',
                body: '{{ session('status') }} la solicitud se entrego correctamente',
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
                icon: 'fas fa-exclamation-triangle',
                delay: 3500,
                close: false,
            })
        </script>
    @endif
@endsection
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
        $('#modalConfirmar').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var aceptar_id = button.data('aceptar')
            var modal = $(this)
            // modal.find('.modal-footer #user_id').val(user_id)
            modal.find('form').attr('action', '{{ asset('/requisicionProducto/entregada/') }}' + '/' +
                aceptar_id);
        })
    </script>
@endsection

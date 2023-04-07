@extends('admin.layouts.index')
@section('title', 'Estados requisiciones')
@section('header')
    <div class="col-md-12">
        <h2>Requisiciones Realizadas</h2>
    </div>
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-secondary card-outline card-outline-tabs">
                        <div class="card-header p-0 pt-1">
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">

                                {{-- Enviadas --}}
                                <div class="tab-pane fade active show" id="enviadas" role="tabpanel"
                                    aria-labelledby="enviadas-tab">
                                    <table class="table table-sm table-striped text-center" id="dataTable11" width="100%"
                                        cellspacing="0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Fecha</th>
                                                <th scope="col">Numero correlativo</th>
                                                <th scope="col">Estado</th>
                                                <th scope="col">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($requisicionRecibidas as $item)
                                                    <td scope="row">{{ $item->fecha_requisicion }}</td>
                                                    <td scope="row">{{ $item->nCorrelativo }}</td>
                                                    <td><span
                                                            class="badge text-white" style="background-color: orange">{{ $item->estado->nombre_estado }}</span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('requisicionProducto.detalleRevision', $item->id) }}">
                                                            <ion-icon name="eye-outline" class="fa-lg text-success">
                                                            </ion-icon>
                                                        </a>

                                                        {{-- <a href="{{ route('requisicionProducto.destroy', $item) }}"
                                                            data-toggle="modal" data-target="#deleteModal"
                                                            data-categoriaid="{{ $item->id }}">
                                                            <ion-icon name="trash-outline" class="fa-lg text-danger">
                                                            </ion-icon>
                                                        </a> --}}
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
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">¿Estás seguro de que quieres eliminar esto?
                        </h6>
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

@section('js_datatable')

    <script>
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var categoria_id = button.data('categoriaid')

            var modal = $(this)
            // modal.find('.modal-footer #user_id').val(user_id)
            modal.find('form').attr('action', '{{ asset('/requisicionProducto/destroy/') }}' + '/' +
                categoria_id);
        })
    </script>

    <script>
        $(document).ready(function() {
            $('a[data-toggle="pill"]').on('shown.bs.tab', function(e) {
                $.fn.dataTable.tables({
                    visible: true,
                    api: true
                }).columns.adjust();
            });
            
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
@endsection

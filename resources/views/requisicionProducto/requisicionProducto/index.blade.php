@extends('layoutsGeneral.admin.layouts.index')
@section('title', 'Requisición producto')
@section('header')
    <div class="col-12">
        <h2>Requisiciones de productos</h2>
    </div>
    <div class="col-12">
        <form action="{{ route('requisicionProducto.store') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success text-left" role="button" aria-pressed="true">
                <i class="fa fa-plus"></i> Crear una requisición</button>
        </form>
    </div>
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card-body">
                <h4>Solicitudes enviadas</h4>
                <div class="table-responsive">
                    <table class="table table-sm table-striped text-center" id="dataTable11" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Fecha de realización</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Realizada por</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requisiciones as $item)
                                <tr>
                                    <td scope="row"> <?php
                                    $date = new DateTime($item->fechaRequisicion);
                                    echo $date->format('Y-m-d');
                                    ?></td>
                                    <td>{{ $item->descripcion }}</td>
                                    <td><span class="badge badge-primary">{{ $item->estado->nombreEstado }}</span></td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>
                                        <button
                                            onclick="location.href = '{{ asset('/requisicionProducto/detalleRevision/') }}/{{ $item->id }}';"
                                            type="button" id="myButton" class="btn btn-sm btn-dark">
                                            <i class="fas fa-eye"></i> Ver detalles
                                        </button>
                                        @if (
                                            $item->user_id == Auth::id() ||
                                                auth()->user()->hasRole('Super Administrador'))
                                            <a href="{{ route('requisicionProducto.detalle', $item->id) }}"
                                                class="btn btn-sm btn-primary ">
                                                <i class="fas fa-edit"></i> Editar Detalles
                                            </a>
                                            <a href="{{ route('requisicionProducto.edit', $item->id) }}"
                                                class="btn btn-success btn-sm">
                                                <i class="fas fa-clipboard"></i> Editar Requisición
                                            </a>
                                        @endif

                                        @if (auth()->user()->hasRole('Gerente Unidad Organizativa') ||
                                                auth()->user()->hasRole('Super Administrador'))
                                            <a href="{{ route('requisicionProducto.destroy', $item) }}" data-toggle="modal"
                                                data-target="#deleteModal" data-delete="{{ $item->id }}"
                                                class="btn btn-danger btn-sm"> <i class="fas fa-trash"></i> </a>
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
                <div class="modal-body">Seleccione "eliminar" Si realmente desea eliminar el registro
                </div>
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
@endsection
@section('js_datatable')
    <script>
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var delete_id = button.data('delete')
            var modal = $(this)
            modal.find('form').attr('action', '{{ asset('/requisicionProducto/destroy/') }}' + '/' +
                delete_id);
        })
    </script>
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
@endsection

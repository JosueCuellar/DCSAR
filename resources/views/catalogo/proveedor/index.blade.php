@extends('layoutsGeneral.admin.layouts.index')
@section('title', 'Proveedores')
@section('header')
    <div class="col-md-12">
        <h2>Lista de proveedores</h2>
    </div>
    <div class="col-md-12 d-grid gap-2 d-md-flex">
        <form action="{{ route('proveedor.create') }}" method="GET">
            @csrf
            <button type="submit" class="btn btn-success text-left" role="button" aria-pressed="true"><i
                    class="fa fa-plus"></i> Nuevo proveedor</button>
        </form>
    </div>
@endsection
@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-extra-sm table-striped text-center" id="dataTable6" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre comercial</th>
                            <th scope="col">Razon social</th>
                            <th scope="col">Dirección</th>
                            <th scope="col">Fax</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">Teléfono opcional</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($proveedores as $item)
                            <tr>
                                <th scope="row">{{ $item->id }}</th>
                                <td>{{ $item->nombreComercial }}</td>
                                <td>{{ $item->razonSocial }}</td>
                                <td>{{ $item->direccionProveedor }}</td>
                                <td>{{ $item->fax }}</td>
                                <td>{{ $item->telefonoProveedor1 }}</td>
                                <td>{{ $item->telefonoProveedor2 }}</td>
                                <td>
                                    <a href="{{ route('proveedor.edit', $item->id) }}">
                                        <ion-icon name="create-outline" class="fa-lg text-primary"></ion-icon>
                                    </a>
                                    <a href="{{ route('proveedor.destroy', $item) }}" data-toggle="modal"
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
                        <div class="modal-body">Seleccione "Borrar" Si realmente desea eliminar este registro                        </div>
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
        </div>
        <div class="card-footer small text-muted"></div>
    </div>
@endsection
@section('js_datatable')
    <script>
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var proveedor_id = button.data('delete')
            var modal = $(this)
            // modal.find('.modal-footer #user_id').val(user_id)
            modal.find('form').attr('action', 'proveedor/destroy/' + proveedor_id);
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

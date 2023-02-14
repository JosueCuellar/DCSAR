@extends('admin.layouts.index')
@section('title', 'Requisición producto')
@section('header')
    <div class="col-md-12">
        <h2>Requisiciones de productos</h2>
    </div>
    <div class="row p-3">
        <div class="col-md-12 d-grid gap-2 d-md-flex">
            <form action="{{ route('requisicionProducto.store') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success text-left" role="button" aria-pressed="true"><i
                        class="fa fa-plus"></i> Crear una requisición</button>
            </form>
        </div>
    </div>
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane"
                        type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Requisiciones
                        AÚN SIN COMPLETAR</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab"
                    tabindex="0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center table-striped" id="dataTable11" width="100%"
                                cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Fecha de realización</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requisicionesSinCompletar as $item)
                                        <tr>
                                            <td scope="row">{{ $item->fecha_requisicion}}</td>
                                            <td>{{ $item->estado->nombreEstado }}</td>
                                            <td>
                                                <a href="{{ route('requisicionProducto.detalle', $item->id) }}">
                                                    <ion-icon src="/ionicons.designerpack/create-outline.svg" class="fa-lg text-primary"></ion-icon>
                                                </a>
                                                <a href="{{ route('requisicionProducto.destroy', $item) }}"
                                                    data-toggle="modal" data-target="#deleteModal"
                                                    data-delete="{{ $item->id }}">
                                                    <ion-icon src="/ionicons.designerpack/trash-sharp.svg" class="fa-lg text-danger"></ion-icon>
                                                </a>
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

@endsection

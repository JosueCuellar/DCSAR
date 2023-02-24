@extends('admin.layouts.index')
@section('title', 'Detalle de Compra')
@section('header')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />
    <script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
    <div class="col-md-12">
        <h2 class="text-center">RECEPCIÓN DEL INGRESO DE MATERIALES Y SUMINISTROS DE OFICINA</h2>
    </div>
    <div class="row">
        <div class="col-md-12 d-grid gap-2 d-md-flex">
            <div class="m-1">
                <button type="submit" data-toggle="modal" data-target="#modalArchivos"
                    data-detalle="{{ $recepcionCompra->id }}" class="btn btn-warning  text-left"><i class="fa fa-check"></i>
                    Finalizar registro</button>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card card-post" id="post_card">
                        <div class="card-header">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                Detalle del ingreso
                                <div class="pull-right">
                                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm float-right"
                                        data-toggle="tooltip" data-placement="left" title
                                        data-original-title="Regresar a lista">Regresar</a>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('detalleCompra.store', ['recepcionCompra' => $recepcionCompra->id]) }}"
                            method='POST'>
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group has-feedback row">
                                            <label for="producto_id" class="col-12 control-label">Seleccionar
                                                producto:</label>
                                            <div class="col-12">
                                                <select class="form-control" name="producto_id" id="producto_id">
                                                    <option selected disabled='disabled'>Seleccionar producto</option>
                                                    @foreach ($productos as $item)
                                                        @if (old('producto_id') == $item->id)
                                                            <option value="{{ $item->id }}" selected>
                                                                {{ $item->cod_producto.'-'.$item->descripcion .''.$item->medida->nombreMedida}}

                                                            </option>
                                                        @else
                                                            <option value="{{ $item->id }}">
                                                                {{ $item->cod_producto}}||
                                                                {{$item->descripcion}}||
                                                                Marca:  {{$item->marca->nombre}}||
                                                                Medida: {{$item->medida->nombreMedida}}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('producto_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group has-feedback row">
                                            <label for="cantidadIngreso" class="col-12 control-label">Cantidad
                                                ingresada:</label>
                                            <div class="col-12">
                                                <input id='cantidadIngreso' type='number'
                                                    value="{{ old('cantidadIngreso') }}" min='1' class='form-control'
                                                    name='cantidadIngreso' placeholder='Cantidad ingresada'>
                                            </div>
                                            @error('cantidadIngreso')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group has-feedback row">
                                            <label for="precioUnidad" class="col-12 control-label">Precio de unidad:</label>
                                            <div class="col-12">
                                                <input id='precioUnidad' type='number' min='0.01'
                                                    value="{{ old('precioUnidad') }}" step='0.01' class='form-control'
                                                    name='precioUnidad' placeholder='Precio unitario'>
                                            </div>

                                            @error('precioUnidad')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group has-feedback row">
                                            <label for="fechaVenc" class="col-12 control-label">Fecha de
                                                vencimiento:</label>
                                            <div class="col-12">
                                                <input id='fechaVenc' value="{{ old('fechaVenc') }}" type='date'
                                                    min="{{ date('Y-m-d') }}" class='form-control' name='fechaVenc'
                                                    placeholder='Fecha de vencimiento'>
                                            </div>

                                            @error('fechaVenc')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-12">
                                        <span data-toggle="tooltip" title data-original-title="Guardar cambios realizados">
                                            <button type="submit" class="btn btn-success" value="Guardar">
                                                <ion-icon name="save-outline"></ion-icon>
                                                Agregar producto
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable7" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">Producto</th>
                                            <th scope="col">Cantidad</th>
                                            <th scope="col">Fecha vencimiento</th>
                                            <th scope="col">Precio unidad</th>
                                            <th scope="col">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($detalleCompra as $itemDet)
                                            <tr>
                                                <td>
                                                    <a
                                                        href="{{ route('detalleCompra.edit', ['recepcionCompra' => $recepcionCompra->id, 'detalleCompra' => $itemDet]) }}">
                                                        <ion-icon name="create-outline" class="fa-lg text-primary">
                                                        </ion-icon>
                                                    </a>

                                                    <a href="{{ route('detalleCompra.destroy', ['recepcionCompra' => $recepcionCompra->id, 'detalleCompra' => $itemDet]) }}"
                                                        data-toggle="modal" data-target="#deleteModal"
                                                        data-ingresoid="{{ $recepcionCompra->id }}"
                                                        data-detalleid="{{ $itemDet->id }}">
                                                        <ion-icon name="trash-outline" class="fa-lg text-danger">
                                                        </ion-icon>
                                                    </a>
                                                </td>
                                                <th scope="row">{{ $itemDet->producto->descripcion }}</th>
                                                <td>{{ $itemDet->cantidadIngreso }}</td>
                                                <td>{{ $itemDet->fechaVenc }}</td>
                                                <td>${{ $itemDet->precioUnidad }}</td>
                                                <td>${{ $itemDet->total }}</td>
                                               
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="thead-light">
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                            <th scope="col">Total</th>
                                            <th scope="col">${{$totalFinal}}</th>
                                        </tr>
                                    </tfoot >
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalArchivos" style="display: none;" aria-hidden="true">
        <form method="POST" class="form-horizontal" action="">
            @csrf
            @method('put')
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Subir archivos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body form-group">
                        <form action=""></form>
                        <form method="POST" action="{{ route('upload.documento', $recepcionCompra->id) }}"
                            class="dropzone" id="my-dropzone">
                            @csrf
                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <a class="btn btn-warning" onclick="$(this).closest('form').submit();">Guardar</a>
                    </div>
                </div>

            </div>
        </form>
    </div>
    <div>
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
                <div class="modal-body">Seleccione "eliminar" Si realmente desea eliminar a este registro
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

    @section('js')
    @if (session('status'))
        <script>
            $(document).Toasts('create', {
                title: 'Ingreso de producto',
                position: 'topRight',
                body: '{{ session('status') }}',
                class: 'bg-info',
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
                title: 'Ingreso de producto',
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
                icon: 'fas fa-solid fa-xmark',
                delay: 3500,
                close: false,
            })
        </script>
    @endif
@endsection

@section('js_datatable')
    <script>
        Dropzone.options.myDropzone = {
            // Configuration options go here
            paramName: "file[]",
            dictDefaultMessage: 'Agrega los documentos aquí',
            maxFilesize: 4, // MB
            addRemoveLinks: true,
            dictFileTooBig: "El archivo es muy grande. Tamaño máximo: 4MiB.",
            dictRemoveFile: "Eliminar",
            dictCancelUpload: "Cancelar carga",
            acceptedFiles: "application/pdf,.doc,.docx,.xls,.xlsx,.csv,.tsv,.ppt,.pptx,.pages,.odt,.rtf",
            init: function() {
                this.on("removedfile", function(file) {
                    // send an AJAX request to delete the file from the server
                    axios.post('{{ route('delete.documento', $recepcionCompra->id) }}', {
                            filename: file.name
                        })
                        .then(function(response) {
                            console.log(response);
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                });
            }
        };
        Dropzone.discover();
    </script>
    <script>
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var ingreso_id = button.data('ingresoid')
            var detalle_id = button.data('detalleid')

            var modal = $(this)
            // modal.find('.modal-footer #user_id').val(user_id)
            modal.find('form').attr('action', '/detalleCompra/detalle/destroy/' + ingreso_id + '/' + detalle_id);
        });
    </script>

    <script>
        $('#modalArchivos').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var recepcion_id = button.data('detalle')

            var modal = $(this)
            // modal.find('.modal-footer #user_id').val(user_id)
            modal.find('form').attr('action', '{{ asset('/recepcionCompra/completar/') }}' + '/' + recepcion_id);

        });
    </script>

    <script>
        $(document).ready(function() {
            $('#dataTable7').DataTable({
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
@endsection

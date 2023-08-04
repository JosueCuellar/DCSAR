@extends('admin.layouts.index')
@section('title', 'Detalle de Ingreso')
@section('header')
    <script src="{{ asset('dependencias/js/unpkg.com_axios@1.4.0_dist_axios.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('dependencias/js/unpkg.com_dropzone@6.0.0-beta.1_dist_dropzone.css') }}">
    <script src="{{ asset('dependencias/js/unpkg.com_dropzone@6.0.0-beta.1_dist_dropzone-min.js') }}"></script>
@endsection

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-post" id="post_card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div class="pull-right">
                                <a href="{{ route('recepcionCompra.consultar') }}"
                                    class="btn btn-outline-secondary btn-sm float-right" data-toggle="tooltip"
                                    data-placement="left" title data-original-title="Regresar a lista">Regresar</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="card card-post" id="post_card">
                                    <form
                                        action="{{ route('detalleCompra.storeEdit', ['recepcionCompra' => $recepcionCompra->id]) }}"
                                        method='POST'>
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group has-feedback row">
                                                        <label for="producto_id" class="col-12 control-label">Seleccionar
                                                            producto:</label>
                                                        <div class="col-12">
                                                            <select class="form-control" name="producto_id"
                                                                id="producto_id">
                                                                <option selected disabled='disabled'>Seleccionar producto
                                                                </option>
                                                                @foreach ($productos as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->codProducto . "\nDescripcion: " . $item->descripcion . "\nMarca:" . $item->marca->nombre }}
                                                                        Medida:{{ $item->medida->nombreMedida }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('producto_id')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group has-feedback row">
                                                        <label for="cantidadIngreso" class="col-12 control-label">Cantidad
                                                            ingresada:</label>
                                                        <div class="col-12">
                                                            <input id='cantidadIngreso' type='number'
                                                                value="{{ old('cantidadIngreso') }}" min='1'
                                                                class='form-control' name='cantidadIngreso'
                                                                placeholder='Cantidad ingresada'>
                                                        </div>
                                                        @error('cantidadIngreso')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group has-feedback row">
                                                        <label for="precioUnidad" class="col-12 control-label">Precio de
                                                            unidad($):</label>
                                                        <div class="col-12">
                                                            <input id='precioUnidad' type='number' min='0.01'
                                                                value="{{ old('precioUnidad') }}" step='.01'
                                                                class='form-control' name='precioUnidad'
                                                                placeholder='$0.00'>
                                                        </div>
                                                        @error('precioUnidad')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="row-fechaVenc">
                                                <div class="col-12">
                                                    <div class="form-group has-feedback row">
                                                        <label for="fechaVenc" class="col-12 control-label">Fecha de
                                                            vencimiento:</label>
                                                        <div class="col-12">
                                                            <input id='fechaVenc' value="{{ old('fechaVenc') }}"
                                                                type='date' min="{{ date('Y-m-d') }}"
                                                                class='form-control' name='fechaVenc'
                                                                placeholder='Fecha de vencimiento' required>
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
                                                    <button type="submit" class="btn btn-block btn-dark btn-sm"
                                                        value="Guardar">
                                                        Agregar producto
                                                    </button>
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
                                            <table class="table table-sm table-bordered text-center" id="dataTable7"
                                                width="100%" cellspacing="0">
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
                                                                    <ion-icon name="create-outline"
                                                                        class="fa-lg text-primary">
                                                                    </ion-icon>
                                                                </a>
                                                                <a href="{{ route('detalleCompra.destroyEdit', ['recepcionCompra' => $recepcionCompra->id, 'detalleCompra' => $itemDet]) }}"
                                                                    data-toggle="modal" data-target="#deleteModal"
                                                                    data-ingresoid="{{ $recepcionCompra->id }}"
                                                                    data-detalleid="{{ $itemDet->id }}">
                                                                    <ion-icon name="trash-outline"
                                                                        class="fa-lg text-danger">
                                                                    </ion-icon>
                                                                </a>
                                                            </td>
                                                            <th scope="row">{{ $itemDet->producto->descripcion }}
                                                            </th>
                                                            <td>{{ $itemDet->cantidadIngreso }}</td>
                                                            @if (is_null($itemDet->fechaVencimiento))
                                                                <td>-----</td>
                                                            @else
                                                                <td>{{ $itemDet->fechaVencimiento }}</td>
                                                            @endif
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
                                                        <th scope="col">${{ $totalFinal }}</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('precioUnidad').addEventListener('input', function(e) {
            let value = e.target.value;
            value = value.replace(/[^0-9.]/g, '');
            value = value.replace(-, ''); // Elimina todos los caracteres que no sean dígitos o puntos
            // Elimina todos los caracteres que no sean dígitos o puntos
            e.target.value = value;
        });
    </script>

    <!-- finalizar Modal-->
    <div class="modal fade" id="modalFinalizar" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" class="form-horizontal" action="">
                    @csrf
                    @method('put')
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">¿Estás seguro de confirmar el registro?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Para que el registro de ingreso se guarde debe de Guardar
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <a class="btn btn-warning" onclick="$(this).closest('form').submit();">Guardar</a>
                    </div>
                </form>
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
                <div class="modal-body">Seleccione "Borrar" Si realmente desea eliminar este registro                </div>
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
@endsection
@section('js_datatable')

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
                }],
                "bPaginate": false

            });
        });
    </script>
    <script>
        document.getElementById('cantidadIngreso').addEventListener('input', function(e) {
            if (e.target.value.includes('.')) {
                e.target.value = e.target.value.replace('.', '');
            }
            e.target.value = e.target.value.replace('-', '');
            e.target.value = e.target.value.replace(/\./g, '');
        });
    </script>



    <script>
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var ingreso_id = button.data('ingresoid')
            var detalle_id = button.data('detalleid')
            var modal = $(this)
            modal.find('form').attr('action', '/detalleCompra/detalleRegistrado/destroy/' + ingreso_id + '/' +
                detalle_id);
        });
    </script>

@endsection
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
                icon: 'fas fa-exclamation-triangle',
                delay: 3500,
                close: false,
            })
        </script>
    @endif
    <script>
        $(document).ready(function(e) {
            $('#producto_id').select2({
                width: 'resolve',
                language: {
                    noResults: function() {
                        return "No hay resultado";
                    },
                    searching: function() {
                        return "Buscando..";
                    }
                }
            });
        });
        $("#producto_id").select2()
    </script>
    <script>
        $(document).ready(function(e) {
            $('#nombreBodega').select2({
                width: 'resolve',
                language: {
                    noResults: function() {
                        return "No hay resultado";
                    },
                    searching: function() {
                        return "Buscando..";
                    }
                }
            });
        });
        $("#nombreBodega").select2()
    </script>
    <script>
        const select = document.getElementById('producto_id');
        const input = document.getElementById('fechaVenc');
        const div = document.getElementById('row-fechaVenc');
        var productos = <?php echo json_encode($productos); ?>;

        localStorage.setItem('productos', JSON.stringify(productos));

        var objetos = JSON.parse(localStorage.getItem('productos'));

        // var objetos = {!! json_encode($productos) !!};
        $('#producto_id').on('change', function(e) {
            const objeto_encontrado = objetos.find(objeto => objeto.id === parseInt($(this).val()));
            console.log(objeto_encontrado["perecedero"]);
            if (objeto_encontrado["perecedero"] === "1") {
                input.disabled = false;
                div.style.display = 'block';

            } else {
                input.disabled = true;
                div.style.display = 'none';
                document.getElementById("fechaVenc").value = "yyyy-MM-dd";
            }
            if (objeto_encontrado) {
                console.log(JSON.stringify(objeto_encontrado));
            } else {
                console.log(`No se encontró ningún objeto con ID ${$(this).val()}`);
            }
        });
    </script>
@endsection

@extends('admin.layouts.index')
@section('title', 'Producto')
@section('header')
    <div class="container">
        <div class="col-md-12">
            <h2>Nuevo producto</h2>
        </div>
    </div>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card card-post" id="post_card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            Creando producto:
                            <div class="pull-right">
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm float-right"
                                    data-toggle="tooltip" data-placement="left" title
                                    data-original-title="Regresar a lista de productos">Regresar</a>
                            </div>
                        </div>
                    </div>
                    <x-errores class="mb-4" />
                    <form action="{{ route('producto.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group has-feedback row">
                                        <label for="rubro_id" class="col-12 control-label">Rubro:</label>
                                        <div class="col-12">
                                            <select class="form-control" name="rubro_id" id="rubro_id">
                                                <option selected='true' disabled='disabled'>Seleccionar rubro del producto
                                                </option>
                                                @foreach ($rubros as $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->codigoPresupuestario . ' ' . $item->descripRubro }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group has-feedback row">
                                        <label for="medida_id" class="col-12 control-label">Unidad de Medida:</label>
                                        <div class="col-12">
                                            <select class="form-control" name="medida_id" id="medida_id">
                                                <option selected='true' disabled='disabled'>Seleccionar unidad de medida
                                                </option>
                                                @foreach ($medidas as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nombreMedida }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group has-feedback row">
                                        <label for="marca_id" class="col-12 control-label">Marca:</label>
                                        <div class="col-12">
                                            <select class="form-control" name="marca_id" id="marca_id">
                                                <option selected='true' disabled='disabled'>Seleccionar marca</option>
                                                @foreach ($marcas as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group has-feedback row">
                                        <label for="descripcion" class="col-12 control-label">Descripción del
                                            producto:</label>
                                        <div class="col-12">
                                            <input id="descripcion" type="text" class="form-control" name="descripcion"
                                                placeholder="Descripción">
                                        </div>
                                    </div>

                                    <div class="form-group has-feedback row">
                                        <label for="observacion" class="col-12 control-label">Observacion:</label>
                                        <div class="col-12">
                                            <input id="observacion" type="text" class="form-control" name="observacion"
                                                placeholder="Observacion">
                                        </div>
                                    </div>




                                </div>


                                <div class="col-sm-6">

                                    <div class="form-group has-feedback row">
                                        <label for="codProducto" class="col-12 control-label">Codigo producto:</label>
                                        <div class="col-12">
                                            <input id="codProducto" type="text" class="form-control" name="codProducto"
                                                placeholder="Codigo producto" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="codProducto" class="col-12 control-label">Tipo de alimento:</label>
                                        <div class="col-12 form-control">
                                            <div
                                                class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                <input type="hidden" name="perecedero" value="0">
                                                <input type="checkbox" class="custom-control-input" id="check"
                                                    name="perecedero" value="1">
                                                <label class="custom-control-label" for="check">Perecedero</label>
                                            </div>
                                        </div>
                                    </div>




                                    <div class="form-group has-feedback row">
                                        <label for="imagen" class="col-12 control-label">Seleccionar imagen</label>
                                        <div class="col-12">
                                            <input id="imagen" class="form-control" name="imagen" type="file"
                                                accept="image/png, image/jpg, image/jpeg">
                                        </div>
                                    </div>

                                    <div class="form-group has-feedback row">
                                        <img id="imagenSeleccionada" style="max-height: 150px;max-width: 150px;">
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-12">
                                    <span data-toggle="tooltip" title data-original-title="Guardar cambios realizados">
                                        <button type="submit" class="btn btn-success" value="Guardar" name="action">
                                            <ion-icon name="save-outline"></ion-icon>
                                            Guardar producto
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_imagen')


    <script>
        const select = document.getElementById('rubro_id');
        const input = document.getElementById('codProducto');
        var datos = {!! json_encode($rubros) !!};

        var datosProductos = {!! json_encode($productos) !!};
        $('#rubro_id').on('change', function(e) {
            var num = 0;
            datosProductos.forEach(element => {
                if (element.rubro_id == select.value) {
                    num = num + 1;
                }
            });
            input.value = datos[select.value - 1].codigoPresupuestario + '-' + (num + 1);
        });
    </script>

    <script>
        $(document).ready(function(e) {
            $('#rubro_id').select2({
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
        $("#rubro_id").select2()
    </script>

    <script>
        $(document).ready(function(e) {
            $('#marca_id').select2({
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
        $("#marca_id").select2()
    </script>

    <script>
        $(document).ready(function(e) {
            $('#medida_id').select2({
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
        $("#medida_id").select2()
    </script>

    <script>
        $(document).ready(function(e) {
            $('#imagen').change(function() {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#imagenSeleccionada').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>

    {{-- <script>
        $("#perecedero").on('change', function() {
            if ($(this).is(':checked')) {
                $(this).attr('value', '1');
                var check = $(this).val();
                console.log(check);
            } else {
                $(this).attr('value', '0');
                var check = $(this).val();
                console.log(check);
            }
        });
    </script> --}}

@endsection


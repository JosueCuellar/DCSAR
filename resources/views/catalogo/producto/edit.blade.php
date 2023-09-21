@extends('layoutsGeneral.admin.layouts.index')
@section('title', 'Producto')
@section('header')
    <div class="container">
        <div class="col-md-12">
            <h2>Editar producto</h2>
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
                            Editando producto:
                            <div class="pull-right">
                                <a href="{{ route('producto.index') }}" class="btn btn-outline-secondary btn-sm float-right"
                                    data-toggle="tooltip" data-placement="left" title
                                    data-original-title="Regresar a lista de productos">Regresar</a>
                            </div>
                        </div>
                    </div>
                    <x-errores class="mb-4" />
                    <form action="{{ route('producto.update', $producto->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group has-feedback row">
                                        <label for="rubro_id" class="col-12 control-label">Rubro:</label>
                                        <div class="col-12">
                                            <select class="form-control" name="rubro_id" id="rubro_id">
                                                @foreach ($rubros as $item)
                                                    <option value="{{ $item->id }}"
                                                        data-codigo="{{ $item->codigoPresupuestario }}"
																												@if ($producto->rubro_id == $item->id) {{ 'selected' }} @endif>
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
                                                    <option value="{{ $item->id }}"
                                                        @if ($producto->medida_id == $item->id) {{ 'selected' }} @endif>
                                                        {{ $item->nombreMedida }}</option>
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
                                                    <option value="{{ $item->id }}"
                                                        @if ($producto->marca_id == $item->id) {{ 'selected' }} @endif>
                                                        {{ $item->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="descripcion" class="col-12 control-label">Descripción del
                                            producto:</label>
                                        <div class="col-12">
                                            <input id="descripcion" type="text" class="form-control" name="descripcion"
                                                value="{{ $producto->descripcion }}" placeholder="Descripción">
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="observacion" class="col-12 control-label">Observacion:</label>
                                        <div class="col-12">
                                            <input id="observacion" type="text" class="form-control" name="observacion"
                                                value="{{ $producto->observacion }}" placeholder="Observacion">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group has-feedback row">
                                        <label for="codProducto" class="col-12 control-label">Codigo producto:</label>
                                        <div class="row">
                                            <div class="col-3"> <input id="codProductoPrefijo" type="text"
                                                    class="form-control" readonly>
                                            </div>
                                            <div class="col-9"> <input id="codProducto" type="number" class="form-control"
                                                    placeholder="Codigo producto" required min="1" max="9999">
                                            </div>
                                            <input id="codProductoCon" type="text" class="form-control"
                                                name="codProductoCon" hidden>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="codProducto" class="col-12 control-label">Tipo de alimento:</label>
                                        <div class="col-12 form-control">
                                            <input type="hidden" name="perecedero" id="perecedero"
                                                value="{{ $producto->perecedero }}">
                                            <input type="checkbox" id="checkPerecedero" name="checkPerecedero"
                                                value="1" @if ($producto->perecedero) checked @endif>
                                            <label for="perecedero">Perecedero</label>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="imagen" class="col-12 control-label">Seleccionar imagen</label>
                                        <div class="col-12">
                                            <input id="imagen" class="img-fluid" name="imagen" type="file"
                                                value="{{ $producto->imagen }}">
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <img src="/imagen/{{ $producto->imagen }}" id="imagenSeleccionada"
                                            style="max-height: 150px;max-width: 150px">
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
                                            Actualizar producto
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
        document.addEventListener("DOMContentLoaded", function() {
            let string = @json($producto);
            const inputPrefijo = document.getElementById('codProductoPrefijo');
            const inputCodigo = document.getElementById('codProducto');
            let delimiter = "-";
            let array = string.codProducto.split(delimiter);
            inputPrefijo.value = array[0];
            inputCodigo.value = array[1];
            const codProductoPrefijo = document.getElementById("codProductoPrefijo").value;
            const codProducto = document.getElementById("codProducto").value;
            const concatenatedValue = codProductoPrefijo + '-' + codProducto;
            document.getElementById("codProductoCon").value = concatenatedValue;
            console.log(concatenatedValue)
        });
    </script>
    <script>
        const select = document.getElementById('rubro_id');
        const input = document.getElementById('codProductoPrefijo');
        document.getElementById("codProductoCon").value = codProductoCon;
        $('#rubro_id').on('change', function(e) {
            // Obtener el elemento option seleccionado
            let selectedOption = select.options[select.selectedIndex];
            // Obtener el valor del atributo data-codigo
            let codigo = selectedOption.getAttribute('data-codigo');
            // Asignar el valor al elemento input
            input.value = codigo;
        });
        document.querySelector('button[name="action"]').addEventListener('click', function() {
            var codProductoPrefijo = document.getElementById("codProductoPrefijo").value;
            var codProducto = document.getElementById("codProducto").value;
            var concatenatedValue = codProductoPrefijo + '-' + codProducto;
            document.getElementById("codProductoCon").value = concatenatedValue;
            console.log(concatenatedValue)
        });
    </script>
    <script>
        document.getElementById('codProducto').addEventListener('input', function(e) {
            if (e.target.value.includes('.')) {
                e.target.value = e.target.value.replace('.', '');
            }
            e.target.value = e.target.value.replace(/\./g, '');
        });
    </script>
    <script>
        // Obtener el elemento checkbox y el elemento div
        var checkbox = document.getElementById("checkPerecedero");
        var div = document.querySelector(".form-group");
        var inputPerecedero = document.querySelector("input[name='perecedero']");
        // Agregar un evento de cambio al checkbox
        checkbox.addEventListener("change", function() {
            // Actualizar el contenido del div con el valor del checkbox
            if (checkbox.checked) {
                inputPerecedero.value = 1;
            } else {
                inputPerecedero.value = 0;
            }
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
@endsection

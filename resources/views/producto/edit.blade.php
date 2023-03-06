@extends('admin.layouts.index')
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
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm float-right"
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
                                                <option selected='true' disabled='disabled'>Seleccionar rubro del producto
                                                </option>
                                                @foreach ($rubros as $item)
                                                    <option value="{{ $item->id }}"
                                                        @if ($producto->rubro_id == $item->id) {{ 'selected' }} @endif>
                                                        {{ $item->descripcionRubro }}</option>
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
                                        <label for="descripcion" class="col-12 control-label">Descripción del producto:</label>
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
                                        <label for="cod_producto" class="col-12 control-label">Codigo producto:</label>
                                        <div class="col-12">
                                            <input id="cod_producto" type="text" class="form-control" name="cod_producto"
                                                value="{{ $producto->cod_producto }}" placeholder="Codigo producto">
                                        </div>
                                    </div>


                                    
                                    <div class="form-group">
                                        <label for="cod_producto" class="col-12 control-label">Tipo de alimento:</label>
                                        <div class="col-12 form-control">
                                            <div
                                                class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                @if ($producto->perecedero == 1)
                                                <input type="hidden" name="perecedero" value="0">
                                                <input type="checkbox" class="custom-control-input" id="check"
                                                    name="perecedero" value="{{$producto->perecedero}}">
                                                <label class="custom-control-label" for="check">Perecedero</label>
                                                @endif
                                                
                                            </div>
                                        </div>
                                    </div>


                                   
                                    <div class="form-group has-feedback row">
                                        <label for="imagen" class="col-12 control-label">Seleccionar imagen</label>
                                        <div class="col-12">
                                            <input id="imagen" class="img-fluid" name="imagen" type="file">
                                        </div>
                                    </div>

                                    <div class="form-group has-feedback row">
                                        <img src="/imagen/{{ $producto->imagen }}" id="imagenSeleccionada"
                                            style="max-height: 100px">
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
@section('js_imagen')

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
@endsection

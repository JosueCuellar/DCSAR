@extends('admin.layouts.index')
@section('title', 'Proveedores')
@section('header')
    <div class="container">
        <div class="col-md-12">
            <h2>Nuevo proveedor</h2>
        </div>
    </div>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-post" id="post_card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            Creando nuevo proveedor:
                            <div class="pull-right">
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm float-right"
                                    data-toggle="tooltip" data-placement="left" title
                                    data-original-title="Regresar a lista de categorias">Regresar</a>
                            </div>
                        </div>
                    </div>
                    <x-errores class="mb-4" />
                    <form action="{{ route('proveedor.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group has-feedback row">
                                        <label for="nombreComercial" class="col-12 control-label">Nombre comercial:</label>
                                        <div class="col-12">
                                            <input id="nombreComercial" type="text" class="form-control"
                                                name="nombreComercial" value="{{ old('nombreComercial') }}"
                                                placeholder="Nombre comercial del proveedor">
                                        </div>
                                    </div>

                                    <div class="form-group has-feedback row">
                                        <label for="direccion" class="col-12 control-label">Dirección:</label>
                                        <div class="col-12">
                                            <input id="direccion" type="text" class="form-control" name="direccion"
                                                value="{{ old('direccion') }}" placeholder="Dirección del proveedor">
                                        </div>
                                    </div>


                                    <div class="form-group has-feedback row">
                                        <label for="telefono1" class="col-12 control-label">Teléfono:</label>
                                        <div class="col-12">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                </div>
                                                <input type="text" class="form-control"
                                                    data-inputmask="&quot;mask&quot;: &quot;(999) 9999-9999&quot;"
                                                    data-mask="" inputmode="text" id="telefono1" name="telefono1"
                                                    value="{{ old('telefono1') }}" placeholder="Teléfono del proveedor">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group has-feedback row">
                                        <label for="razonSocial" class="col-12 control-label">Razón social:</label>
                                        <div class="col-12">
                                            <input id="razonSocial" type="text" class="form-control" name="razonSocial"
                                                value="{{ old('razonSocial') }}" placeholder="Razón social del proveedor">
                                        </div>
                                    </div>

                                    <div class="form-group has-feedback row">
                                        <label for="fax" class="col-12 control-label">FAX:</label>
                                        <div class="col-12">
                                            <input id="fax" type="text" maxlength="10" class="form-control" name="fax"
                                                value="{{ old('fax') }}" placeholder="FAX del proveedor">
                                        </div>
                                    </div>

                                    <div class="form-group has-feedback row">
                                        <label for="telefono2" class="col-12 control-label">Teléfono Opcional:</label>
                                        <div class="col-12">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                </div>
                                                <input type="text" class="form-control"
                                                    data-inputmask="&quot;mask&quot;: &quot;(999) 9999-9999&quot;"
                                                    data-mask="" inputmode="text" id="telefono2" name="telefono2"
                                                    value="{{ old('telefono2') }}" placeholder="Teléfono del proveedor">
                                            </div>
                                        </div>
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
                                            Guardar proveedor
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

@section('js')
    <script>
        $(function() { //Money Euro
            $('[data-mask]').inputmask();
        })
    </script>
@endsection

@endsection

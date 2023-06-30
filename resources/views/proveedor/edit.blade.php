@extends('admin.layouts.index')
@section('title', 'Proveedores')
@section('header')
    <div class="container">
        <div class="col-md-12">
            <h2>Editar proveedor</h2>
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
                            Editando proveedor:
                            <div class="pull-right">
                                <a href="{{ route('proveedor.index') }}"
                                    class="btn btn-outline-secondary btn-sm float-right" data-toggle="tooltip"
                                    data-placement="left" title
                                    data-original-title="Regresar a lista de proveedores">Regresar</a>
                            </div>
                        </div>
                    </div>
                    <x-errores class="mb-4" />
                    <form action="{{ route('proveedor.update', $proveedor) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group has-feedback row">
                                        <label for="nombreComercial" class="col-12 control-label">Nombre comercial:</label>
                                        <div class="col-12">
                                            <input id="nombreComercial" type="text" class="form-control"
                                                name="nombreComercial" value="{{ $proveedor->nombreComercial }}"
                                                placeholder="Nombre comercial del proveedor">
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="direccionProveedor" class="col-12 control-label">Dirección:</label>
                                        <div class="col-12">
                                            <input id="direccionProveedor" type="text" class="form-control"
                                                name="direccionProveedor" value="{{ $proveedor->direccionProveedor }}"
                                                placeholder="Dirección del proveedor">
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="telefonoProveedor1" class="col-12 control-label">Teléfono:</label>
                                        <div class="col-12">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                </div>
                                                <input type="text" class="form-control"
                                                    data-inputmask="&quot;mask&quot;: &quot;(999) 9999-9999&quot;"
                                                    data-mask="" inputmode="text" id="telefonoProveedor1"
                                                    name="telefonoProveedor1" value="{{ $proveedor->telefonoProveedor1 }}"
                                                    placeholder="Teléfono del proveedor">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group has-feedback row">
                                        <label for="razonSocial" class="col-12 control-label">Razón social:</label>
                                        <div class="col-12">
                                            <input id="razonSocial" type="text" class="form-control" name="razonSocial"
                                                value="{{ $proveedor->razonSocial }}"
                                                placeholder="Razón social del proveedor">
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="fax" class="col-12 control-label">FAX:</label>
                                        <div class="col-12">
                                            <input id="fax" type="number" class="form-control" name="fax"
                                                value="{{ $proveedor->fax }}" placeholder="FAX del proveedor">
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="telefonoProveedor2" class="col-12 control-label">Teléfono
                                            Opcional:</label>
                                        <div class="col-12">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                </div>
                                                <input type="text" class="form-control"
                                                    data-inputmask="&quot;mask&quot;: &quot;(999) 9999-9999&quot;"
                                                    data-mask="" inputmode="text" id="telefonoProveedor2"
                                                    name="telefonoProveedor2" value="{{ $proveedor->telefonoProveedor2 }}"
                                                    placeholder="Teléfono del proveedor">
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
                                            Actualizar proveedor
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
@section('js')
    <script src="{{ asset('vendor/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <script>
        document.getElementById('fax').addEventListener('input', function(e) {
            if (e.target.value.includes('.')) {
                e.target.value = e.target.value.replace('.', '');
            }
            e.target.value = e.target.value.replace(/\./g, '');
        });
    </script>
    <script>
        Inputmask().mask(document.querySelectorAll('[data-inputmask]'));
    </script>
@endsection

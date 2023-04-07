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
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm float-right"
                                    data-toggle="tooltip" data-placement="left" title
                                    data-original-title="Regresar a lista de categorias">Regresar</a>
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
                                        <label for="nombre_comercial" class="col-12 control-label">Nombre comercial:</label>
                                        <div class="col-12">
                                            <input id="nombre_comercial" type="text" class="form-control"
                                                name="nombre_comercial" value="{{ $proveedor->nombre_comercial }}"
                                                placeholder="Nombre comercial del proveedor">
                                        </div>
                                    </div>

                                    <div class="form-group has-feedback row">
                                        <label for="direccion_proveedor" class="col-12 control-label">Dirección:</label>
                                        <div class="col-12">
                                            <input id="direccion_proveedor" type="text" class="form-control" name="direccion_proveedor"
                                                value="{{ $proveedor->direccion_proveedor }}" placeholder="Dirección del proveedor">
                                        </div>
                                    </div>


                                    <div class="form-group has-feedback row">
                                        <label for="telefono1_proveedor" class="col-12 control-label">Teléfono:</label>
                                        <div class="col-12">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                </div>
                                                <input type="text" class="form-control"
                                                    data-inputmask="&quot;mask&quot;: &quot;(999) 9999-9999&quot;"
                                                    data-mask="" inputmode="text" id="telefono1_proveedor" name="telefono1_proveedor"
                                                    value="{{ $proveedor->telefono1_proveedor }}"
                                                    placeholder="Teléfono del proveedor">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group has-feedback row">
                                        <label for="razon_social" class="col-12 control-label">Razón social:</label>
                                        <div class="col-12">
                                            <input id="razon_social" type="text" class="form-control" name="razon_social"
                                                value="{{ $proveedor->razon_social }}"
                                                placeholder="Razón social del proveedor">
                                        </div>
                                    </div>

                                    <div class="form-group has-feedback row">
                                        <label for="fax" class="col-12 control-label">FAX:</label>
                                        <div class="col-12">
                                            <input id="fax" type="text" maxlength="10" class="form-control"
                                                name="fax" value="{{ $proveedor->fax }}"
                                                placeholder="FAX del proveedor">
                                        </div>
                                    </div>

                                    <div class="form-group has-feedback row">
                                        <label for="telefono2_proveedor" class="col-12 control-label">Teléfono Opcional:</label>
                                        <div class="col-12">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                </div>
                                                <input type="text" class="form-control"
                                                    data-inputmask="&quot;mask&quot;: &quot;(999) 9999-9999&quot;"
                                                    data-mask="" inputmode="text" id="telefono2_proveedor" name="telefono2_proveedor"
                                                    value="{{ $proveedor->telefono2_proveedor }}"
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
@section('js')
    <script src="{{ asset('vendor/plugins/inputmask/jquery.inputmask.min.js') }}"></script>

    <script>
        $(function() { //Money Euro
            $('[data-mask]').inputmask();
        })
    </script>
@endsection


@endsection

@extends('admin.layouts.index')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-sm-12"></div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-post" id="post_card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        Creando nuevo proveedor: 
                        <div class="pull-right">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm float-right" data-toggle="tooltip" data-placement="left" title data-original-title="Regresar a lista de categorias">Regresar</a>
                        </div>
                    </div>
                </div>
                <x-errores class="mb-4" />
                <form action="{{route('proveedor.store')}}" method="POST">
                    @csrf
                <div class="card-body">
                    <div class="row">
                        
                        <div class="col-md-12">
                            <div class="form-group has-feedback row">
                                <label for="nombreComercial" class="col-12 control-label">Nombre comercial:</label>
                                <div class="col-12">
                                    <input id="nombreComercial" type="text" class="form-control"  name="nombreComercial" 
                                    value="{{old('nombreComercial')}}" placeholder="Nombre comercial del proveedor" >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group has-feedback row">
                                <label for="razonSocial" class="col-12 control-label">Razón social:</label>
                                <div class="col-12">
                                    <input id="razonSocial" type="text" class="form-control"  name="razonSocial" 
                                    value="{{old('razonSocial')}}" placeholder="Razón social del proveedor" >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group has-feedback row">
                                <label for="direccion" class="col-12 control-label">Dirección:</label>
                                <div class="col-12">
                                    <input id="direccion" type="text" class="form-control"  name="direccion" 
                                    value="{{old('direccion')}}" placeholder="Dirección del proveedor" >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group has-feedback row">
                                <label for="fax" class="col-12 control-label">FAX:</label>
                                <div class="col-12">
                                    <input id="fax" type="text" class="form-control"  name="fax" 
                                    value="{{old('fax')}}" placeholder="FAX del proveedor" >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group has-feedback row">
                                <label for="telefono1" class="col-12 control-label">Teléfono:</label>
                                <div class="col-12">
                                    <input id="telefono1" type="tel" maxlength="15" class="form-control"  name="telefono1" 
                                    value="{{old('telefono1')}}" placeholder="Teléfono del proveedor" >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group has-feedback row">
                                <label for="telefono2" class="col-12 control-label">Teléfono Opcional:</label>
                                <div class="col-12">
                                    <input id="telefono2" type="tel" maxlength="15" class="form-control"  name="telefono2" 
                                    value="{{old('telefono2')}}" placeholder="Teléfono del proveedor" >
                                </div>
                            </div>
                        </div>

 
                    </div>
                </div> 
                
                <div class="card-footer">
                    <div class="row">
                        <div class="col-9"></div>
                        <div class="col-3 pull-rigth">
                            <span data-toggle="tooltip" title data-original-title="Guardar cambios realizados">
                                <button type="submit" class="btn btn-success btn-lg btn-block" value="Guardar" name="action">
                                    <i class="fa fa-save fa-fw">
                                        <span class="sr-only">
                                            Guardar proveedor Icono
                                        </span>
                                    </i>
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

@endsection
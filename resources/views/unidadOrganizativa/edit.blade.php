@extends('admin.layouts.index')
@section('title','Unidad Organizativa')
@section('header')
    <div class="container">
        <div class="col-md-12">
            <h2>Editar unidad organizativa</h2>
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
                        Editando unidad organizativa: 
                        <div class="pull-right">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm float-right" data-toggle="tooltip" data-placement="left" title data-original-title="Regresar a lista de unidad">Regresar</a>
                        </div>
                    </div>
                </div>
                <x-errores class="mb-4" />
                <form action="{{route('unidadOrganizativa.update',$unidadOrganizativa)}}" method="POST">
                    @csrf
                    @method('put')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback row">
                                <label for="nombre_unidad_medida" class="col-12 control-label">Nombre unidad:</label>
                                <div class="col-12">
                                    <input value="{{old('nombre_unidad_medida',$unidadOrganizativa->nombre_unidad_medida)}}" id="nombre_unidad_medida" type="text" class="form-control" name="nombre_unidad_medida" placeholder="Nombre de unidad" required>
                                </div>
                            </div>
                            <div class="form-group has-feedback row">
                                <label for="descripcion_unidad_medida" class="col-12 control-label">Decripción de unidad:</label>
                                <div class="col-12">
                                    <input value="{{old('descripcion_unidad_medida',$unidadOrganizativa->descripcion_unidad_medida)}}" id="descripcion_unidad_medida" type="text" class="form-control" name="descripcion_unidad_medida" placeholder="Decripción de unidad" required>
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
                                Actualizar unidad organizativa
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
@extends('admin.layouts.index')
@section('title','Medida')
@section('header')
    <div class="container">
        <div class="col-md-12">
            <h2>Editar unidad de medida</h2>
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
                        Editando unidad de medida: 
                        <div class="pull-right">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm float-right" data-toggle="tooltip" data-placement="left" title data-original-title="Regresar a lista de marcas">Regresar</a>
                        </div>
                    </div>
                </div>
                <x-errores class="mb-4" />
                <form action="{{route('medida.update',$medida)}}" method="POST">
                    @csrf
                    @method('put')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback row">
                                <label for="nombre" class="col-12 control-label">Nombre de unidad de medida:</label>
                                <div class="col-12">
                                    <input value="{{old('nombreMedida',$medida->nombreMedida)}}" id="nombreMedida" type="text" class="form-control" name="nombreMedida" placeholder="Nombre de la medida" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-12">
                            <span data-toggle="tooltip" title data-original-title="Guardar cambios realizados">
                                <button type="submit" class="btn btn-success" value="Guardar"
                                    name="action">
                                    <ion-icon name="save-outline"></ion-icon>
                                    Actualizar unidad de medida
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
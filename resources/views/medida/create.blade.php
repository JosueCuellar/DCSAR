@extends('admin.layouts.index')
@section('title','Medida')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-sm-12"></div>
    </div>@section('title','Medida')
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card card-post" id="post_card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        Creando medida: 
                        <div class="pull-right">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm float-right" data-toggle="tooltip" data-placement="left" title data-original-title="Regresar a lista de categorias">Regresar</a>
                        </div>
                    </div>
                </div>
                <x-errores class="mb-4" />
                <form action="{{route('medida.store')}}" method="POST">
                    @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback row">
                                <label for="nombre" class="col-12 control-label">Nombre de medida:</label>
                                <div class="col-12">
                                <input id="nombreMedida" type="text" class="form-control"  name="nombreMedida" 
                                value="{{old('nombreMedida')}}" placeholder="Nombre de la medida" >
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
                                            Guardar medida Icono
                                        </span>
                                    </i>
                                            Guardar medida
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
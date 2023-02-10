@extends('admin.layouts.index')
@section('title','Estado')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-sm-12"></div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card card-post" id="post_card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        Creando estado: 
                        <div class="pull-right">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm float-right" data-toggle="tooltip" data-placement="left" title data-original-title="Regresar a lista de categorias">Regresar</a>
                        </div>
                    </div>
                </div>
                <x-errores class="mb-4" />
                <form action="{{route('estado.store')}}" method="POST">
                    @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback row">
                                <label for="codigoEstado" class="col-12 control-label">Codigo de estado:</label>
                                <div class="col-12">
                                <input id="n" type="text" class="form-control"  name="codigoEstado" 
                                value="{{old('codigoEstado')}}" placeholder="Codigo de estado" >
                                </div>
                            </div>
                            <div class="form-group has-feedback row">
                                <label for="nombreEstado" class="col-12 control-label">Nombre de estado:</label>
                                <div class="col-12">
                                <input id="nombreEstado" type="text" class="form-control"  name="nombreEstado" 
                                value="{{old('nombreEstado')}}" placeholder="Nombre de estado" >
                                </div>
                            </div>
                            <div class="form-group has-feedback row">
                                <label for="descripcionEstado" class="col-12 control-label">Descripción de estado:</label>
                                <div class="col-12">
                                <input id="descripcionEstado" type="text" class="form-control"  name="descripcionEstado" 
                                value="{{old('descripcionEstado')}}" placeholder="Descripción de estado" >
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
                                            Guardar estado Icono
                                        </span>
                                    </i>
                                            Guardar estado
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
@extends('admin.layouts.index')
@section('title','Rubro')
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
                        Editando rubro: 
                        <div class="pull-right">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm float-right" data-toggle="tooltip" data-placement="left" title data-original-title="Regresar a lista de marcas">Regresar</a>
                        </div>
                    </div>
                </div>
                <x-errores class="mb-4" />
                <form action="{{route('rubro.update',$rubro)}}" method="POST">
                    @csrf
                    @method('put')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback row">
                                <label for="codigoPresupuestario" class="col-12 control-label">Codigo Presupuestario:</label>
                                <div class="col-12">
                                    <input value="{{old('codigoPresupuestario',$rubro->codigoPresupuestario)}}" id="codigoPresupuestario" type="text" class="form-control" name="codigoPresupuestario" placeholder="Codigo Presupuestario" required>
                                </div>
                            </div>
                            <div class="form-group has-feedback row">
                                <label for="estado_id" class="col-12 control-label">Estado:</label>
                                <div class="col-12">
                                    <select class="form-control" name="estado_id" id="estado_id" value="{{old('estado_id')}}">
                                        <option selected='true' disabled='disabled'>Seleccionar estado</option>
                                            @foreach( $estados as $item )
                                            <option value="{{ $item->id }}" @if ($rubro->estado_id == $item->id){{'selected'}} @endif >{{ $item->nombreEstado}}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group has-feedback row">
                                <label for="descripcionRubro" class="col-12 control-label">Descripcion:</label>
                                <div class="col-12">
                                    <input value="{{old('descripcionRubro',$rubro->descripcionRubro)}}" id="descripcionRubro" type="text" class="form-control" name="descripcionRubro" placeholder="Descripcion" required>
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
                                            Guardar rubro Icono
                                        </span>
                                    </i>
                                            Guardar rubro
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
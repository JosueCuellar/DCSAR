@extends('admin.layouts.index')
@section('title', 'Rubro')
@section('header')
    <div class="container">
        <div class="col-md-12">
            <h2>Nuevo rubro</h2>
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
                            Creando rubro:
                            <div class="pull-right">
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm float-right"
                                    data-toggle="tooltip" data-placement="left" title
                                    data-original-title="Regresar a lista de categorias">Regresar</a>
                            </div>
                        </div>
                    </div>
                    <x-errores class="mb-4" />
                    <form action="{{ route('rubro.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group has-feedback row">
                                        <label for="codigoPresupuestario" class="col-12 control-label">Codigo
                                            presupuestario:</label>
                                        <div class="col-12">
                                            <input id="n" type="text" class="form-control"
                                                name="codigoPresupuestario" 
                                                placeholder="Codigo presupuestario">
                                        </div>
                                    </div>                
                                    <div class="form-group has-feedback row">
                                        <label for="descripcionRubro" class="col-12 control-label">Descripción de
                                            rubro:</label>
                                        <div class="col-12">
                                            <input id="descripcionRubro" type="text" class="form-control"
                                                name="descripcionRubro" 
                                                placeholder="Descripción de rubro">
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

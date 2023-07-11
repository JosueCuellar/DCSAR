@extends('administrador.layouts.app')
@section('title', 'Unidad Organizativa')
@section('header')
    <div class="container">
        <div class="col-md-12">
            <h2>Nueva unidad organizativa</h2>
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
                            Creando unidad Organizativa:
                            <div class="pull-right">
                                <a href="{{ route('unidadOrganizativa.index') }}"
                                    class="btn btn-outline-secondary btn-sm float-right" data-toggle="tooltip"
                                    data-placement="left" title
                                    data-original-title="Regresar a lista de unidades organizativas">Regresar</a>
                            </div>
                        </div>
                    </div>
                    <x-errores class="mb-4" />
                    <form action="{{ route('unidadOrganizativa.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group has-feedback row">
                                        <label for="nombreUnidadOrganizativa" class="col-12 control-label">Nombre de
                                            unidad:</label>
                                        <div class="col-12">
                                            <input id="nombreUnidadOrganizativa" type="text" class="form-control"
                                                name="nombreUnidadOrganizativa"
                                                value="{{ old('nombreUnidadOrganizativa') }}"
                                                placeholder="Nombre de unidad">
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="descripUnidadOrganizativa" class="col-12 control-label">Decripción de
                                            unidad:</label>
                                        <div class="col-12">
                                            <input id="descripUnidadOrganizativa" type="text" class="form-control"
                                                name="descripUnidadOrganizativa"
                                                value="{{ old('descripUnidadOrganizativa') }}"
                                                placeholder="Decripción de unidad">
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
                                            Guardar unida organizativa
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

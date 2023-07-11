@extends('administrador.layouts.app')
@section('title', 'Estado')
@section('header')
    <div class="container">
        <div class="col-md-12">
            <h2>Editar estado</h2>
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
                            Editando estado:
                            <div class="pull-right">
                                <a href="{{ route('estado.index') }}" class="btn btn-outline-secondary btn-sm float-right"
                                    data-toggle="tooltip" data-placement="left" title
                                    data-original-title="Regresar a lista de marcas">Regresar</a>
                            </div>
                        </div>
                    </div>
                    <x-errores class="mb-4" />
                    <form action="{{ route('estado.update', $estado) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group has-feedback row">
                                        <label for="codigoEstado" class="col-12 control-label">Codigo de estado:</label>
                                        <div class="col-12">
                                            <input value="{{ old('codigoEstado', $estado->codigoEstado) }}"
                                                id="codigoEstado" type="text" class="form-control" name="codigoEstado"
                                                placeholder="Codigo de estado" required>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="nombreEstado" class="col-12 control-label">Nombre estado:</label>
                                        <div class="col-12">
                                            <input value="{{ old('nombreEstado', $estado->nombreEstado) }}"
                                                id="nombreEstado" type="text" class="form-control" name="nombreEstado"
                                                placeholder="Nombre de estado" required>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="descripcionEstado" class="col-12 control-label">Descripción de
                                            estado:</label>
                                        <div class="col-12">
                                            <input value="{{ old('descripcionEstado', $estado->descripcionEstado) }}"
                                                id="descripcionEstado" type="text" class="form-control"
                                                name="descripcionEstado" placeholder="Descripción de estado" required>
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
                                            Actualizar estado
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

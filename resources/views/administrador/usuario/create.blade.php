@extends('administrador.layouts.app')
@section('title', 'Usuario')
@section('header')
    <div class="container">
        <div class="col-md-12">
            <h2>Nuevo usuario</h2>
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
                            Creando usuario:
                            <div class="pull-right">
                                <a href="{{ route('usuario.index') }}" class="btn btn-outline-secondary btn-sm float-right"
                                    data-toggle="tooltip" data-placement="left" title
                                    data-original-title="Regresar a lista de categorias">Regresar</a>
                            </div>
                        </div>
                    </div>
                    <x-errores class="mb-4" />
                    <form action="{{ route('usuario.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group has-feedback row">
                                        <label for="name" class="col-12 control-label">Nombre de usuario:</label>
                                        <div class="col-12">
                                            <input id="name" type="text" class="form-control" name="name"
                                                placeholder="Nombre de usuario">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group has-feedback row">
                                        <label for="email" class="col-12 control-label">Email:</label>
                                        <div class="col-12">
                                            <input id="email" type="email" class="form-control" name="email"
                                                placeholder="Email">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group has-feedback row">
                                        <label for="password" class="col-12 control-label">Contraseña</label>
                                        <div class="col-12">
                                            <input id="password" type="password" class="form-control" name="password">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group has-feedback row">
                                        <label for="password_confirmation" class="col-12 control-label">Confirmar
                                            contraseña:</label>
                                        <div class="col-12">
                                            <input id="password_confirmation" type="password" class="form-control"
                                                name="password_confirmation">
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
                                            Guardar usuario
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

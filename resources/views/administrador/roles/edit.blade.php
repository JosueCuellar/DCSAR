@extends('administrador.layouts.app')
@section('title', 'Rol')
@section('header')
    <div class="container">
        <div class="col-md-12">
            <h2>Editar rol</h2>
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
                            Editando rol:
                            <div class="pull-right">
                                <a href="{{ route('rol.index') }}" class="btn btn-outline-secondary btn-sm float-right"
                                    data-toggle="tooltip" data-placement="left" title
                                    data-original-title="Regresar a lista de rols">Regresar</a>
                            </div>
                        </div>
                    </div>
                    <x-errores class="mb-4" />
                    <form action="{{ route('rol.update', $rol) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="row">                                
																<div class="col-md-12">
																	<div class="form-group has-feedback row">
																			<label for="name" class="col-12 control-label">Nombre de rol:</label>
																			<div class="col-12">
																					<input value="{{ $rol->name }}" id="name" type="text" class="form-control" name="name"
																							placeholder="Nombre de rol">
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
                                            Actualizar rol
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

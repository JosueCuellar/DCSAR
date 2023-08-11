@extends('layoutsGeneral.admin.layouts.index')
@section('title', 'Requisicion producto')
@section('header')
    <div class="container">
        <div class="col-md-12">
            <h2>Editar requisicion de producto</h2>
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
                            Editando requisicion:
                            <div class="pull-right">
                                <a href="{{ route('requisicionProducto.index') }}"
                                    class="btn btn-outline-secondary btn-sm float-right" data-toggle="tooltip"
                                    data-placement="left" title
                                    data-original-title="Regresar a lista de marcas">Regresar</a>
                            </div>
                        </div>
                    </div>
                    <x-errores class="mb-4" />
                    <form action="{{ route('requisicionProducto.update', $requisicionProducto) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group has-feedback row">
                                        <label for="fechaRequisicion" class="col-12 control-label">Fecha de
                                            requisición:</label>
                                        <div class="col-12">
                                            <input value="{{ $requisicionProducto->fechaRequisicion }}"
                                                id="fechaRequisicion" type="datetime-local" class="form-control"
                                                name="fechaRequisicion" required>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="descripRubro" class="col-12 control-label">Descripción:</label>
                                        <div class="col-12">
                                            <input value="{{ $requisicionProducto->descripcion }}" id="descripcion"
                                                type="text" class="form-control" name="descripcion"
                                                placeholder="Descripción" required>
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
                                            Actualizar registro
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

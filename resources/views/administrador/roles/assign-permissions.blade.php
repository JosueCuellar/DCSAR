@extends('administrador.layouts.app')
@section('title', 'Usuarios')
@section('header')
    <div class="container">
        <div class="col-md-12">
            <h2>Editar usuario</h2>
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
                            Editando usuario:
                            <div class="pull-right">
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm float-right"
                                    data-toggle="tooltip" data-placement="left" title
                                    data-original-title="Regresar a lista de usuarios">Regresar</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <x-errores class="mb-4" />
                        <form action="{{ route('roles.assign-permissions', $role) }}" method="POST">
                            @csrf
                          <div class="row">
                            @foreach ($permissions as $permission)
                            <div class="col-2">
                                <div class="form-check bg-dark">
                                    <input type="checkbox" class="form-check-input" name="permissions[]"
                                        value="{{ $permission->id }}"
                                        {{ $role->hasPermissionTo($permission) ? 'checked' : '' }}>
                                    <label>{{ $permission->name }}</label>
                                </div>
                                <br>
                            </div>
                        @endforeach
                          </div>
                            <button type="submit" class="btn btn-success">Asignar permisos</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

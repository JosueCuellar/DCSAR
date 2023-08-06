@extends('layoutsGeneral.administrador.layouts.app')
@section('title', 'Administrador')
@section('header')
    <div class="container">
        <div class="col-md-12">
            <h2 class="text-center">Panel de administrador</h2>
        </div>
    </div>
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            @can('Ver panel admin')
                <h2>Bienvenido Administrador</h2>
                <br>
                <h5 class="text-bold">Accesos directos</h5>
                <div class="row p-2">
                    <div class="col-lg-3 col-6">
                        <div class="text-white small-box" style="background-color: #003f5c">
                            <div class="inner">
                                <h5>Gestion Usuarios</h5>
                                <p>Usuarios</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag">
                                    <ion-icon name="people-outline"></ion-icon>
                                </i>
                            </div>
                            <a href="{{ asset('usuario') }}" class="small-box-footer">Ver <i
                                    class="fas fa-external-link-square-alt"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="text-white small-box" style="background-color: #3e8e41">
                            <div class="inner">
                                <h5>Agregar Permisos a Rol</h5>
                                <p>Permisos a Rol</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag">
                                    <ion-icon name="apps-outline"></ion-icon>
                                </i>
                            </div>
                            <a href="{{ asset('rolesAssign') }}" class="small-box-footer">Ver <i
                                    class="fas fa-external-link-square-alt"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="text-white small-box" style="background-color: #e63946 ">
                            <div class="inner">
                                <h5>Gestion de Roles</h5>
                                <p>Roles</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag">
                                    <ion-icon name="accessibility-outline"></ion-icon>
                                </i>
                            </div>
                            <a href="{{ asset('rol') }}" class="small-box-footer">Ver <i
                                    class="fas fa-external-link-square-alt"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="text-white small-box" style="background-color: #dd8b26 ">
                            <div class="inner">
                                <h5>Gestion U.O</h5>
                                <p>Unidades Organizativas</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag">
                                    <ion-icon name="business-outline"></ion-icon>
                                </i>
                            </div>
                            <a href="{{ asset('unidadOrganizativa') }}" class="small-box-footer">Ver <i
                                    class="fas fa-external-link-square-alt"></i></a>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    </div>
@endsection

@extends('admin.layouts.index')
@section('title', 'Reportes')
@section('header')
    <div class="col-md-12">
        <h2>Reportes</h2>
    </div>
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <h5 class="font-italic">Reportes Cierre Mensuales</h5>
            <div class="row p-2">
                <div class="col-lg-4 col-6">
                    <div class="card text-center shadow">
                        <div class="card-header">
                            <b>REPORTE TOTAL INGRESOS</b>
                        </div>
                        <div class="card-footer">
                            <p class="card-text">Total de ingresos mensuales</p>
                            <button type="submit" data-toggle="modal" data-target="#modalTotalIngresos"
                                class="btn btn-secondary btn-block">Generar reporte</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="card text-center shadow">
                        <div class="card-header">
                            <b>REPORTE TOTAL SALIDAS</b>
                        </div>
                        <div class="card-footer">
                            <p class="card-text">Total de salidas mensuales</p>
                            <button type="submit" data-toggle="modal" data-target="#modalTotalSalidas"
                                class="btn btn-secondary btn-block">Generar reporte</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="card text-center shadow">
                        <div class="card-header">
                            <b>REPORTE DE LISTADO ARTICULO DE INVENTARIO</b>
                        </div>
                        <div class="card-footer">
                            <p class="card-text">Listado de articulos en el inventario</p>
                            <button type="submit" data-toggle="modal" data-target="#modalTotalIngresos"
                                class="btn btn-secondary btn-block">Generar reporte</button>
                        </div>
                    </div>
                </div>
            </div>
            <h5 class="font-italic">Reportes Generales</h5>
            <div class="row p-2">
                <div class="col-lg-4 col-6">
                    <div class="card text-center shadow">
                        <div class="card-header">
                            <b>REPORTE TOTAL INGRESOS</b>
                        </div>
                        <div class="card-footer">
                            <p class="card-text">Total de ingresos mensuales</p>
                            <button type="submit" data-toggle="modal" data-target="#modalTotalIngresos"
                                class="btn btn-secondary btn-block">Generar reporte</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="card text-center shadow">
                        <div class="card-header">
                            <b>REPORTE TOTAL SALIDAS</b>
                        </div>
                        <div class="card-footer">
                            <p class="card-text">Total de salidas mensuales</p>
                            <button type="submit" data-toggle="modal" data-target="#modalTotalIngresos"
                                class="btn btn-secondary btn-block">Generar reporte</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="card text-center shadow">
                        <div class="card-header">
                            <b>REPORTE DE LISTADO ARTICULO DE INVENTARIO</b>
                        </div>
                        <div class="card-footer">
                            <p class="card-text">Listado de articulos en el inventario</p>
                            <button type="submit" data-toggle="modal" data-target="#modalTotalIngresos"
                                class="btn btn-secondary btn-block">Generar reporte</button>
                        </div>
                    </div>
                </div>
            </div>
            <h5 class="font-italic">Reportes Generales</h5>
            <div class="row p-2">
                <div class="col-lg-4 col-6">
                    <div class="card text-center shadow">
                        <div class="card-header">
                            <b>REPORTE TOTAL INGRESOS</b>
                        </div>
                        <div class="card-footer">
                            <p class="card-text">Total de ingresos mensuales</p>
                            <button type="submit" data-toggle="modal" data-target="#modalTotalIngresos"
                                class="btn btn-secondary btn-block">Generar reporte</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="card text-center shadow">
                        <div class="card-header">
                            <b>REPORTE TOTAL SALIDAS</b>
                        </div>
                        <div class="card-footer">
                            <p class="card-text">Total de salidas mensuales</p>
                            <button type="submit" data-toggle="modal" data-target="#modalTotalIngresos"
                                class="btn btn-secondary btn-block">Generar reporte</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="card text-center shadow">
                        <div class="card-header">
                            <b>REPORTE DE LISTADO ARTICULO DE INVENTARIO</b>
                        </div>
                        <div class="card-footer">
                            <p class="card-text">Listado de articulos en el inventario</p>
                            <button type="submit" data-toggle="modal" data-target="#modalTotalIngresos"
                                class="btn btn-secondary btn-block">Generar reporte</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Reporte total ingresos --}}
    <div class="modal fade" id="modalTotalIngresos" style="display: none;" aria-hidden="true">
        <form method="POST" class="form-horizontal" action="" target="_blank">
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ingrese el mes y el año para realizar el reporte</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="descripcion" class="col-sm-2 col-form-label">Fecha</label>
                            <div class="col-sm-10">
                                <input type="month" class="form-control" id="fechaInput" name="fechaInput">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <a class="btn btn-warning" onclick="$(this).closest('form').submit();">Generar reporte</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    {{-- Reporte total salidas --}}
    <div class="modal fade" id="modalTotalSalidas" style="display: none;" aria-hidden="true">
        <form method="POST" class="form-horizontal" action="" target="_blank">
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ingrese el mes y el año para realizar el reporte</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="descripcion" class="col-sm-2 col-form-label">Fecha</label>
                            <div class="col-sm-10">
                                <input type="month" class="form-control" id="fechaInput" name="fechaInput">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <a class="btn btn-warning" onclick="$(this).closest('form').submit();">Generar reporte</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js_datatable')
    <script>
        $('#modalTotalIngresos').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var modal = $(this)
            modal.find('form').attr('action', '{{ asset('/reporte/totalIngresoMesPost/') }}');
        })
        $('#modalTotalSalidas').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var modal = $(this)
            modal.find('form').attr('action', '{{ asset('/reporte/totalSalidaMesPost/') }}');
        })
    </script>
@endsection

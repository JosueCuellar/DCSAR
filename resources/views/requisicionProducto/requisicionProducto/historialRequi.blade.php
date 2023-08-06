<?php $includeScript = false; ?>
@extends('layoutsGeneral.admin.layouts.index')
@section('title', 'Historial requisiciones')
@section('header')
    <div class="col-md-12">
        <h2>Historial de requisiciones</h2>
    </div>
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-secondary card-outline card-outline-tabs">
                        <div class="card-header p-0 pt-1">
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                {{-- Enviadas --}}
                                <div class="tab-pane fade active show" id="enviadas" role="tabpanel"
                                    aria-labelledby="enviadas-tab">
                                    <table class="table table-sm table-striped text-center" id="dataTable11" width="100%"
                                        cellspacing="0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Fecha</th>
                                                <th scope="col">Numero correlativo</th>
                                                <th scope="col">Estado</th>
                                                <th scope="col">Unidad Organizativa</th>
                                                <th scope="col">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($requisicionRecibidas as $item)
                                                <td scope="row"> <?php
                                                $date = new DateTime($item->fechaRequisicion);
                                                echo $date->format('Y-m-d');
                                                ?></td>
                                                <td scope="row">{{ $item->nCorrelativo }}</td>

                                                <td><span class="badge text-white"
                                                        style="background-color: orange">{{ $item->estado->nombreEstado }}</span>
                                                </td>
                                                <td scope="row">
                                                    {{ $item->user->unidadOrganizativa->nombreUnidadOrganizativa ?? '' }}
                                                </td>
                                                <td>
                                                    <div>
                                                        <button
                                                            onclick="location.href = '{{ asset('/requisicionProducto/detalleRevision/') }}/{{ $item->id }}';"
                                                            type="button" class="btn btn-sm btn-primary"><i
                                                                class="fa fa-eye"></i>
                                                            Detalles</button>
                                                        <button
                                                            onclick="location.href = '{{ asset('/requisicionProducto/pdf/comprobante/') }}/{{ $item->id }}';"
                                                            type="button" class="btn btn-sm btn-secondary"><i
                                                                class="fa fa-download"></i> Comprobante</button>
                                                        @if (auth()->user()->hasRole('Gerente Unidad Organizativa') ||
                                                                auth()->user()->hasRole('Super Administrador'))
                                                            <button
                                                                onclick="location.href = '{{ asset('/requisicionProducto/pdf/aprobar/') }}/{{ $item->id }}';"
                                                                type="button" class="btn btn-sm btn-success"><i
                                                                    class="fa fa-download"></i> Autorizacion</button>
                                                        @endif
                                                    </div>
                                                </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('js_datatable')
    <script>
        $(document).ready(function() {
            $('a[data-toggle="pill"]').on('shown.bs.tab', function(e) {
                $.fn.dataTable.tables({
                    visible: true,
                    api: true
                }).columns.adjust();
            });
            $(document).ready(function() {
                $('#dataTable11').DataTable({
                    buttons: ['searchBuilder'],
                    dom: 'Bfrtip',
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    },
                    "autoWidth": false,
                    "responsive": true,
                });
            });
        });
    </script>
@endsection

@extends('layoutsGeneral.admin.layouts.index')
@section('title', 'Detalle de Ingreso')
@section('header')
    <script src="{{ asset('dependencias/js/unpkg.com_axios@1.4.0_dist_axios.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('dependencias/js/unpkg.com_dropzone@6.0.0-beta.1_dist_dropzone.css') }}">
    <script src="{{ asset('dependencias/js/unpkg.com_dropzone@6.0.0-beta.1_dist_dropzone-min.js') }}"></script>
    <div class="col-md-12">
        <h2>Detalles del ingreso de insumos</h2>
    </div>
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-post" id="post_card">
                        <div class="card-header">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                Detalle del ingreso
                                <div class="pull-right">
                                    <a href="{{ route('recepcionCompra.consultar') }}" class="btn btn-outline-secondary btn-sm float-right"
                                        data-toggle="tooltip" data-placement="left" title
                                        data-original-title="Regresar a lista">Regresar</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable7" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Producto</th>
                                            <th scope="col">Cantidad</th>
                                            <th scope="col">Medida</th>
                                            <th scope="col">Descripcion</th>
                                            <th scope="col">Precio unidad</th>
                                            <th scope="col">Sub-Total</th>
                                            {{-- <th scope="col">Acciones</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($detalleCompra as $itemDet)
                                            <tr>
                                                <th scope="row">{{ $itemDet->producto->codProducto }}</th>
                                                <td>{{ $itemDet->cantidadIngreso }}</td>
                                                <td>{{ $itemDet->producto->medida->nombreMedida }}</td>
                                                <td>{{ $itemDet->producto->descripcion }}</td>
                                                <td>${{ number_format($itemDet->precioUnidad, 2) }}</td>
                                                <td>${{ number_format($itemDet->total, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="thead-light">
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col">Total</th>
                                        <th scope="col">${{ number_format($totalFinal, 2) }}</th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
											<div class="list-group">
													<a href="#" class="col-md-12 list-group-item bg-dark">
															<strong>Documentos adjuntos a la compra</strong>
													</a>
													@foreach ($documentos as $item)
													<div class="col-md-12 list-group-item list-group-item-action list-group-item-light">
															<div class="d-flex justify-content-between">
																	<a href="{{ route('leer.documento', $item->id) }}" target="_blank">{{ $item->nombreDocumento }}</a>
																	<form action="{{ route('deleteEdit.documento', $item->id) }}" method="GET">
																			@csrf
																			@method('GET')
																			<button type="submit" class="btn btn-danger">Eliminar</button>
																	</form>
															</div>
													</div>
											@endforeach
											
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
            $('#dataTable7').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                "paging": false,
                "ordering": false,
                "info": false,
                "autoWidth": false,
                "responsive": true,
                "columnDefs": [{
                    "responsivePriority": 10001,
                    "targets": 1
                }]
            });
        });
    </script>
@endsection

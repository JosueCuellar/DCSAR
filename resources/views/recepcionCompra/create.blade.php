@extends('admin.layouts.index')
@section('title', 'Recepcion Compra')
@section('content')

    <div class="row py-lg-2">
        <div class="col-md-6">
            <h2>Requisiciones</h2>
        </div>
    </div>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button"
                role="tab" aria-controls="profile-tab-pane" aria-selected="true">Registrar
                compra</button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button"
                role="tab" aria-controls="home-tab-pane" aria-selected="false">Consultar
                compras</button>
        </li>

    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"tabindex="0">

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable15" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">Proveedor</th>
                                <th scope="col"># Orden de Compra</th>
                                <th scope="col"># Presupuestario</th>
                                <th scope="col"># Compromiso</th>
                                <th scope="col">Acta Recepcion</th>
                                <th scope="col">Codigo Factura</th>
                                <th scope="col">Ver</th>

                            </tr>
                        </thead>
                        <tfoot class="thead-light">
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">Proveedor</th>
                                <th scope="col"># Orden de Compra</th>
                                <th scope="col"># Presupuestario</th>
                                <th scope="col"># Compromiso</th>
                                <th scope="col">Acta Recepcion</th>
                                <th scope="col">Codigo Factura</th>
                                <th scope="col">Ver</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($recepcionCompras as $item)
                                <tr>
                                    <th scope="row">{{ $item->id }}</th>
                                    <td>{{ $item->proveedor->nombreComercial}}</td>
                                    <td>{{ $item->nOrdenCompra }}</td>
                                    <td>{{ $item->nPresupuestario }}</td>
                                    <td>{{ $item->nCompromiso }}</td>
                                    <td>{{ $item->actaRecepcion }}</td>
                                    <td>{{ $item->codigoFactura }}</td>
                                    <td>
                                        <a href="{{ route('detalleCompra.detalle', $item->id) }}"><i
                                                class="fa fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade show active" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
            <x-errores class="mb-4" />
            <form action="{{ route('recepcionCompra.store') }}" method='POST'>
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback row">
                                <label for="proveedor_id" class="col-12 control-label">Seleccionar proveedor</label>
                                <div class="col-12">
                                    <select class="proveedor form-control" name="proveedor_id" id="proveedor_id">
                                        <option selected='true' disabled='disabled'>Seleccionar proveedor</option>
                                        @foreach ($proveedores as $item)
                                            <option value="{{ $item->id }}">{{ $item->nombreComercial }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group has-feedback row">
                                <label for="nOrdenCompra" class="col-12 control-label">Numero de Orden de Compra:</label>
                                <div class="col-12">
                                    <input id="nOrdenCompra" type="text" class="form-control" name="nOrdenCompra"
                                        value="{{ old('nOrdenCompra') }}" placeholder="Numero de orden de compra">
                                </div>
                            </div>

                            <div class="form-group has-feedback row">
                                <label for="nPresupuestario" class="col-12 control-label">Numero Presupuestario:</label>
                                <div class="col-12">
                                    <input id="nPresupuestario" type="text" class="form-control" name="nPresupuestario"
                                        value="{{ old('nPresupuestario') }}" placeholder="Numero presupuestario">
                                </div>
                            </div>

                            <div class="form-group has-feedback row">
                                <label for="nCompromiso" class="col-12 control-label">Numero Compromiso:</label>
                                <div class="col-12">
                                    <input id="nCompromiso" type="text" class="form-control" name="nCompromiso"
                                        value="{{ old('nCompromiso') }}" placeholder="Numero compromiso">
                                </div>
                            </div>

                            <div class="form-group has-feedback row">
                                <label for="actaRecepcion" class="col-12 control-label">Acta de Recepcion:</label>
                                <div class="col-12">
                                    <input id="actaRecepcion" type="text" class="form-control" name="actaRecepcion"
                                        value="{{ old('actaRecepcion') }}" placeholder="Acta de recepcion">
                                </div>
                            </div>

                            <div class="form-group has-feedback row">
                                <label for="codigoFactura" class="col-12 control-label">Codigo Factura:</label>
                                <div class="col-12">
                                    <input id="codigoFactura" type="text" class="form-control" name="codigoFactura"
                                        value="{{ old('codigoFactura') }}" placeholder="Codigo Factura">
                                </div>
                            </div>

                            <div class="form-group has-feedback row">
                                <label for="fechaIngreso" class="col-12 control-label">Fecha del ingreso:</label>
                                <div class="col-12">
                                    <input id='fechaIngreso' type='text' value="{{ date('d-m-Y') }}"
                                        class='form-control' name='fechaIngreso' disabled placeholder='Fecha'>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <span data-toggle="tooltip" title data-original-title="Guardar">
                                <button type="submit" class="btn btn-success btn-lg btn-block" id="guardar"
                                    value="Guardar" name="action">
                                    <i class="fa fa-save fa-fw">
                                        <span class="sr-only">
                                            Guardar Icono
                                        </span>
                                    </i>
                                    Guardar
                                </button>
                            </span>
                        </div>
                    </div>
            </form>

        </div>
    </div>

    </div>
@section('js_datatable')

    <script>
        $(document).ready(function() {
            $('#dataTable15').DataTable({
                dom: '<"top"i>rt<"bottom"flp><"clear">',
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });
        });
    </script>

@endsection
@endsection

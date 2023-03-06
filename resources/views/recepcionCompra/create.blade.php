@extends('admin.layouts.index')
@section('title', 'Recepción Compra')
@section('header')
    <div class="container">
        <div class="col-md-12">
            <h2>Recepción de ingreso de productos</h2>
        </div>
    </div>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-post" id="post_card">
                    {{-- <div class="tab-pane fade show" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"tabindex="0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable15" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Proveedor</th>
                                        <th scope="col"># Orden de Compra</th>
                                        <th scope="col"># Presupuestario</th>
                                        <th scope="col"># Compromiso</th>
                                        <th scope="col">Acta Recepción</th>
                                        <th scope="col">Codigo Factura</th>
                                        <th scope="col">Ver</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recepcionCompras as $item)
                                        <tr>
                                            <th scope="row">{{ $item->id }}</th>
                                            <td>{{ $item->proveedor->nombreComercial }}</td>
                                            <td>{{ $item->nOrdenCompra }}</td>
                                            <td>{{ $item->nPresupuestario }}</td>
                                            <td>{{ $item->nCompromiso }}</td>
                                            <td>{{ $item->actaRecepción }}</td>
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
                </div> --}}
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            Nueva Recepción de productos:
                            <div class="pull-right">
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm float-right"
                                    data-toggle="tooltip" data-placement="left" title
                                    data-original-title="Regresar a lista de categorias">Regresar</a>
                            </div>
                        </div>
                    </div>
                    <x-errores class="mb-4" />
                    <form action="{{ route('recepcionCompra.store') }}" method='POST' enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group has-feedback row">
                                        <label for="proveedor_id" class="col-12 control-label">Seleccionar proveedor</label>
                                        <div class="col-12">
                                            <select class="proveedor form-control" name="proveedor_id" id="proveedor_id">
                                                <option selected='true' disabled='disabled'>Seleccionar proveedor</option>
                                                @foreach ($proveedores as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nombreComercial }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="nOrdenCompra" class="col-12 control-label">Orden de
                                            Compra:</label>
                                        <div class="col-12">
                                            <input id="nOrdenCompra" type="text" class="form-control" name="nOrdenCompra"
                                                value="{{ old('nOrdenCompra') }}" placeholder="Número de orden de compra">
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="actaRecepcion" class="col-12 control-label">Acta de Recepción:</label>
                                        <div class="col-12">
                                            <input id="actaRecepcion" type="text" class="form-control"
                                                name="actaRecepcion" value="{{ old('actaRecepcion') }}"
                                                placeholder="Acta de Recepción">
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="codigoFactura" class="col-12 control-label">Codigo Factura:</label>
                                        <div class="col-12">
                                            <input id="codigoFactura" type="text" class="form-control"
                                                name="codigoFactura" value="{{ old('codigoFactura') }}"
                                                placeholder="Codigo Factura">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group has-feedback row">
                                        <label for="nPresupuestario" class="col-12 control-label">Número Compromiso
                                            Presupuestario:</label>
                                        <div class="col-12">
                                            <input id="nPresupuestario" type="text" class="form-control"
                                                name="nPresupuestario" value="{{ old('nPresupuestario') }}"
                                                placeholder="Número presupuestario">
                                        </div>
                                    </div>
                                    {{-- <div class="form-group has-feedback row">
                                        <label for="nCompromiso" class="col-12 control-label">Número Compromiso:</label>
                                        <div class="col-12">
                                            <input id="nCompromiso" type="text" class="form-control" name="nCompromiso"
                                                value="{{ old('nCompromiso') }}" placeholder="Número compromiso">
                                        </div>
                                    </div> --}}
                                    <div class="form-group has-feedback row">
                                        <label for="fechaIngreso" class="col-12 control-label">Fecha del ingreso:</label>
                                        <div class="col-12">
                                            <input id='fechaIngreso' type='text' value="{{ date('d-m-Y h:i:s') }}"
                                                class='form-control' name='fechaIngreso' disabled placeholder='Fecha'>
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
                                            Guardar ingreso
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
@section('js_datatable')
@endsection
@section('js_imagen')
<script>
    $(document).ready(function(e) {
        $('#proveedor_id').select2({
            language: {
                noResults: function() {
                    return "No hay resultado";
                },
                searching: function() {
                    return "Buscando..";
                }
            }
        });
    });
    $("#proveedor_id").select2()
</script>
@endsection

@endsection

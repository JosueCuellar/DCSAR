@extends('admin.layouts.index')
@section('title', 'Recepcion compra')
@section('header')
    <div class="container">
        <div class="col-md-12">
            <h2>Editar recepcion compra</h2>
        </div>
    </div>
@endsection
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-post" id="post_card">

                    <x-errores class="mb-4" />
                    <form action="{{ route('recepcionCompra.updateCompra', $recepcionCompra->id) }}" method='POST'
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <button type="submit" class="btn btn-success" value="Guardar" name="action">
                                    Guardar cambios
                                </button>
                                <div class="pull-right">
                                    <a href="{{ route('recepcionCompra.consultar')}}" class="btn btn-outline-secondary btn-sm float-right"
                                        data-toggle="tooltip" data-placement="left" title
                                        data-original-title="Regresar a lista de marcas">Regresar</a>
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group has-feedback row">
                                        <label for="proveedor_id" class="col-12 control-label">Seleccionar proveedor</label>
                                        <div class="col-12">
                                            <select class="proveedor form-control" name="proveedor_id" id="proveedor_id">
                                                @foreach ($proveedores as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $item->id == $recepcionCompra->proveedor_id ? 'selected' : '' }}>
                                                        {{ $item->nombreComercial }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="nOrdenCompra" class="col-12 control-label">Orden de Compra:</label>
                                        <div class="col-12">
                                            <input id="nOrdenCompra" type="text" class="form-control" name="nOrdenCompra"
                                                placeholder="Número de orden de compra"
                                                value="{{ $recepcionCompra->nOrdenCompra }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group has-feedback row">
                                        <label for="nPresupuestario" class="col-12 control-label">Número Compromiso
                                            Presupuestario:</label>
                                        <div class="col-12">
                                            <input id="nPresupuestario" type="number" class="form-control"
                                                name="nPresupuestario" placeholder="Número presupuestario"
                                                value="{{ $recepcionCompra->nPresupuestario }}">
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="codigoFactura" class="col-12 control-label">Codigo Factura:</label>
                                        <div class="col-12">
                                            <input id="codigoFactura" type="number" class="form-control"
                                                name="codigoFactura" placeholder="Codigo Factura"
                                                value="{{ $recepcionCompra->codigoFactura }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group has-feedback row">
                                        <label for="fechaVenc" class="col-12 control-label">Fecha del ingreso:</label>
                                        <div class="col-12">
                                            <input id='fecha' value="{{ $recepcionCompra->fechaIngreso }}"
                                                type='date' class='form-control' name='fecha'
                                                placeholder='Fecha de vencimiento'>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        document.getElementById('nPresupuestario').addEventListener('input', function(e) {
            if (e.target.value.includes('.')) {
                e.target.value = e.target.value.replace('.', '');
            }
            e.target.value = e.target.value.replace(/\./g, '');
        });
    </script>
    <script>
        document.getElementById('codigoFactura').addEventListener('input', function(e) {
            if (e.target.value.includes('.')) {
                e.target.value = e.target.value.replace('.', '');
            }
            e.target.value = e.target.value.replace(/\./g, '');
        });
    </script>
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

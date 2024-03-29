@extends('bar.layouts.bar')
@section('title', 'Recepción Ingreso')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-post" id="post_card">
                    <x-errores class="mb-4" />
                    <form action="{{ route('recepcionCompra.store') }}" method='POST' enctype="multipart/form-data">
                        @csrf
                        <div class="card-header">
                            <button type="submit" class="btn btn-success" value="Guardar" name="action">
                                Siguiente paso
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
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
                                            compra:</label>
                                        <div class="col-12">
                                            <input id="nOrdenCompra" type="text" class="form-control" name="nOrdenCompra"
                                                placeholder="Número de orden de compra">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group has-feedback row">
                                        <label for="nPresupuestario" class="col-12 control-label">Número compromiso
                                            presupuestario:</label>
                                        <div class="col-12">
                                            <input id="nPresupuestario" type="text" class="form-control"
                                                name="nPresupuestario" placeholder="Número presupuestario">
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="codigoFactura" class="col-12 control-label">Codigo factura:</label>
                                        <div class="col-12">
                                            <input id="codigoFactura" type="number" class="form-control"
                                                name="codigoFactura" placeholder="Codigo Factura" value="">
                                        </div>
                                    </div>

                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group has-feedback row">
                                        <label for="fechaVenc" class="col-12 control-label">Fecha del ingreso:</label>
                                        <div class="col-12">
                                            <input id='fecha' value="{{ old('fecha') }}" type='date'
                                                class='form-control' name='fecha' max="{{ date('Y-m-d') }}"
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

@extends('bar.layouts.bar')
@section('title', 'Recepción Compra')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-post" id="post_card">
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
                                                placeholder="Número de orden de compra">
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="codigoFactura" class="col-12 control-label">Codigo Factura:</label>
                                        <div class="col-12">
                                            <input id="codigoFactura" type="text" class="form-control"
                                                name="codigoFactura" placeholder="Codigo Factura">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group has-feedback row">
                                        <label for="nPresupuestario" class="col-12 control-label">Número Compromiso
                                            Presupuestario:</label>
                                        <div class="col-12">
                                            <input id="nPresupuestario" type="text" class="form-control"
                                                name="nPresupuestario" placeholder="Número presupuestario">
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="fechaIngreso" class="col-12 control-label">Fecha del ingreso:</label>
                                        <div class="col-12">
                                            <input id='fechaIngreso' type='date' value="{{ date('d-m-Y')}}"
                                                class='form-control' name='fechaIngreso' placeholder='Fecha'>
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
                                            Siguiente
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
@section('js')
    {{-- <script>
        const beforeUnloadListener = (event) => {
            event.preventDefault();
            return event.returnValue = "¿Está seguro de que desea salir de la página?";
        };


        const nameInput = document.querySelector("#codigoFactura");

        nameInput.addEventListener("input", (event) => {
            if (event.target.value !== "") {
                addEventListener("beforeunload", beforeUnloadListener, {
                    capture: true
                });
            } else {
                removeEventListener("beforeunload", beforeUnloadListener, {
                    capture: true
                });
            }
        });
    </script> --}}
@endsection

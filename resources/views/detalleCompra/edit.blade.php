@extends('admin.layouts.index')
@section('title', 'Recepción compra')
@section('header')
    <div class="container">
        <div class="col-md-12">
            <h2>Editar detalle de compra</h2>
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
                            Editando detalle:
                            <div class="pull-right">
                                <a href="{{ route('recepcionCompra.detalle', $recepcionCompra) }}"
                                    class="btn btn-outline-secondary btn-sm float-right" data-toggle="tooltip"
                                    data-placement="left" title
                                    data-original-title="Regresar a lista de marcas">Regresar</a>
                            </div>
                        </div>
                    </div>
                    <x-errores class="mb-4" />
                    <form
                        @if ($recepcionCompra->estado === 1) action="{{ route('detalleCompra.updateCompra', ['recepcionCompra' => $recepcionCompra->id, 'detalleCompra' => $detalleCompra->id]) }}"
										@else
											action="{{ route('detalleCompra.update', ['recepcionCompra' => $recepcionCompra->id, 'detalleCompra' => $detalleCompra->id]) }}" @endif
                        method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group has-feedback row" style="display :none;">
                                        <label for="producto_id" class="col-12 control-label">Seleccionar
                                            producto:</label>
                                        <div class="col-12">
                                            <input type="text" name="producto_id" id="producto_id"
                                                value="{{ $detalleCompra->producto_id }}">
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="cantidadIngreso" class="col-12 control-label">Cantidad
                                            ingresada:</label>
                                        <div class="col-12">
                                            <input id='cantidadIngreso' type='number'
                                                value="{{ old('cantidadIngreso', $detalleCompra->cantidadIngreso) }}"
                                                min='1' class='form-control' name='cantidadIngreso'
                                                placeholder='Cantidad ingresada'>
                                        </div>
                                        @error('cantidadIngreso')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="precioUnidad" class="col-12 control-label">Precio de unidad($):</label>
                                        <div class="col-12">
                                            <input id='precioUnidad' type='number' min='0.01'
                                                value="{{ old('precioUnidad', $detalleCompra->precioUnidad) }}"
                                                step='.01' class='form-control' name='precioUnidad'
                                                placeholder='$00.00'>
                                        </div>
                                        @error('precioUnidad')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if (!is_null($detalleCompra->fechaVencimiento))
                                        <div class="form-group has-feedback row">
                                            <label for="fechaVenc" class="col-12 control-label">Fecha de
                                                vencimiento:</label>
                                            <div class="col-12">
                                                <input id='fechaVenc'
                                                    value="{{ old('fechaVenc', $detalleCompra->fechaVencimiento) }}"
                                                    type='date' min="{{ date('Y-m-d') }}" class='form-control'
                                                    name='fechaVenc' placeholder='Fecha de vencimiento'>
                                            </div>
                                            @error('fechaVenc')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <script>
                            document.getElementById('precioUnidad').addEventListener('input', function(e) {
                                console.log('Input event triggered:', e.target.value);

                            });
                        </script>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-12">
                                    <span data-toggle="tooltip" title data-original-title="Guardar cambios realizados">
                                        <button type="submit" class="btn btn-success" value="Guardar" name="action">
                                            <ion-icon name="save-outline"></ion-icon>
                                            Actualizar detalle de compra
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
    <script>
        document.getElementById('cantidadIngreso').addEventListener('input', function(e) {
            if (e.target.value.includes('.')) {
                e.target.value = e.target.value.replace('.', '');
            }
            e.target.value = e.target.value.replace('-', '');
            e.target.value = e.target.value.replace(/\./g, '');
        });
    </script>
@endsection

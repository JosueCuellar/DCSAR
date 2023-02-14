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
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm float-right"
                                    data-toggle="tooltip" data-placement="left" title
                                    data-original-title="Regresar a lista de marcas">Regresar</a>
                            </div>
                        </div>
                    </div>
                    <x-errores class="mb-4" />
                    <form
                        action="{{ route('detalleCompra.update', ['recepcionCompra' => $recepcionCompra->id, 'detalleCompra' => $detalleCompra->id]) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group has-feedback row">
                                    <label for="producto_id" class="col-12 control-label">Seleccionar
                                        producto:</label>
                                    <div class="col-12">
                                        <select class="form-control" name="producto_id" id="producto_id">
                                            <option selected disabled='disabled'>Seleccionar producto</option>
                                            @foreach ($productos as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($detalleCompra->producto_id == $item->id) {{ 'selected' }} @endif>
                                                {{ $item->cod_producto }}</option>
                                        @endforeach                                    
                                        </select>
                                        @error('producto_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group has-feedback row">
                                    <label for="cantidadIngreso" class="col-12 control-label">Cantidad
                                        ingresada:</label>
                                    <div class="col-12">
                                        <input id='cantidadIngreso' type='number'
                                            value="{{ old('cantidadIngreso', $detalleCompra->cantidadIngreso ) }}" min='1' class='form-control'
                                            name='cantidadIngreso' placeholder='Cantidad ingresada'>
                                    </div>
                                    @error('cantidadIngreso')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group has-feedback row">
                                    <label for="precioUnidad" class="col-12 control-label">Precio de unidad:</label>
                                    <div class="col-12">
                                        <input id='precioUnidad' type='number' min='0.01'
                                            value="{{ old('precioUnidad',$detalleCompra->precioUnidad) }}" step='0.01' class='form-control'
                                            name='precioUnidad' placeholder='Precio unitario'>
                                    </div>

                                    @error('precioUnidad')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group has-feedback row">
                                    <label for="fechaVenc" class="col-12 control-label">Fecha de
                                        vencimiento:</label>
                                    <div class="col-12">
                                        <input id='fechaVenc' value="{{ old('fechaVenc',$detalleCompra->fechaVenc) }}" type='date'
                                            min="{{ date('Y-m-d') }}" class='form-control' name='fechaVenc'
                                            placeholder='Fecha de vencimiento'>
                                    </div>

                                    @error('fechaVenc')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
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

@endsection

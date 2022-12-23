@extends('admin.layouts.index')

@section('content')
    <div>
        <h1>Detalle de la Requisicion</h1>
        @if ($requisicionProducto->estado == false)
            <div class="row">
                <div class="col-sm-6"  style="height:40rem;overflow-y: scroll;">
                    <h3>Ingresa los productos a pedir</h3>
                    <form action="{{ route('requisicionProducto.detalle',$requisicionProducto) }}" method="GET">
                        
                        <div class="row">
                            <div class="col-sm-8">
                                <input  class="form-control" type="text"  name="cod_producto" placeholder="Código de producto">
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-success">Filtrar</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive" style="margin-top:1em">
                    <table class="table table-bordered" id="dataTable13" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">Código</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Agregar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productos as $item)
                                <tr>
                                    <th scope="row">{{ $item->id }}</th>
                                    <td>{{ $item->cod_producto }}</td>
                                    <td>{{ $item->descripcion }}</td>
                                    <td>
                                        <form
                                        action="{{ route('detalleRequisicion.store', ['requisicionProducto' => $requisicionProducto->id, 'producto' => $item->id]) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Agregar</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
                <div class="col-sm-6">
                    <h3>Productos ingresados a la requisicion</h3>
                    <form action="{{ route('requisicionProducto.pagar', $requisicionProducto) }}" method="POST">
                        @csrf
                        @method('put')
                        <button type="submit" class="btn btn-danger float-md-right" style="margin-bottom:1em">Completar Requisicion</button>
                    </form>
                    <div class="table-responsive" style="margin-top:1em">
                    <table class="table table-bordered" id="dataTable14" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">Productos</th>
                                <th scope="col">Cantidad Venta</th>
                                <th scope="col">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detalle_requisicion as $item)
                                <tr>
                                    <th scope="row">{{ $item->id }}</th>
                                    <td>{{ $item->producto->cod_producto }}</td>
                                    <td>
                                        <form
                                            action="{{ route('detalleRequisicion.update', ['requisicionProducto' => $requisicionProducto->id, 'detalleRequisicion' => $item->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('put')
                                            <div class="input-group mb-3">
                                                <input type="text" value="{{ old('cantidad',$item->cantidad) }}"
                                                    name="cantidad" class="form-control" placeholder="Cantidad"
                                                    aria-label="Cantidad" aria-describedby="button-addon2">
                                                    @error('cantidad')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                <button class="btn btn-success" type="submit"
                                                    id="button-addon2">Actualizar</button>
                                            </div>
                                        </form>
                                    </td>>
                                    <td>
                                        <a href="{{ route('detalleRequisicion.destroy', ['requisicionProducto' => $requisicionProducto, 'detalleRequisicion' => $item]) }}"
                                        data-toggle="modal" data-target="#deleteModal" data-ventaid="{{$requisicionProducto->id}}" data-detalleid="{{$item->id}}"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <td></td>
                                    <td></td>
                                    <td><strong>TOTAL</strong</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        @else
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Productos de esta requisición
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable12" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">Codigo de producto</th>
                                    <th scope="col">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($detalle_requisicion as $item)
                                <tr>
                                    <th scope="row">{{ $item->id }}</th>
                                    <td>{{ $item->producto->cod_producto }}</td>
                                    <td>{{ $item->cantidad }}</td>
                                </tr>
                            @endforeach
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>

     <!-- delete Modal-->
 <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">¿Estás seguro de que quieres eliminar esto?
</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                </div>
                <div class="modal-body">Seleccione "eliminar" Si realmente desea eliminar a este medicamento de la venta 
</div>
                <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <form method="POST" action="">
                    @method('GET')
                    @csrf
                    <!--{{-- <input type="hidden" id="user_id" name="user_id" value=""> --}}-->
                    <a class="btn btn-primary" onclick="$(this).closest('form').submit();">Borrar</a>
                </form>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="card-footer small text-muted"></div>
</div>
    
    @section('js_venta_page')
    <script>
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) 
            var venta_id = button.data('ventaid') 
            var detalle_id = button.data('detalleid') 
            
            var modal = $(this)
            // modal.find('.modal-footer #user_id').val(user_id)
            modal.find('form').attr('action','/venta/detalle/' + venta_id + '/eliminar/' + detalle_id);
        })
    </script>
<script>
    $(document).ready(function() {
    $('#dataTable12').DataTable({
        "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        }
    });
    $('#dataTable13').DataTable({
        dom: '<"top"i>rt<"bottom"flp><"clear">',
        "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        }
    });
    $('#dataTable14').DataTable({
        dom: '<"top"i>rt<"bottom"flp><"clear">',
        "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        }
    });
});
</script>

@endsection

@endsection

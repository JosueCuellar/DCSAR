@extends('admin.layouts.index')
@section('title','Producto')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12" >
            <p></p>
        </div>

        <div class="col-12">
            <div class="card card-post" id="post_card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        Creando producto: 
                        <div class="pull-right">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm float-right" data-toggle="tooltip" data-placement="left" title data-original-title="Regresar a lista de productos">Regresar</a>
                        </div>
                    </div>
                </div>
                <x-errores class="mb-4" />
                <form action="{{route('producto.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback row">
                                <label for="cod_producto" class="col-12 control-label">Codigo producto:</label>
                                <div class="col-12">
                                <input id="cod_producto" type="text" class="form-control"  name="cod_producto" 
                                value="{{old('cod_producto')}}" placeholder="Codigo producto" >
                                </div>
                            </div>

                            <div class="form-group has-feedback row">
                                <label for="descripcion" class="col-12 control-label">Descripcion:</label>
                                <div class="col-12">
                                <input id="descripcion" type="text" class="form-control"  name="descripcion" 
                                value="{{old('descripcion')}}" placeholder="Descripcion" >
                                </div>
                            </div>

                            <div class="form-group has-feedback row">
                                <label for="observacion" class="col-12 control-label">Observacion:</label>
                                <div class="col-12">
                                <input id="observacion" type="text" class="form-control"  name="observacion" 
                                value="{{old('observacion')}}" placeholder="Observacion" >
                                </div>
                            </div>

                            <div class="form-group has-feedback row">
                                <img id="imagenSeleccionada" style="max-height: 300px">
                            </div>

                            <div class="form-group has-feedback row">
                                <label for="imagen" class="col-12 control-label">Seleccionar imagen</label>
                                <div class="col-12">
                                <input id="imagen" class="form-control"   name="imagen" type="file">
                                </div>
                            </div>

                            <div class="form-group has-feedback row">
                                <label for="marca_id" class="col-12 control-label">Marca:</label>
                                <div class="col-12">
                                    <select class="form-control" name="marca_id" id="marca_id" value="{{old('marca_id')}}">
                                        <option selected='true' disabled='disabled'>Seleccionar marca</option>
                                            @foreach( $marcas as $item )
                                            <option value="{{ $item->id }}">{{ $item->nombre}}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>  
                            
                            <div class="form-group has-feedback row">
                                <label for="medida_id" class="col-12 control-label">Medida:</label>
                                <div class="col-12">
                                    <select class="form-control" name="medida_id" id="medida_id" value="{{old('medida_id')}}">
                                        <option selected='true' disabled='disabled'>Seleccionar unidad de medida</option>
                                            @foreach( $medidas as $item )
                                            <option value="{{ $item->id }}">{{ $item->nombreMedida}}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div> 

                            <div class="form-group has-feedback row">
                                <label for="rubro_id" class="col-12 control-label">Rubro:</label>
                                <div class="col-12">
                                    <select class="form-control" name="rubro_id" id="rubro_id" value="{{old('rubro_id')}}">
                                        <option selected='true' disabled='disabled'>Seleccionar rubro del producto</option>
                                            @foreach( $rubros as $item )
                                            <option value="{{ $item->id }}">{{ $item->descripcionRubro}}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div> 

                            <div class="form-group has-feedback row">
                                <label for="estado_id" class="col-12 control-label">Estado:</label>
                                <div class="col-12">
                                    <select class="form-control" name="estado_id" id="estado_id" value="{{old('estado_id')}}">
                                        <option selected='true' disabled='disabled'>Seleccionar estado</option>
                                            @foreach( $estados as $item )
                                            <option value="{{ $item->id }}">{{ $item->nombreEstado}}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>  


                        </div>
                    </div>
                </div> 
                
                <div class="card-footer">
                    <div class="row">
                        <div class="col-9"></div>
                        <div class="col-3 pull-rigth">
                            <span data-toggle="tooltip" title data-original-title="Guardar cambios realizados">
                                <button type="submit" class="btn btn-success btn-lg btn-block" value="Guardar" name="action">
                                    <i class="fa fa-save fa-fw">
                                        <span class="sr-only">
                                            Guardar producto Icono
                                        </span>
                                    </i>
                                            Guardar producto
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

@section('js_imagen')
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function (e){
            $('#imagen').change(function(){
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#imagenSeleccionada').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>

@endsection


@endsection


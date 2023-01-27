@extends('admin.layouts.index')
@section('title', 'Requisicion producto')
@section('content')

<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <h2>Requisiciones de productos</h2>
            </div>
            <div class="col-md-6">
                <form action="{{ route('requisicionProducto.store') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success btn-lg float-md-right" role="button"
                        aria-pressed="true">Crear una requisicion</button>
                </form>
            </div>
        </div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane"
                    type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Requisiciones AÚN
                    SIN
                    COMPLETAR</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable11" width="100%" cellspacing="0">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Numero correlativo</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Editar</th>
                                </tr>
                            </thead>
                            <tfoot class="thead-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Numero correlativo</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">EStado</th>
                                    <th scope="col">Editar</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($requisicionesSinCompletar as $item)
                                    <tr>
                                        <th scope="row">{{ $item->id }}</th>
                                        <td>{{ $item->fecha_requisicion }}</td>
                                        <td>{{ $item->fecha_requisicion }}</td>
                                        <td>{{ $item->estado }}</td>
                                        <td>
                                            <a href="{{ route('requisicionProducto.detalle', $item->id) }}"><ion-icon name="create-outline" class="fa-lg text-primary"></ion-icon></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js_datatable')

    <script>
        $(document).ready(function() {
            $('#dataTable10').DataTable({
                dom: '<"top"i>rt<"bottom"flp><"clear">',
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });
            $('#dataTable11').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });
        });
    </script>

@endsection

@endsection

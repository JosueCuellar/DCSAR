@extends('admin.layouts.index')
@section('title', 'Inventario')
@section('header')
    <div class="col-12">
        <h2>Inventario</h2>
    </div>
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="card card-secondary card-outline" style="width: 100%">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped text-center" id="dataTable25" width="100%"
                                cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Codigo producto</th>
                                        <th scope="col">Descripción producto</th>
                                        <th scope="col">Stock real</th>
                                        <th scope="col">Stock disponible</th>
                                        {{-- <th scope="col">Stock actual(Stock real - Cantidad reservada)</th> --}}
                                        <th scope="col">Cantidad reservada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js_datatable')
    <script>
        $(document).ready(function() {
            $('#dataTable25').DataTable({
                // processing: true, 
                serverSide: true,
                ajax: '{{ route('inventario.datos') }}',
                columns: [{
                        data: 'codProducto',
                        name: 'codProducto'
                    },
                    {
                        data: 'descripcion',
                        name: 'descripcion'
                    },
                    {
                        data: 'stock',
                        name: 'stock'
                    },
                    {
                        data: null,
                        name: 'total',
                        render: function(data, type, row) {
                            return Number(row.stock) - Number(row.stock1);
                        }
                    },
                    {
                        data: 'stock1',
                        name: 'stock1'
                    }
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                autoWidth: false,
                responsive: true,
                columnDefs: [{
                        "responsivePriority": 10001,
                        "targets": 1
                    },
                    {
                        "responsivePriority": 10002,
                        'targets': 2
                    }
                ]
            });
        });
    </script>
    <script>
        // Save the search value in localStorage
        $('#dataTable25').on('search.dt', function() {
            localStorage.setItem('search', $('.dataTables_filter input').val());
        });

        // Get the search value from localStorage and set it as the search value
        $(document).ready(function() {
            var search = localStorage.getItem('search');
            if (search) {
                $('.dataTables_filter input').val(search);
                $('#dataTable25').DataTable().search(search).draw();
            }
        });
    </script>
@endsection

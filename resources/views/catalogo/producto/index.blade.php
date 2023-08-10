@extends('layoutsGeneral.admin.layouts.index')
@section('title', 'Producto')
@section('header')
    <div class="col-md-12">
        <h2>Lista de productos</h2>
    </div>

    <div class="col-md-12">
        <form action="{{ route('producto.create') }}" method="GET">
            @csrf
            <button type="submit" class="btn btn-success text-left" role="button" aria-pressed="true"><i
                    class="fa fa-plus"></i> Nuevo producto</button>
        </form>
    </div>
@endsection
@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-extra-sm table-hover table-striped text-center" id="dataTable6"
                    width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Rubro</th>
                            <th scope="col">Codigo producto</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Perecedero</th>
                            <th scope="col">Imagen</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Medida</th>
                            <th scope="col">C Prom</th>
                            <th scope="col">Observacion</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!-- delete Modal-->
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">¿Estás seguro de que quieres eliminar esto?
                            </h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">Seleccione "Borrar" Si realmente desea eliminar este registro </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                            <form method="POST" action="">
                                @method('GET')
                                @csrf
                                <!--{{-- <input type="hidden" id="user_id" name="user_id" value=""> --}}-->
                                <a class="btn btn-danger" onclick="$(this).closest('form').submit();">Borrar</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer small text-muted"></div>
    </div>
@endsection
@section('js_datatable')

    <script>
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var delete_id = button.data('delete')

            var modal = $(this)
            // modal.find('.modal-footer #user_id').val(user_id)
            modal.find('form').attr('action', 'producto/destroy/' + delete_id);

        })
    </script>

    <script>
        $(document).ready(function() {
            $('#dataTable6').DataTable({
                // processing: true, 
                serverSide: true,
                drawCallback: function(settings) {
                    this.api().table().body().querySelectorAll('[data-toggle="lightbox"]').forEach(
                        el => {
                            el.addEventListener('click', e => {
                                e.preventDefault();
                                const lightbox = new Lightbox(el);
                                lightbox.show();
                            });
                        });
                },
                order: [
                    [1, "asc"]
                ],
                ajax: '{{ route('producto.datos') }}',
                columns: [{
                        data: 'rubro_id',
                        name: 'rubro_id'
                    },
                    {
                        data: 'codProducto',
                        name: 'codProducto'
                    },
                    {
                        data: 'descripcion',
                        name: 'descripcion'
                    },
                    {
                        data: 'perecedero',
                        name: 'perecedero',
                        render: function(data, type, row) {
                            if (data == 1) {
                                return '<td><span class="badge bg-success">Perecedero</span></td>';
                            } else {
                                return '<td><span class="badge bg-danger">No Perecedero</span></td>';
                            }
                        }
                    },
                    {
                        data: 'imagen',
                        name: 'imagen',
                        render: function(data, type, row) {
                            return '<div class="filter-container row">' +
                                '<div class="filtr-item col-sm-2">' +
                                '<a href="/imagen/' + data + '" data-toggle="lightbox">' +
                                '<img src="/imagen/' + data +
                                '" class="img-fluid" style="width:40px;max-width:100px">' +
                                '</a>' +
                                '</div>' +
                                '</div>';
                        }

                    },

                    {
                        data: 'marca_id',
                        name: 'marca_id'
                    },
                    {
                        data: 'medida_id',
                        name: 'medida_id'
                    },
                    {
                        data: 'costoPromedio',
                        name: 'costoPromedio',
                        render: function(data, type, row) {
                            if (data === null) {
                                return 0;
                            }
                            // Convert the value to a float
                            var value = parseFloat(data);

                            // Format the value with 2 decimal places and include the leading zero
                            var formattedValue = value.toLocaleString('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });

                            return formattedValue;
                        }
                    },

                    {
                        data: 'observacion',
                        name: 'observacion'
                    },
                    {
                        data: 'id',
                        name: 'actions',
                        render: function(data, type, row) {
                            return '<td>' +
                                '<a href="/producto/edit/' + data + '">' +
                                '<ion-icon name="create-outline" class="fa-lg text-primary"></ion-icon>' +
                                '</a>' +
                                '<a href="/producto/destroy/' + data +
                                '" data-toggle="modal" data-target="#deleteModal" data-delete="' +
                                data + '">' +
                                '<ion-icon name="trash-outline" class="fa-lg text-danger"></ion-icon>' +
                                '</a>' +
                                '</td>';
                        }
                    }
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                autoWidth: false,
                processing: true,
                responsive: true,
                columnDefs: [{
                    responsivePriority: 10001,
                    targets: 1
                }]
            });
        });

        // Save the search value in localStorage
        $('#dataTable6').on('search.dt', function() {
            localStorage.setItem('searchProducto', $('.dataTables_filter input').val());
        });

        // Get the search value from localStorage and set it as the search value
        $(document).ready(function() {
            var search = localStorage.getItem('searchProducto');
            if (search) {
                $('.dataTables_filter input').val(search);
                $('#dataTable6').DataTable().search(search).draw();
            }
        });
    </script>
@endsection

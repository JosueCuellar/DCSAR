<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('fondo/logo22.png') }}">

    <!-- Page level plugin CSS-->
    <link rel="stylesheet" href="{{ asset('vendor/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('vendor/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('vendor/plugins/toastr/toastr.min.css') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('vendor/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/dist/css/adminlte.min.css') }}">

    <link rel="stylesheet" href="{{ asset('vendor/plugins/ekko-lightbox/ekko-lightbox.css') }}">


</head>

<body class="hold-transition sidebar-mini layout-footer-fixed sidebar-collapse">

    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark" style="background-color:#313945">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ asset('/') }}" class="nav-link">Inicio</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <h5 class="text-white-50"><b>Requisiciones y Almacén para la trazabilidad de
                            las solicitudes de bienes y/o insumos</b></h5>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                <li class="nav-item"> <img src="{{ asset('fondo/logo22.png') }}" class="img-fluid" style="max-width: 40px" alt="Responsive image"></li>

                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-secondary elevation-5" style="background-color:#313945">
            <!-- Sidebar -->

            <a href="/" class="brand-link" style="background-color:#313945">
                <img src="{{ asset('fondo/logoPNG.png') }}" alt="AdminLTE Logo" class="brand-image"
                style="opacity: .8">
                <span class="brand-text font-weight-light">DCSAR</span>
            </a>

            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-3">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview"
                        role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                        <li class="nav-header text-light">REQUISICIÓN DE PRODUCTO</li>
                        <li class="nav-header"></li>
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <ion-icon name="document-attach-outline" class="nav-icon"></ion-icon>
                                <p>
                                    Realizar requisición
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item menu-is-opening menu-open">
                                    <a href="{{ asset('requisicionProducto') }}" class="nav-link dark">
                                        <ion-icon name="list-sharp" class="nav-icon"></ion-icon>
                                        <p>
                                            Agregar requisición
                                            <span class="right badge badge-success"> </span>
                                        </p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item menu-is-opening menu-open">
                                    <a href="{{ asset('requisicionProducto/estado') }}" class="nav-link dark">
                                        <ion-icon name="hourglass-outline" class="nav-icon"></ion-icon>
                                        <p>
                                            Estado de requisición
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <br>

                        <li class="nav-header text-light">INVENTARIO</li>
                        <li class="nav-header"></li>
                        <li class="nav-item">
                            <a href="{{ asset('inventario') }}" class="nav-link active">
                                <ion-icon name="cube-outline" class="nav-icon"></ion-icon>
                                <p>
                                    Inventario
                                </p>
                            </a>
                        </li>

                        <br>

                        <li class="nav-header text-light">REVISAR SOLICITUDES</li>
                        <li class="nav-header"></li>
                        <li class="nav-item">
                            <a href="{{ asset('requisicionProducto/revisar') }}" class="nav-link active">
                                <ion-icon name="folder-open-outline" class="nav-icon"></ion-icon>
                                <p>
                                    Solicitudes recibidas
                                    {{-- <span class="badge badge-info right">{{$nEnviadas}}</span> --}}
                                </p>
                            </a>
                        </li>

                        <br>
                        <li class="nav-header"></li>
                        <li class="nav-header text-light">CATALOGOS </li>
                        <li class="nav-header"></li>
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <ion-icon name="book-outline" class="nav-icon"></ion-icon>
                                <p>
                                    Catalogos
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('marca') }}" class="nav-link">
                                        <ion-icon name="albums-outline" class="nav-icon"></ion-icon>
                                        <p>
                                            Marca
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ asset('proveedor') }}" class="nav-link">
                                        <ion-icon name="car-outline" class="nav-icon"></ion-icon>
                                        <p>
                                            Proveedor
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ asset('medida') }}" class="nav-link">
                                        <ion-icon name="resize-outline" class="nav-icon"></ion-icon>
                                        <p>
                                            Unidad de medida
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ asset('estado') }}" class="nav-link">
                                        <ion-icon name="options-outline" class="nav-icon"></ion-icon>
                                        <p>
                                            Estado
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ asset('unidadOrganizativa') }}" class="nav-link">
                                        <ion-icon name="people-circle-outline" class="nav-icon"></ion-icon>
                                        <p>
                                            Unidad Organizativa
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ asset('rubro') }}" class="nav-link">
                                        <ion-icon name="newspaper-outline" class="nav-icon"></ion-icon>
                                        <p>
                                            Rubro
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ asset('producto') }}" class="nav-link">
                                        <ion-icon name="hammer-outline" class="nav-icon"></ion-icon>
                                        <p>
                                            Producto
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- <li class="nav-header"></li>
                        <li class="nav-header text-light">INGRESO DE PRODUCTO </li>
                        <li class="nav-header"></li>
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link active">
                                <ion-icon name="clipboard-outline" class="nav-icon"></ion-icon>
                                <p>
                                    Ingreso productos
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item menu-is-opening menu-open">
                                    <a href="{{ asset('recepcionCompra') }}" class="nav-link">
                                        <ion-icon name="cash-outline" class="nav-icon"></ion-icon>
                                        <p>Registrar compra</p>
                                        <span class="right badge badge-success"> </span>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}


                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content-header">
                @yield('header')
            </div>

            <!-- Main content -->
            @yield('content')
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="text-center main-footer" style="background-color:#313945">
            <strong>GSI - Defensoria del Consumidor - 2023</strong>
        </footer>

    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <!-- jQuery -->
    <script src="{{ asset('vendor/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('vendor/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE -->
    <script src="{{ asset('vendor/dist/js/adminlte.js') }}"></script>


    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
    <script src="{{ asset('vendor/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script> --}}
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- DataTables -->
    <script src="{{ asset('vendor/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>


    <script src="{{ asset('vendor/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('vendor/plugins/inputmask/jquery.inputmask.min.js') }}"></script>

    @yield('js_datatable')
    @yield('js_imagen')
    @yield('js')

</body>

</html>

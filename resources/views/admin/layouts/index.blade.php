<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('fondo/logo22.png') }}">
    <!-- DataTables -->
    {{-- <link rel="stylesheet" href="{{ asset('vendor/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery.scrollbar/0.2.11/jquery.scrollbar.min.css"
        integrity="sha512-xlddSVZtsRE3eIgHezgaKXDhUrdkIZGMeAFrvlpkK0k5Udv19fTPmZFdQapBJnKZyAQtlr3WXEM3Lf4tsrHvSA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> {{-- <link rel="stylesheet" href="{{ asset('vendor/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}"> --}}

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('vendor/plugins/toastr/toastr.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('vendor/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/dist/css/adminlte.min.css') }}">
    <style>

    </style>


</head>

<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed m-0 p-0">

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

                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" class="nav-link dropdown-toggle"> {{ Auth::user()->name }}
                    </a>

                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow"
                        style="left: 0px; right: inherit;">
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                Salir
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>

                <li class="nav-item"> <img src="{{ asset('fondo/logo22.png') }}" class="img-fluid"
                        style="max-width: 40px" alt="Responsive image"></li>


            </ul>

        </nav>


        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar main-sidebar-custom sidebar-dark-secondary elevation-4"
            style="background-color:#313945">
            <!-- Sidebar -->

            <a href="/" class="brand-link" style="background-color:#313945">
                <img src="{{ asset('fondo/logoPNG.png') }}" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
                <span class="brand-text font-weight-light">DCSAR</span>
            </a>

            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-1">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview"
                        role="menu" data-accordion="false">
                        <li class="nav-header text-light">REQUISICIÓN DE PRODUCTO</li>
                        @can('Crear solicitud requisicion')
                        <li class="nav-item">
                            <a href="{{ asset('requisicionProducto') }}" class="nav-link active">
                                <ion-icon name="list-outline" class="nav-icon"></ion-icon>
                                <p>
                                    Realizar Requisición
                                </p>
                            </a>
                        </li>                        
                        @endcan


                        @can('Ver estados de solicitudes')
                        <li class="nav-item">
                            <a href="{{ asset('requisicionProducto/estado') }}" class="nav-link active">
                                <ion-icon name="hourglass-outline" class="nav-icon"></ion-icon>
                                <p>
                                    Estado de Requisición
                                </p>
                            </a>
                        </li>                        
                        @endcan

                       
                        @can('Ver solicitudes realizadas')                        
                        <li class="nav-item">
                            <a href="{{ asset('requisicionProducto/recibida') }}" class="nav-link active">
                                <ion-icon name="pencil-outline" class="nav-icon"></ion-icon>
                                <p>
                                    Requisiciones Realizadas
                                </p>
                            </a>
                        </li>
                        @endcan

                        @can('Revision de solicitudes')
                        <li class="nav-header text-light">REVISAR SOLICITUDES</li>
                        <li class="nav-item">
                            <a href="{{ asset('requisicionProducto/revisar') }}" class="nav-link active">
                                <ion-icon name="folder-open-outline" class="nav-icon"></ion-icon>
                                <p>
                                    Solicitudes Recibidas
                                </p>
                            </a>
                        </li>
                        @endcan
                    
                        @can('Crear ingreso de productos')
                        <li class="nav-header text-light">INGRESO DE PRODUCTO </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <ion-icon name="clipboard-outline" class="nav-icon"></ion-icon>
                                <p>
                                    Ingreso Productos
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item menu-is-opening menu-open">
                                    <a href="{{ asset('recepcionCompra') }}" class="nav-link bg-dark">
                                        <ion-icon name="cash-outline" class="nav-icon"></ion-icon>
                                        <p>Registrar Ingreso</p>
                                    </a>
                                </li>
                            </ul>

                            @can('Consultar ingreso de productos')
                            <ul class="nav nav-treeview">
                                <li class="nav-item menu-is-opening menu-open">
                                    <a href="{{ asset('recepcionCompra/consultar') }}" class="nav-link dark">
                                        <ion-icon name="grid" class="nav-icon"></ion-icon>
                                        <p>
                                            Ingresos Realizados
                                        </p>
                                    </a>
                                </li>
                            </ul>
                            @endcan
                           
                        </li>
                        @endcan
                       
                        @can('Bandeja solicitud a entregar')
                        <li class="nav-header text-light">SOLICITUDES A ENTREGAR</li>
                        <li class="nav-item">
                            <a href="{{ asset('requisicionProducto/entregaSolicitud') }}" class="nav-link active">
                                <ion-icon name="receipt-outline" class="nav-icon"></ion-icon>
                                <p>
                                    Bandeja de Solicitudes
                                </p>
                            </a>
                        </li>
                        @endcan
                        
                        @can('Ver inventario')
                        <li class="nav-header text-light">INVENTARIO</li>
                        <li class="nav-item">
                            <a href="{{ asset('inventario') }}" class="nav-link active">
                                <ion-icon name="cube-outline" class="nav-icon"></ion-icon>
                                <p>
                                    Inventario
                                </p>
                            </a>
                        </li>
                        @endcan
                        
                        @can('Ver bodega principal')
                        <li class="nav-header text-light">PRODUCTOS BODEGA</li>
                        <li class="nav-item">
                            <a href="{{ asset('productoBodega/principal/') }}" class="nav-link active">
                                <ion-icon name="grid-outline" class="nav-icon"></ion-icon>
                                <p>
                                    Bodega Productos
                                </p>
                            </a>
                        </li>
                        @endcan


                        @can('Catalogo')
                        <li class="nav-header text-light">CATALOGOS </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <ion-icon name="book-outline" class="nav-icon"></ion-icon>
                                <p>
                                    Catalogos
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('CRUD marca')
                                    <li class="nav-item">
                                        <a href="{{ asset('marca') }}" class="nav-link">
                                            <ion-icon name="albums-outline" class="nav-icon"></ion-icon>
                                            <p>
                                                Marca
                                            </p>
                                        </a>
                                    </li>
                                @endcan
                                @can('CRUD proveedor')
                                <li class="nav-item">
                                    <a href="{{ asset('proveedor') }}" class="nav-link">
                                        <ion-icon name="car-outline" class="nav-icon"></ion-icon>
                                        <p>
                                            Proveedor
                                        </p>
                                    </a>
                                </li>
                                @endcan
                                @can('CRUD medida')
                                <li class="nav-item">
                                    <a href="{{ asset('medida') }}" class="nav-link">
                                        <ion-icon name="resize-outline" class="nav-icon"></ion-icon>
                                        <p>
                                            Unidad de Medida
                                        </p>
                                    </a>
                                </li>                                
                                @endcan
                                @can('CRUD rubro')
                                <li class="nav-item">
                                    <a href="{{ asset('rubro') }}" class="nav-link">
                                        <ion-icon name="newspaper-outline" class="nav-icon"></ion-icon>
                                        <p>
                                            Rubro
                                        </p>
                                    </a>
                                </li>                                
                                @endcan
                                @can('CRUD producto')
                                <li class="nav-item">
                                    <a href="{{ asset('producto') }}" class="nav-link">
                                        <ion-icon name="hammer-outline" class="nav-icon"></ion-icon>
                                        <p>
                                            Producto
                                        </p>
                                    </a>
                                </li>                                
                                @endcan

                            </ul>
                        </li>
                        @endcan
                        

                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->

            <div class="sidebar-custom">
                @can('Ver panel admin')
                    <a href="{{ asset('admin') }}" class="btn btn-link">
                        <ion-icon name="settings-outline" class="fa-2x bg-dark"></ion-icon>
                    </a>
                @endcan

            </div>
        </aside>

        <style>
            .table-extra-sm td,
            .table-extra-sm th {
                padding: 0.1rem;
            }
        </style>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('bar')

            <div class="p-1">
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
    {{-- <script src="{{ asset('vendor/plugins/jquery/jquery.min.js') }}"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <!-- Bootstrap -->

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('vendor/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE -->
    <script src="{{ asset('vendor/dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('vendor/plugins/toastr/toastr.min.js') }}"></script>


    <!-- Bootstrap core JavaScript-->
    {{-- <script src="{{ asset('vendor/plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.3/dist/index.bundle.min.js"></script>

    {{-- <script src="{{ asset('vendor/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>


    <!-- Core plugin JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"
        integrity="sha512-0QbL0ph8Tc8g5bLhfVzSqxe9GERORsKhIn1IrpxDAgUsbBGz/V7iSav2zzW325XGd1OMLdL4UiqRJj702IeqnQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.scrollbar/0.2.11/jquery.scrollbar.min.js"
        integrity="sha512-5AcaBUUUU/lxSEeEcruOIghqABnXF8TWqdIDXBZ2SNEtrTGvD408W/ShtKZf0JNjQUfOiRBJP+yHk6Ab2eFw3Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>

    @yield('js_datatable')
    @yield('js_imagen')
    @yield('js')

</body>

</html>

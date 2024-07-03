<!DOCTYPE html>
<html lang="es">

<head>
    <?php $includeScript = $includeScript ?? true; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('fondo/logo22.png') }}">
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ asset('dependencias/css/cdn.datatables.net_1.13.4_css_dataTables.bootstrap5.min.css') }}">
    <!-- DataTables responsive -->
    <link rel="stylesheet"
        href="{{ asset('dependencias/css/cdn.datatables.net_responsive_2.4.1_css_responsive.dataTables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('dependencias/css/cdn.datatables.net_buttons_2.3.6_css_buttons.bootstrap5.min.css') }}">
    <!-- ScrollBar -->
    <link rel="stylesheet"
        href="{{ asset('dependencias/css/cdnjs.cloudflare.com_ajax_libs_jquery.scrollbar_0.2.11_jquery.scrollbar.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('dependencias/css/cdn.jsdelivr.net_npm_bootstrap@5.0.2_dist_css_bootstrap.min.css') }}">
    <!-- Toast -->
    <link rel="stylesheet" href="{{ asset('vendor/plugins/toastr/toastr.min.css') }}">
    <!-- Select 2 -->
    <link rel="stylesheet"
        href="{{ asset('dependencias/css/cdn.jsdelivr.net_npm_select2@4.1.0-rc.0_dist_css_select2.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="{{ asset('dependencias/css/fonts.googleapis.com_css_family=Source+Sans+Pro_300,400,400i,700&display=fallback.css') }}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('vendor/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('dependencias/css/cdn.datatables.net_searchbuilder_1.5.0_css_searchBuilder.dataTables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('dependencias/css/cdn.datatables.net_buttons_2.4.1_css_buttons.dataTables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('dependencias/css/cdn.datatables.net_datetime_1.5.1_css_dataTables.dateTime.min.css') }}">
    <!-- Estilo CSS del loader -->
    <style>
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-color: rgba(255, 255, 255, 1);
            /* Color blanco con opacidad del 50% */
        }

        .loader {
            position: absolute;
            top: 50%;
            left: 50%;
            border-radius: 50%;
            border-top: 3px solid #3498db;
            border-right: 3px solid #3498db;
            border-bottom: 3px solid #3498db;
            border-left: 3px solid #ccc;
            width: 30px;
            height: 30px;
            margin-top: -15px;
            margin-left: -15px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <!-- Estilo CSS del loader -->
    <style>
        html {
            font-size: 90%;
        }

        .table-extra-sm td,
        .table-extra-sm th {
            padding: 0.1rem;
        }
    </style>

</head>


<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed m-0 p-0 layout-footer-fixed">
    <!-- wrapper -->
    <div class="wrapper">
        <!-- Loader se carga aca -->
        <div id="preloader">
            <div class="loader"></div>
        </div>
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
                <li class="nav-item d-none d-sm-inline-block">
                    <h5 class="text-white-50"><b>Requisiciones y Almacén para la trazabilidad de las solicitudes de
                            bienes y/o insumos</b></h5>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                <a href="#" class="nav-link">
                    <ion-icon name="person-circle-sharp" class="nav-icon"></ion-icon>
                    {{ Auth::user()->name }}
                </a>
                <a class="nav-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
								document.getElementById('logout-form').submit();
								localStorage.clear();">
                    <ion-icon name="power-sharp" class="nav-icon"></ion-icon>
                    Salir
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
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
                <img src="{{ asset('fondo/logoPNG.png') }}" alt="AdminLTE Logo" class="brand-image"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">DCSAR</span>
            </a>
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-1">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview"
                        role="menu" data-accordion="false">
                        @can('SideBar: Requisicion de producto')
                            <li class="nav-header text-light">REQUISICIÓN DE PRODUCTO</li>
                            <li class="nav-item">
                                <a href="{{ asset('requisicionProducto') }}" class="nav-link active">
                                    <ion-icon name="list-outline" class="nav-icon"></ion-icon>
                                    <p>
                                        Realizar Requisición
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ asset('requisicionProducto/estado') }}" class="nav-link active">
                                    <ion-icon name="hourglass-outline" class="nav-icon"></ion-icon>
                                    <p>
                                        Estado de Requisición
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ asset('requisicionProducto/recibida') }}" class="nav-link active">
                                    <ion-icon name="pencil-outline" class="nav-icon"></ion-icon>
                                    <p>
                                        Requisiciones Realizadas
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('SideBar: Inventario')
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
                        @can('SideBar: Revisar solicitudes')
                            <li class="nav-header text-light">REVISAR SOLICITUDES</li>
                            <li class="nav-item">
                                <a href="{{ asset('requisicionProducto/revisar') }}" class="nav-link active">
                                    <ion-icon name="folder-open-outline" class="nav-icon"></ion-icon>
                                    <p>
                                        Solicitudes a Revisar
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('SideBar: Ingreso de producto')
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
                            </li>
                        @endcan
                        @can('SideBar: Solicitudes a entregar')
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
                        @can('SideBar: Historial requisiciones')
                            <li class="nav-header text-light">HISTORIAL REQUISICIONES</li>
                            <li class="nav-item">
                                <a href="{{ asset('requisicionProducto/historialRecibidas') }}" class="nav-link active">
                                    <ion-icon name="hourglass-outline" class="nav-icon"></ion-icon>
                                    <p>
                                        Historial Requisiciones
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('SideBar: Productos Bodega')
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
                        @can('SideBar: Reportes')
                            <li class="nav-header text-light">REPORTES</li>
                            <li class="nav-item">
                                <a href="{{ asset('reporte') }}" class="nav-link active">
                                    <ion-icon name="bar-chart-outline" class="nav-icon"></ion-icon>
                                    <p>
                                        Generar reportes
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('SideBar: Catalogos')
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
                                                Unidad de Medida
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
                        @endcan
                    </ul>
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
            <strong>GSI - Defensoria del Consumidor - 2024</strong>
        </footer>
    </div>
    <!-- ./wrapper -->
    <!-- REQUIRED SCRIPTS -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- jQuery -->
    <script src="{{ asset('dependencias/js/code.jquery.com_jquery-3.6.4.min.js') }}"></script>

    <!-- Bootstrap -->
    <script src="{{ asset('dependencias/js/cdn.jsdelivr.net_npm_select2@4.1.0-rc.0_dist_js_select2.min.js') }}"></script>
    <script src="{{ asset('vendor/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE -->
    <script src="{{ asset('vendor/dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('vendor/plugins/toastr/toastr.min.js') }}"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('dependencias/js/cdn.jsdelivr.net_npm_bs5-lightbox@1.8.3_dist_index.bundle.min.js') }}"></script>
    <script src="{{ asset('dependencias/js/cdn.jsdelivr.net_npm_bootstrap@5.0.2_dist_js_bootstrap.bundle.min.js') }}">
    </script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('dependencias/js/cdnjs.cloudflare.com_ajax_libs_jquery-easing_1.4.1_jquery.easing.min.js') }}">
    </script>

    <?php if (!$includeScript): ?>
    <script src="{{ asset('dependencias/js/cdn.datatables.net_1.13.5_js_jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dependencias/js/cdn.datatables.net_searchbuilder_1.5.0_js_dataTables.searchBuilder.min.js') }}">
    </script>
    <script src="{{ asset('dependencias/js/cdn.datatables.net_buttons_2.4.1_js_dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dependencias/js/cdn.datatables.net_datetime_1.5.1_js_dataTables.dateTime.min.js') }}"></script>
    <?php endif; ?>

    <?php if ($includeScript): ?>
    <script src="{{ asset('dependencias/js/cdn.datatables.net_1.13.4_js_jquery.dataTables.min.js') }}"></script>
    <?php endif; ?>
    <!-- DataTables -->
    <script src="{{ asset('dependencias/js/cdn.datatables.net_1.13.4_js_dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('dependencias/js/cdn.datatables.net_responsive_2.4.1_js_dataTables.responsive.min.js') }}">
    </script>
    <script
        src="{{ asset('dependencias/js/cdnjs.cloudflare.com_ajax_libs_jquery.scrollbar_0.2.11_jquery.scrollbar.min.js') }}">
    </script>
    <script src="{{ asset('dependencias/js/cdn.datatables.net_buttons_2.3.6_js_dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dependencias/js/cdn.datatables.net_buttons_2.3.6_js_buttons.bootstrap5.min.js') }}"></script>


    @if (session('catch'))
        <script>
            toastr.warning('{{ session('catch') }}', 'Error', {
                positionClass: 'toast-top-right',
                timeOut: 3500,
                closeButton: true,
            });
        </script>
    @endif

    @if (session('status'))
        <script>
            toastr.success('Registro correcto se ha actualizado la tabla', '{{ session('status') }}', {
                positionClass: 'toast-top-right',
                timeOut: 3500,
                closeButton: true,
            });
        </script>
    @endif

    @if (session('delete'))
        <script>
            toastr.error('Registro elimindado, se ha actualizado la tabla', '{{ session('delete') }}', {
                positionClass: 'toast-top-right',
                timeOut: 3500,
                closeButton: true,
            });
        </script>
    @endif

		@if (session('msg'))
    <script>
        toastr.warning('{{ session('msg') }}', 'Error', {
            positionClass: 'toast-top-right',
            timeOut: 3500,
            closeButton: true,
        });
    </script>
@endif




    @yield('js_datatable')
    @yield('js_imagen')
    @yield('js')
</body>
<script>
    $(window).on('load', function() {
        $('#preloader').slideUp('850');
    });
</script>

</html>

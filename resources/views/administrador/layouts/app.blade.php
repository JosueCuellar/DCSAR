<!DOCTYPE html>
<html lang="es">

<head>
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

<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed">

    <div class="wrapper">
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
                    <a href="{{ asset('/') }}" class="nav-link">Volver al Inicio Principal</a>
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

                <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link">
                    <ion-icon name="person-circle-sharp" class="nav-icon"></ion-icon>
                    {{ Auth::user()->name }}
                </a>

                <a class="nav-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
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
                        <li class="nav-header text-light">ADMINISTRADOR</li>
                        <li class="nav-item">
                            <a href="{{ asset('usuario/') }}" class="nav-link active">
                                <ion-icon name="people-outline" class="nav-icon"></ion-icon>
                                <p>
                                    Usuarios
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ asset('rolesAssign') }}" class="nav-link active">
                                <ion-icon name="person-add-outline" class="nav-icon"></ion-icon>
                                <p>
                                    Agregar Permisos a Rol
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ asset('rol') }}" class="nav-link active">
                                <ion-icon name="person-add-outline" class="nav-icon"></ion-icon>
                                <p>
                                    Roles
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ asset('estado') }}" class="nav-link active">
                                <ion-icon name="options-outline" class="nav-icon"></ion-icon>
                                <p>
                                    Estado
                                </p>
                            </a>
                        </li>
                        @can('CRUD unidad organizativa')
                            <li class="nav-item">
                                <a href="{{ asset('unidadOrganizativa') }}" class="nav-link active">
                                    <ion-icon name="people-circle-outline" class="nav-icon"></ion-icon>
                                    <p>
                                        Unidad Organizativa
                                    </p>
                                </a>
                            </li>
                        @endcan
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
            <div class="sidebar-custom">
                <a href="#" class="btn btn-link">
                    <ion-icon name="settings-outline" class="fa-2x bg-dark"></ion-icon>
                </a>
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
            <strong>GSI - Defensoria del Consumidor - 2023</strong>
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
    <!-- DataTables -->
    <script src="{{ asset('dependencias/js/cdn.datatables.net_1.13.4_js_jquery.dataTables.min.js') }}"></script>
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
            $(document).Toasts('create', {
                title: 'Error',
                position: 'topRight',
                body: '{{ session('catch') }}',
                class: 'bg-warning',
                autohide: true,
                icon: 'fas fa-exclamation-triangle ',
                delay: 3500,
                close: false,
            })
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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>

  <!-- Page level plugin CSS-->
  <link rel="stylesheet" href="{{ asset('vendor/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">

  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('vendor/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">


  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('vendor/plugins/fontawesome-free/css/all.min.css') }}"">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('vendor/dist/css/adminlte.min.css') }}">


</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="" class="nav-link">Inicio</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

    </ul>
  </nav>
  <!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-ligth elevation-4" style="background-color: #4f5457">

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-header"></li>
        <li class="nav-header" style="color:#fff">REQUISICIÓN DE PRODUCTO </li>
        <li class="nav-header"></li>

        
        <li class="nav-item menu-open">
          <a href="#" class="nav-link active btn-outline-dark">
            <i class="nav-icon far fa-circle nav-icon"></i>
            <p>
              Requisición 
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ asset('requisicionProducto')}}" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>Agregar Requisición</p>
              </a>
            </li>
          </ul>
        </li>



        <li class="nav-header"></li>
        <li class="nav-header" style="color:#fff">INVENTARIO </li>
        <li class="nav-header"></li>        
        <li class="nav-item menu-is-opening menu-open">
          <a href="{{ asset('marca')}}" class="nav-link">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>
              Marca
            </p>
          </a>
          <a href="{{ asset('proveedor')}}" class="nav-link">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>
              Proveedor
            </p>
          </a>
          <a href="{{ asset('proveedor')}}" class="nav-link">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>
              Medida
            </p>
          </a>

          <a href="{{ asset('proveedor')}}" class="nav-link">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>
              Estado
            </p>
          </a>

          <a href="{{ asset('proveedor')}}" class="nav-link">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>
              Unidad Organizativa
            </p>
          </a>

          <a href="{{ asset('rubro')}}" class="nav-link">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>
              Rubro
            </p>
          </a>

          <a href="{{ asset('producto')}}" class="nav-link">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>
              Producto
            </p>
          </a>
        </li>



    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            {{-- <h1 class="m-0">Dashboard</h1> --}}
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      @yield('content')
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->


</div>
  <!-- Main Footer -->
  <footer class="main-footer">
    Defensoria del
  </footer>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('vendor/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('vendor/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE -->
<script src="{{ asset('vendor/dist/js/adminlte.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

 <!-- Bootstrap core JavaScript-->
 <script src="{{ asset('vendor/plugins/jquery/jquery.min.js') }}"></script>
 <script src="{{ asset('vendor/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

 <!-- Core plugin JavaScript-->
 <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

 <!-- DataTables -->
 <script src="{{ asset('vendor/plugins/datatables/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('vendor/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>


@yield('js_datatable')

</body>
</html>

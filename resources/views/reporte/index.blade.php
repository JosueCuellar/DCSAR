@extends('admin.layouts.index')
@section('title', 'Reportes')
@section('header')
    <div class="col-md-12">
        <h2>Reportes</h2>
    </div>
    <style>
        .transition {
            transition: opacity 0.5s ease-in-out;
            opacity: 1;
        }

        .transition.hide {
            opacity: 0;
            height: 0;
            overflow: hidden;
        }
    </style>
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <ul class="nav nav-tabs" id="h5Tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#" data-value="1">Reportes Cierre Mensuales</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-value="2">Reportes Generales</a>
                </li>
            </ul>
            <br>
            <div class="row transition" id="reportesCierreMensuales">
                <h5 class="font-italic text-center">Reportes Cierre Mensuales</h5>
                <div class="card mx-auto" style="width: 40rem;">
                    <div class="card-body">
                        <x-errores class="mb-4" />
                        <form method="POST" class="form-horizontal" action="{{ route('reporte.reportesMensuales') }}"
                            target="_blank">
                            @csrf
                            <div class="form-group row">
                                <label for="reportType" class="col-sm-4 col-form-label">Tipo de reporte</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="reportType" name="reportType" required>
                                        <option value="" disabled selected>--- Selecciona el reporte ---</option>
                                        <option value="totalIngresoMesPost">Total Ingreso Mes</option>
                                        <option value="totalSalidaMesPost">Total Salida Mes</option>
                                        <option value="listadoArticulos">Listado Articulos</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fechaInput" class="col-sm-4 col-form-label">Fecha</label>
                                <div class="col-sm-8">
                                    <input type="month" class="form-control" id="fechaInput" name="fechaInput" required
                                        max="{{ date('Y-m') }}">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-warning">Generar reporte</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row transition" id="reportesGenerales">
                <h5 class="font-italic text-center">Reportes Generales</h5>
                <div class="card mx-auto" style="width: 40rem;">
                    <div class="card-body">
                        <x-errores class="mb-4" />
                        <form method="POST" class="form-horizontal" action="{{ route('reporte.reportesGenerales') }}"
                            target="_blank">
                            @csrf
                            <div class="form-group row">
                                <label for="reportTypeGeneral" class="col-sm-2 col-form-label">Tipo de reporte</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="reportTypeGeneral" name="reportTypeGeneral" required>
                                        <option value="" disabled selected>--- Selecciona el reporte ---</option>
                                        <option value="existenciaFecha">Existencia a la fecha</option>
                                        <option value="reporteEspecifico">Reporte por especifico</option>
                                    </select>

                                </div>
                            </div>
                            <div class="form-group row additional-element">
                                <label for="rubroSelect" class="col-sm-2 col-form-label">Rubro</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="rubroSelect" name="rubroSelect">
                                        <option value="rubro1">Rubro 1</option>
                                        <option value="rubro2">Rubro 2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row additional-element">
                                <label for="fechaInicio" class="col-sm-2 col-form-label">Fecha inicio</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="fechaInicio" name="fechaInicio">
                                </div>
                            </div>
                            <div class="form-group row additional-element">
                                <label for="fechaFin" class="col-sm-2 col-form-label">Fecha fin</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="fechaFin" name="fechaFin">
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-warning">Generar reporte</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('js_datatable')

    <script>
        const h5Tabs = document.querySelectorAll('#h5Tabs a');
        const reportesCierreMensuales = document.querySelector('#reportesCierreMensuales');
        const reportesGenerales = document.querySelector('#reportesGenerales');

        // Initially hide the "Reportes Generales" content
        reportesGenerales.style.display = 'none';

        h5Tabs.forEach(tab => {
            tab.addEventListener('click', event => {
                event.preventDefault();

                // Remove the "active" class from all tabs
                h5Tabs.forEach(tab => tab.classList.remove('active'));

                // Add the "active" class to the clicked tab
                event.target.classList.add('active');

                if (event.target.dataset.value === '1') {
                    reportesCierreMensuales.style.display = 'block';
                    reportesGenerales.style.display = 'none';
                } else if (event.target.dataset.value === '2') {
                    reportesCierreMensuales.style.display = 'none';
                    reportesGenerales.style.display = 'block';
                }
            });
        });
    </script>

		<script>
			// Obtener el elemento select y los elementos adicionales
const reportTypeSelect = document.querySelector('#reportTypeGeneral');
const additionalElements = document.querySelectorAll('.additional-element');

// Ocultar los elementos adicionales al cargar la página
additionalElements.forEach((element) => {
    element.style.display = 'none';
});

// Agregar un evento de cambio al select
reportTypeSelect.addEventListener('change', (event) => {
    // Obtener el valor seleccionado
    const selectedValue = event.target.value;

    // Mostrar u ocultar los elementos adicionales según el valor seleccionado
    if (selectedValue === 'reporteEspecifico') {
        additionalElements.forEach((element) => {
            element.style.display = 'block';
        });
    } else {
        additionalElements.forEach((element) => {
            element.style.display = 'none';
        });
    }
});

		</script>


@endsection
@section('js')
    @if (session('error'))
        <script>
            $(document).Toasts('create', {
                title: 'Notificación',
                position: 'topRight',
                body: '{{ session('error') }}',
                class: 'bg-warning',
                autohide: true,
                icon: 'fas fa-exclamation-triangle',
                delay: 3500,
                close: false,
            })
        </script>
    @endif
@endsection

@extends('layoutsGeneral.admin.layouts.index')
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
                                        <option value="totalIngresoMes">Total Ingreso Mes</option>
                                        <option value="totalSalidaMes">Total Salida Mes</option>
                                        <option value="listadoArticulos">Listado Articulos</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fechaInput" class="col-sm-4 col-form-label">Fecha</label>
                                <div class="col-sm-8">
                                    <input type="month" class="form-control" id="fechaInput" name="fechaInput"
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
                        <form method="POST" class="form-horizontal" id="form"
                            action="{{ route('reporte.reportesGenerales') }}" target="_blank">
                            @csrf
                            <div class="form-group row">
                                <label for="reportTypeGeneral" class="col-sm-4 col-form-label">Tipo de reporte</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="reportTypeGeneral" name="reportTypeGeneral" required>
                                        <option value="" disabled selected>--- Selecciona el reporte ---</option>
                                        <option value="existenciaFecha">Existencia a la fecha</option>
                                        <option value="consumoPorRubro">Reporte consumo por rubro</option>
                                        <option value="salidaPorUnidadesMes">Reporte salida por unidades </option>
                                    </select>

                                </div>
                            </div>
                            <div class="additional-element">
                                <div class="form-group row">
                                    <label for="rubro_id" class="col-sm-4 col-form-label">Rubro:</label>
                                    <div class="col-sm-8">
                                        <input type="hidden" name="codigoPresupuestario" id="codigoPresupuestario">
                                        <input type="hidden" name="descripRubro" id="descripRubro">
                                        <select class="form-control" name="rubro_id" id="rubro_id">
                                            <option value="" disabled selected>---- Seleccionar especifico para
                                                realizar reporte ----</option>
                                            @foreach ($rubros as $item)
                                                <option value="{{ $item->id }}"
                                                    data-codigoPresupuestario="{{ $item->codigoPresupuestario }}"
                                                    data-descripRubro="{{ $item->descripRubro }}">
                                                    {{ $item->codigoPresupuestario . ' ' . $item->descripRubro }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="start_date" class="col-sm-4 col-form-label">Fecha inicio</label>
                                    <div class="col-sm-8">
                                        <input type="month" class="form-control" id="start_date" name="start_date"
                                            max="{{ date('Y-m') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="end_date" class="col-sm-4 col-form-label">Fecha fin</label>
                                    <div class="col-sm-8">
                                        <input type="month" class="form-control" id="end_date" name="end_date"
                                            max="{{ date('Y-m') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="fechaUnidades">
                                <div class="form-group row">
                                    <label for="fechaInput" class="col-sm-4 col-form-label">Fecha</label>
                                    <div class="col-sm-8">
                                        <input type="month" class="form-control" id="fechaInputSa" name="fechaInput"
                                            max="{{ date('Y-m') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-warning">Generar reporte</button>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    let startDate = document.querySelector('#start_date');
                                    let endDate = document.querySelector('#end_date');
                                    let form = document.querySelector('#form');

                                    form.addEventListener('submit', function(event) {
                                        if (startDate.value > endDate.value) {
                                            event.preventDefault();
                                            alert('La fecha de fin debe ser mayor o igual a la fecha de inicio.');
                                        }
                                    });
                                });
                            </script>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('js_datatable')

    <script>
        $(document).ready(function(e) {
            $('#rubro_id').select2({
                width: 'resolve',
                language: {
                    noResults: function() {
                        return "No hay resultado";
                    },
                    searching: function() {
                        return "Buscando..";
                    }
                }
            });

            $('#rubro_id').on('select2:select', function(e) {
                var data = e.params.data;
                var codigoPresupuestario = data.element.getAttribute('data-codigoPresupuestario');
                var descripRubro = data.element.getAttribute('data-descripRubro');
                document.getElementById('codigoPresupuestario').value = codigoPresupuestario;
                document.getElementById('descripRubro').value = descripRubro;
            });
        });
    </script>


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

                // Save the current tab value to local storage
                localStorage.setItem('currentTab', event.target.dataset.value);
            });
        });

        // When the page is reloaded, get the current tab value from local storage
        const currentTab = localStorage.getItem('currentTab');

        // If there is a current tab value in local storage, set the corresponding tab as active
        if (currentTab) {
            document.querySelector(`#h5Tabs a[data-value="${currentTab}"]`).click();
        }
    </script>

    <script>
        // Obtener el elemento select y los elementos adicionales
        const reportTypeSelect = document.querySelector('#reportTypeGeneral');
        const additionalElements = document.querySelectorAll('.additional-element');
        const fechaUnidad = document.querySelectorAll('.fechaUnidades');

        // Ocultar los elementos adicionales al cargar la página
        additionalElements.forEach((element) => {
            element.style.display = 'none';
        });

        fechaUnidad.forEach((element) => {
            element.style.display = 'none';
        });

        reportTypeSelect.addEventListener('change', (event) => {
            // Obtener el valor seleccionado
            const selectedValue = event.target.value;

            // Mostrar u ocultar los elementos adicionales según el valor seleccionado
            if (selectedValue === 'consumoPorRubro') {
                additionalElements.forEach((element) => {
                    element.style.display = 'block';
                });
                document.querySelector('#rubro_id').setAttribute('required', true);
                document.querySelector('#start_date').setAttribute('required', true);
                document.querySelector('#end_date').setAttribute('required', true);
								document.querySelector('.fechaUnidades').style.display = 'none';
                document.querySelector('#fechaInputSa').removeAttribute('required');
                document.querySelector('#fechaInputSa').value = '';
            } else {

                additionalElements.forEach((element) => {
                    element.style.display = 'none';
                });
                document.querySelector('#rubro_id').removeAttribute('required');
                document.querySelector('#start_date').removeAttribute('required');
                document.querySelector('#end_date').removeAttribute('required');

                // Limpiar los valores de los inputs
                document.querySelector('#start_date').value = '';
                document.querySelector('#end_date').value = '';

                if (selectedValue === 'salidaPorUnidadesMes') {
                    // Show the div with the class fechaUnidades
                    document.querySelector('.fechaUnidades').style.display = 'block';
                    document.querySelector('#fechaInputSa').setAttribute('required', true);
                } else {
                    // Hide the div with the class fechaUnidades
                    document.querySelector('.fechaUnidades').style.display = 'none';
                    document.querySelector('#fechaInputSa').removeAttribute('required');
                    document.querySelector('#fechaInputSa').value = '';

                }
            }


        });
    </script>
@endsection

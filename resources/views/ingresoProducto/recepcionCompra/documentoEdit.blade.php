@extends('layoutsGeneral.admin.layouts.index')
@section('title', 'Recepción compra')
@section('header')
    <script src="{{ asset('dependencias/js/unpkg.com_axios@1.4.0_dist_axios.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('dependencias/js/unpkg.com_dropzone@6.0.0-beta.1_dist_dropzone.css') }}">
    <script src="{{ asset('dependencias/js/unpkg.com_dropzone@6.0.0-beta.1_dist_dropzone-min.js') }}"></script>
    <div class="container">
        <div class="col-md-12">
            <h2>Agregar documentos al ingreso de productos</h2>
        </div>
    </div>
@endsection
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-post" id="post_card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div class="pull-right">
                                <a href="{{ route('recepcionCompra.consultar') }}"
                                    class="btn btn-outline-secondary btn-sm float-right" data-toggle="tooltip"
                                    data-placement="left" title data-original-title="Regresar a lista">Regresar</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form action=""></form>
                                <form method="POST" action="{{ route('upload.documento', $recepcionCompra->id) }}"
                                    class="dropzone" id="my-dropzone">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js_datatable')
    <script>
        Dropzone.options.myDropzone = {
            // Configuration options go here
            paramName: "file[]",
            acceptedFiles: "application/pdf",
            dictDefaultMessage: 'Agrega los documentos aquí, solo permite documentos en formato PDF',
            maxFilesize: 4, // MB
            addRemoveLinks: true,
            dictFileTooBig: "El archivo es muy grande. Tamaño máximo: 4MiB.",
            dictRemoveFile: "Eliminar",
            dictCancelUpload: "Cancelar carga",
            // acceptedFiles: "application/pdf,.doc,.docx,.xls,.xlsx,.csv,.tsv,.ppt,.pptx,.pages,.odt,.rtf",
            init: function() {
                this.on("removedfile", function(file) {
                    // send an AJAX request to delete the file from the server
                    axios.post('{{ route('delete.documento', $recepcionCompra->id) }}', {
                            filename: file.name
                        })
                        .then(function(response) {
                            console.log(response);
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                });
            }
        };
        Dropzone.discover();
    </script>
@endsection

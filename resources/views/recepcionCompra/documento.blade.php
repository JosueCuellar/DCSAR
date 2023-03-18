@extends('bar.layouts.bar')
@section('title', 'Documentos')

@section('header')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />
    <script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
@endsection

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-post" id="post_card">
                    <form action="{{ route('recepcionCompra.documentoPost', $recepcionCompra) }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="card-header">
                            <button type="submit" class="btn btn-success" value="Guardar" name="action">
                                Siguiente paso
                            </button>
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
                    </form>

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
            dictDefaultMessage: 'Agrega los documentos aquí',
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

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Existencias a la Fecha</title>
</head>


<body style="font-family:'Calibri',sans-serif;">
    <header name="page-header">
        <!-- Header del PDF -->
        <img src="{{ storage_path('fondo/logonew.png') }}" style="max-width: 105px;float: left;">
        <div style="max-width:110px;float: right;">
            <img src="{{ storage_path('fondo/logopdf.png') }}" style="max-width: 58px;">
        </div>
        <p style="margin:1px;text-align:center;">
            <strong><span style="font-size:20px;"><br> ESTADO ACTUAL DE EXISTENCIAS HASTA LA FECHA DE CADA
                    ARTICULO</strong>
        </p>
    </header>
    <br>
    <!----------------------------------- Requisicion de producto --------------------------------------------------------------------->

    <style>
        .column-container {
            font-size: 0.6em;
        }

        .column-container .column {
            width: 50%;
            float: left;
        }

        .column-container .column table {
            width: 100%;
        }

        th,
        td {
            text-align: left;
            padding: 4px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>

    <div class="column-container">
        <div class="column">
            <table>
                <tr>
                    <th>N</th>
                    <th>Descripción</th>
                    <th>Existencias</th>
                </tr>
                @php $i = 1; @endphp
                @foreach ($reporte->take(round($reporte->count() / 2)) as $item)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $item->descripcion }}</td>
                        <td>{{ $item->existencias }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="column">
            <table>
                <tr>
                    <th>N</th>
                    <th>Descripción</th>
                    <th>Existencias</th>
                </tr>
                @foreach ($reporte->slice(round($reporte->count() / 2)) as $item)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $item->descripcion }}</td>
                        <td>{{ $item->existencias }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</body>

</html>

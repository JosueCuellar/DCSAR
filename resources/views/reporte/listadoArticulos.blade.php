<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listado Articulos</title>
</head>

<style>
    table {
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1.5px solid black;
    }

    td {
        color: black;
        font-size: 11px;
        font-weight: 450;
        text-align: center;
        font-style: normal;
        text-decoration: none;
        font-family: Calibri, sans-serif;
        text-align: center,
            vertical-align:middle;
    }

    thead {
        background-color: gray;
    }

    tfoot {
        background-color: lightgray;
    }
</style>

<body style="font-family:'Calibri',sans-serif;">
    <header name="page-header">
        <!-- Header del PDF -->
        <img src="{{ storage_path('fondo/logonew.png') }}" style="max-width: 105px;float: left;">
        <div style="max-width:110px;float: right;">
            <img src="{{ storage_path('fondo/logopdf.png') }}" style="max-width: 58px;">
        </div>
        <p style="margin:1px;text-align:center;">
            <strong><span style="font-size:20px;">REPORTE DE LISTADO DE ARTICULOS DE INVENTARIO<br>&nbsp;</strong>
        </p>
        <p style="margin:1px;text-align:center;">
            <span style="font-size:17px;">MES: <strong><u> {{ $mes }} </u> </strong>
                <span style="font-size:17px;">PERIODO: <strong><u> {{ $anio }} </u> </strong>
        </p>
    </header>
    <br>
    <!----------------------------------- Requisicion de producto --------------------------------------------------------------------->
    <section>

        @foreach ($reporte as $item)
            <table style="width:30%;">

                <tbody>
                    <tr>
                        <td colspan="1" style="font-size:13px;font-weight:700">{{ $item['codigoPresupuestario'] }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <table style="width:80%;">
                <tbody>
                    <tr>
                        <td colspan="1" style="font-size:13px;font-weight:700">{{ $item['descripRubro'] }}</td>
                    </tr>
                </tbody>
            </table>
            </br>
            <table style="width:100%;">
                <thead>
                    <tr>
                        <td style="width:50pt;"><b>Codigo</b></td>
                        <td style="width:144pt;"><b>Descripcion</b></td>
                        <td style="width:50pt;"><b>Existencia</b></td>
                        <td style="width:60pt;"><b>U/Medida</b></td>
                        <td style="width:50pt;"><b>P.Prom</b></td>
                        <td style="width:50pt;"><b>Total</b></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($item['productos'] as $itemP)
                        <tr>
                            <td>{{ $itemP['codProducto'] }}</td>
                            <td>{{ $itemP['descripcion'] }}</td>
                            <td>{{ $itemP['existencias'] }}</td>
                            <td>{{ $itemP['nombreMedida'] }}</td>
                            <td>${{ number_format($itemP['precio_promedio'], 2, '.', '')}}</td>
                            <td>${{ number_format($itemP['total'] , 2) }}</td>
                        </tr>
                    @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" style="font-weight:700">Total por especifico</td>
                        <td colspan="1" style="font-weight:700">${{ number_format($item['totalSum'], 2, '.', '') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
            </br>
        @endforeach

        <div>TOTAL GENERAL ---------------------------------------------------------------------------------------------
            ${{ number_format($sumaGeneral, 2, '.', '') }}</div>

    </section>
</body>

</html>

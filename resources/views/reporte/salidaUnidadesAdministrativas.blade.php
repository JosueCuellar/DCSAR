<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Salidas por Unidades</title>
</head>

<style>
    table {
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1.0px solid black;
    }

    td {
        color: black;
        font-size: 11px;
        font-weight: 450;
        font-style: normal;
        text-decoration: none;
        font-family: Calibri, sans-serif;
        text-align: center,
            vertical-align:middle;
    }

    thead {
        background-color: gray;
        text-align: center;
    }

    tfoot {
        background-color: lightgray;
        text-align: center;
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
            <strong><span style="font-size:17px;">REPORTE DE TOTALES POR UNIDADES ADMINISTRATIVAS<br>&nbsp;</strong>
        </p>
        <p style="margin:0.5px;text-align:center;">
            <strong><span style="font-size:15px;">UNIDAD DE ALMACÉN<br>&nbsp;</strong>
        </p>
        <p style="margin:1px;text-align:center;">
            <span style="font-size:15px;">MES: <strong><u> {{ $mes }} </u> </strong>
                <span style="font-size:15px;">PERIODO: <strong><u> {{ $anio }} </u> </strong>
        </p>
    </header>
    <br>
    <!----------------------------------- Requisicion de producto --------------------------------------------------------------------->
    <section>
        @foreach ($reporte as $item)
            <p style="margin:1px;">
                <span style="font-size:15px;"><b><u>{{ $item['nombreUnidadOrganizativa'] }}</u></b></span>
            </p>
            <br>
						<table style="border:none;border-collapse:collapse;width:90%; margin: auto;">
                <tbody>
                    <thead>
                        <td>Descripción</td>
                        <td>Cantidad</td>
                        <td>Total</td>
                    </thead>
                    @foreach ($item['productos'] as $itemP)
                        <tr>
                            <td> {{ $itemP['descripcion'] }}</td>
                            <td style="text-align: center;"> {{ $itemP['total_cantidad'] }}</td>
                            <td style="text-align: center;"> {{ number_format($itemP['total'] , 2) }}</td>
                        </tr>
                    @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2"><b>TOTAL</b></td>
                        <td>{{ number_format($item['total'], 2, '.', '') }}</td>
                    </tr>
                </tfoot>

            </table>
            <br>
        @endforeach
    </section>
</body>

</html>

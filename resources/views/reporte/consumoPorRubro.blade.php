<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consumo por Rubro</title>
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
        font-size: 8.5px;
        font-weight: 450;
        text-align: center;
        font-style: normal;
        text-decoration: none;
        font-family: Calibri, sans-serif;
        text-align: center,
            vertical-align:middle;
    }

    tfoot {
        background-color: lightgray;
    }

    td.empty-cell {
        visibility: hidden;
    }

    .sin-bordes {
        border-bottom: none;
        border-right: none;
        border-left: none;
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
            <strong><span style="font-size:17px;">REPORTE DE CONSUMOS DE ARTICULOS POR ESPECIFICOS<br>&nbsp;</strong>
        </p>
        <p style="margin:1px;text-align:center;">
            <span style="font-size:15px;">DEL MES DE: <strong><u> {{ $mes_inicio }} </u> </strong>
                <span style="font-size:15px;">AL MES DE: <strong><u> {{ $mes_final }} </u> </strong>
        </p>
        <p style="font-size: 14px; font-style: italic;"><strong><u>{{ $rubro }}</u> </strong></p>
    </header>

    <!----------------------------------- Requisicion de producto --------------------------------------------------------------------->
    <section>

        <table style="width: 100%">
            <thead>
                <tr>
                    <td class="empty-cell"><br></td>
                    @foreach ($months as $item)
                        <td colspan="2">{{ $item }}</td>
                    @endforeach
                    <td style="background-color: lightgray; color: red;" colspan="2">TOTAL</td>

                </tr>
            </thead>
            <tbody>
                <tr style="background-color: lightgray;">
                    <td class="empty-cell"><br></td>
                    @foreach ($months as $item)
                        <td>Salidas</td>
                        <td>Total ($)</td>
                    @endforeach

                    <td style="background-color: lightgray; color: red;">Salidas</td>
                    <td style="background-color: lightgray; color: red;">Total ($)</td>
                </tr>

                @foreach ($reporte as $item)
                    <tr>
                        <td>{{ $item['descripcion'] }} </td>

                        @foreach ($item['product_data'] as $itemP)
                            <td>{{ $itemP->cantidad_productos }}</td>
                            <td>{{ number_format($itemP->total, 2) }}</td>
                        @endforeach

                        <td style="color: red;">{{ $item['totalSalidas'] }} </td>
                        <td style="color: red;">{{ number_format($item['total'], 2, '.', '') }} </td>
                    </tr>
                @endforeach

            </tbody>
            <tr>
                <td>Total</td>
                @foreach ($months as $month)
                    @php
                        $sum = 0;
                        foreach ($reporte as $item) {
                            foreach ($item['product_data'] as $itemP) {
                                if ($itemP->month_name == $month) {
                                    $sum += $itemP->total;
                                }
                            }
                        }
                    @endphp
                    <td><br></td>
                    <td style="background-color: lightgray;">{{ number_format($sum, 2, '.', '') }}</td>
                @endforeach

                @php
                    $sumTotal = 0;
                    foreach ($reporte as $item) {
                        $sumTotal += $item['total'];
                    }
                @endphp
                <td><br></td>

                <td style="background-color: lightgray; color: red;">{{ number_format($sumTotal, 2, '.', '') }}</td>
            </tr>

        </table>



    </section>
</body>

</html>

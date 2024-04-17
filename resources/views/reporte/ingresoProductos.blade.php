<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ingreso productos</title>
</head>

<style>
    #tableHead span {
        font-size: 12px;
    }

    #tableHead thead td {
        border-width: 1pt 1pt 1.5pt;
        border-style: solid;
        border-color: windowtext;
        background: rgb(201, 201, 201);
        padding: 0in 5.4pt;
        height: 15.75pt;
        vertical-align: top;
    }

    #tableHead tbody td {
        border-width: 1pt 1pt 1.5pt;
        border-style: solid;
        padding: 0in 5.4pt;
        height: 15pt;
        vertical-align: top;
    }

    #tableHead tfoot td {
        border-width: 1pt 1pt 1.5pt;
        border-style: solid;
        padding: 0in 5.4pt;
        height: 15pt;
        vertical-align: top;
    }

    #tableHead td {
        border-width: 1pt 1pt 1.5pt;
        border-style: solid;
        border-color: windowtext;
        padding: 0in 5.4pt;
        height: 15.75pt;
        vertical-align: top;
        border-width: 1pt 1pt 1.5pt;
        border-style: solid;
        border-left: none;
        border-bottom: 1.5pt solid windowtext;
        border-right: 1pt solid windowtext;
        padding: 0in 5.4pt;
        height: 15.75pt;
        vertical-align: top;
    }

    #tableHead tr td p {
        margin-top: 0in;
        margin-right: 0in;
        margin-bottom: 0in;
        margin-left: 0in;
        line-height: normal;
        font-size: 15px;
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
        <p style="margin:2px;text-align:center;"><strong><span style="font-size:20px;">UNIDAD
                    ALMACEN<br>&nbsp;</strong><strong><span style="font-size:15px; opacity: 70%">INGRESO
                    DE BIENES O SUMINISTROS</strong></p>
    </header>
    <br>
    <!----------------------------------- Ingreso  de producto --------------------------------------------------------------------->
    <section>
        <!----------------------------------- Header del Ingreso --------------------------------------------------------------------->
        <table style="width:100%;font-size: 13px">
            <tbody>
                <tr>
                    <td colspan="4"><strong><span>Numero de envio:</span></strong>
                        {{ $recepcionCompra->nOrdenCompra }}</td>
                    <td colspan="8" style="text-align: left;"><strong><span>Fecha de ingreso:
                            </span></strong></span></strong> {{ $recepcionCompra->fechaIngreso }}</td>
                </tr>
                <tr>
                    <td><strong><span>Proveedor: </span></strong> {{ $recepcionCompra->proveedor->nombreComercial }}
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <!----------------------------------- Header de la tabla de los detalles --------------------------------------------------------------------->
        <table id="tableHead" style="border-collapse:collapse;border:none;">
            <tbody>
                <thead>
                    <tr>
                        <td style="width:10.95pt;">
                            <p>
                                <strong><em><span>N</span></em></strong>
                            </p>
                        </td>
                        <td style="width: 50.8pt;">
                            <p>
                                <strong><em><span>Cod. Art</span></em></strong>
                            </p>
                        </td>
                        <td style="width: 25.5pt; ">
                            <p>
                                <strong><em><span>Cant.</span></em></strong>
                            </p>
                        </td>
                        <td style="width: 75pt;">
                            <p>
                                <strong><em><span>U. Medida</span></em></strong>
                            </p>
                        </td>
                        <td style="width: 195pt">
                            <p>
                                <strong><em><span>Descripci&oacute;n</span></em></strong>
                            </p>
                        </td>
                        <td style="width: 58.5pt;">
                            <p>
                                <strong><em><span>P. Unitario</span></em></strong>
                            </p>
                        </td>
                        <td style="width: 52.95pt;">
                            <p>
                                <strong><em><span>Sub Total</span></em></strong>
                            </p>
                        </td>
                    </tr>
                </thead>
            <tbody>
                @php
                    $n = 0;
                @endphp
                @foreach ($detalle_compra as $item)
                    <tr>
                        <td>
                            <p>
                                <strong><span>{{ $n = $n + 1 }}</span></strong>
                            </p>
                        </td>
                        <td>
                            <p>
                                <span>{{ $item->producto->codProducto }}</span>
                            </p>
                        </td>
                        <td>
                            <p>
                                <span>{{ $item->cantidadIngreso }}</span>
                            </p>
                        </td>
                        <td>
                            <p>
                                <span>{{ $item->producto->medida->nombreMedida }}</span>
                            </p>
                        </td>
                        <td>
                            <p>
                                <span>{{ $item->producto->descripcion }}</span>
                            </p>
                        </td>
                        <td>
                            <p>
                                <span>${{ number_format($item->producto->costoPromedio, 2) }}</span>
                            </p>
                        </td>
                        <td>
                            <p>
                                <span>${{ number_format($item->total, 2) }}</span>
                            </p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6">
                        <p>
                            <em><span>Total</span></em>
                        </p>
                    </td>
                    <td>
                        <p>
                            <strong><em><span>${{ number_format($totalFinal, 2) }}</span></em></strong>
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table><br>
    </section>


</body>

</html>

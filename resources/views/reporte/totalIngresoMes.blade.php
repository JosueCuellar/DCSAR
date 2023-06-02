<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PDF</title>
</head>
<body style="font-family:'Calibri',sans-serif;">
    <header name="page-header">
        <!-- Header del PDF -->
        <img src="{{ asset('fondo/logonew.png') }}" style="max-width: 105px;float: left;">
        <div style="max-width:110px;float: right;">
            <img src="{{ asset('fondo/logopdf.png') }}" style="max-width: 58px;">
        </div>
        <p style="margin:2px;text-align:center;">
            <strong><span style="font-size:20px;">UNIDAD ALMACEN<br>&nbsp;</strong>
            <strong><span style="font-size:15px; opacity: 70%">INFORME TOTAL INGRESOS</strong>
        </p>
        <p style="margin:2px;text-align:center;">
            <span style="font-size:17px;">MES: <strong><u> {{$mes}}  </u> </strong>
            <span style="font-size:17px;">PERIODO: <strong><u> {{$anio}} </u> </strong>
        </p>
    </header>
    <br>
    <!----------------------------------- Requisicion de producto --------------------------------------------------------------------->
    <section>
        <!----------------------------------- Header de la tabla de los detalles --------------------------------------------------------------------->
        <table style="border-collapse:collapse;border:none;">
            <tbody>
                <thead>
                    <tr>
                        <td
                            style="width:100pt;border-width: 1pt 1pt 1.5pt;border-style: solid;border-color: windowtext;border-image: initial;background: rgb(201, 201, 201);padding: 0in 5.4pt;height: 15.75pt;vertical-align: top;">
                            <p
                                style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;text-align:center;">
                                <strong><em><span style="font-size:12px;color:black;">Especifico</span></em></strong>
                            </p>
                        </td>
                        <td
                            style="width: 330pt;border-width: 1pt 1pt 1.5pt;border-style: solid;border-left: none;border-bottom: 1.5pt solid windowtext;border-right: 1pt solid windowtext;background: rgb(201, 201, 201);padding: 0in 5.4pt;height: 15.75pt;vertical-align: top;">
                            <p
                                style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;text-align:center;">
                                <strong><em><span
                                            style="font-size:12px;color:black;">Descripci&oacute;n</span></em></strong>
                            </p>
                        </td>
                        <td
                            style="width: 70pt;border-width: 1pt 1pt 1.5pt;border-style: solid;border-left: none;border-bottom: 1.5pt solid windowtext;border-right: 1pt solid windowtext;background: rgb(201, 201, 201);padding: 0in 5.4pt;height: 15.75pt;vertical-align: top;">
                            <p
                                style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;text-align:center;">
                                <strong><em><span style="font-size:12px;color:black;">Total</span></em></strong>
                            </p>
                        </td>
                    </tr>
                </thead>
            <tbody>
                @foreach ($reporteTotalIngreso as $item)
                    <tr>
                        <td
                            style="border-width: 1pt 1pt 1.5pt;border-style: solid;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 15pt;vertical-align: top;">
                            <p
                                style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;text-align:center;">
                                <strong><span
                                        style="font-size:12px;color:black;">{{ $item->codigopresupuestario }}</span></strong>
                            </p>
                        </td>
                        <td
                            style="border-width: 1pt 1pt 1.5pt;border-style: solid;padding: 0in 5.4pt;height: 15pt;vertical-align: top;">
                            <p
                                style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;text-align:center;">
                                <span style="font-size:12px;color:black;">{{ $item->descriprubro }}</span>
                            </p>
                        </td>
                        <td
                            style="border-width: 1pt 1pt 1.5pt;border-style: solid;padding: 0in 5.4pt;height: 15pt;vertical-align: top;">
                            <p
                                style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;text-align:center;">
                                <span style="font-size:12px;color:black;">${{ $item->sumaTotal }}</span>
                            </p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"
                        style="border-width: 1pt 1pt 1.5pt;border-style: solid;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 15.75pt;vertical-align: top;">
                        <p
                            style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;">
                            <em><span style="font-size:12px;color:black;">Total</span></em>
                        </p>
                    </td>
                    <td
                        style="border-width: 1pt 1pt 1.5pt;border-style: solid;padding: 0in 5.4pt;height: 15.75pt;vertical-align: top;">
                        <p
                            style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;text-align:center;">
                            <strong><em><span
                                        style="font-size:12px;color:black;">${{ $totalFinal }}</span></em></strong>
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table><br>
    </section>
    {{-- <!----------------------------------- Firma --------------------------------------------------------------------->
    <div id="footer">
        <table style="width:463.5pt;border-collapse:collapse;border:none;">
            <tbody>
                <tr>
                    <td
                        style="width: 75pt;border: 1pt solid windowtext;padding: 0in 5.4pt;height: 50pt;vertical-align: top;">
                    </td>
                </tr>
                <tr>
                    <td style="width:75pt;padding:0in 5.4pt 0in 5.4pt;height:15.75pt;">
                        <p
                            style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;">
                            <strong><span style="font-size:13px;color:black;">Nombre quien entrega:</span></strong>
                        </p>
                    </td>
                    <td
                        style="width:75pt;border-top:0.0pt;border-left:0.0pt;border-bottom:1.0pt;border-right:0.0pt;border-color:windowtext;border-style:solid;padding:0in 5.4pt 0in 5.4pt;height:3.0pt;">
                        <p
                            style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;">
                            <span style="font-size:13px;color:black;">____________________________</span>
                        </p>
                    </td>
                    <td style="width:.15in;padding:0in 5.4pt 0in 5.4pt;height:15.75pt;"><br></td>
                    <td style="width:75pt;padding:0in 5.4pt 0in 5.4pt;height:15.75pt;">
                        <p
                            style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;">
                            <strong><span style="font-size:13px;color:black;">Nombre quien recibe:</span></strong>
                        </p>
                    </td>
                    <td
                        style="width:75pt;border-top:0.0pt;border-left:0.0pt;border-bottom:1.0pt;border-right:0.0pt;border-color:windowtext;border-style:solid;padding:0in 5.4pt 0in 5.4pt;height:3.0pt;">
                        <p
                            style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;">
                            <span style="font-size:13px;color:black;">____________________________</span>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
                <tr>
                    <td style="width:75pt;padding:0in 5.4pt 0in 5.4pt;height:15.75pt;">
                        <p
                            style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;">
                            <strong><span style="font-size:13px;color:black;">Firma</span></strong>
                        </p>
                    </td>
                    <td
                        style="width:75pt;border:none;border-bottom:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:15.75pt;">
                        <p
                            style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;">
                            <span style="font-size:13px;color:black;">____________________________</span>
                        </p>
                    </td>
                    <td style="width:.15in;padding:0in 5.4pt 0in 5.4pt;height:15.75pt;"><br></td>
                    <td style="width:75pt;padding:0in 5.4pt 0in 5.4pt;height:15.75pt;">
                        <p
                            style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;">
                            <strong><span style="font-size:13px;color:black;">Firma</span></strong>
                        </p>
                    </td>
                    <td
                        style="width:75pt;border:none;border-bottom:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:15.75pt;">
                        <p
                            style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;">
                            <span style="font-size:13px;color:black;">____________________________</span>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div> --}}
</body>
</html>

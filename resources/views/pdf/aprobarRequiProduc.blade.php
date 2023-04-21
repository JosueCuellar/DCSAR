<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PDF</title>
</head>
<body>
    <header name="page-header">
        <!-- Header del PDF -->
        <p style='margin:1px;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><strong><span
                    style="font-size:22px;">Requisición de Materiales y Suministros de Oficina</span></strong></p>
    </header>
    <br>
                    <!----------------------------------- Requisicion de producto --------------------------------------------------------------------->

    <section>
                    <!----------------------------------- Header de la requisicion --------------------------------------------------------------------->

        <table style="border: none;width:463.25pt;border-collapse:collapse;">
            <tbody>
                <tr>
                    <td
                        style="width:112.25pt;border-top:1.0pt;border-left:1.0pt;border-bottom:2.25pt;border-right:1.5pt;padding:0in 5.4pt 0in 5.4pt;height:  16.5pt;">
                        <p
                            style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'>
                            <strong><span style="font-size:12px;color:black;">Numero de envio:</span></strong>
                        </p>
                    </td>
                    <td
                        style="width:44.6pt;border:solid windowtext 1.0pt;border-left:none;padding:0in 5.4pt 0in 5.4pt;height:16.5pt;">
                        <p
                            style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:right;'>
                            <strong><span
                                    style="font-size:12px;color:black;">{{ $requisicionProducto->nCorrelativo }}</span></strong>
                        </p>
                    </td>
                    <td
                        style="width:148.9pt;border-top:solid windowtext 1.0pt;border-left:none;border-bottom:none;border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:16.5pt;">
                        <br>
                    </td>
                    <td
                        style="width:75pt;border-top:solid windowtext 1.0pt;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;padding:0in 5.4pt 0in 5.4pt;height:16.5pt;">
                        <p
                            style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'>
                            <strong><span style="font-size:12px;color:black;">Fecha / Licitacion:</span></strong>
                        </p>
                    </td>
                    <td
                        style="width:1.5in;border:solid windowtext 1.0pt;border-left:none;padding:0in 5.4pt 0in 5.4pt;height:16.5pt;">
                        <p
                            style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'>
                            <strong><span
                                    style="font-size:12px;color:black;">{{ $requisicionProducto->fechaRequisicion }}</span></strong>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td
                        style="width:112.25pt;border-top:0.0pt;border-left:0.0pt;border-bottom:2.0pt;border-right:0.0pt;border-color:windowtext;border-style:solid;padding:0in 5.4pt 0in 5.4pt;height:3.0pt;">
                        <p
                            style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'>
                            <strong><span style="font-size:12px;color:black;">CLIENTE:</span></strong>
                        </p>
                    </td>
                    <td colspan="4"
                        style="width:351.0pt;border-top:0.0pt;border-left:0.0pt;border-bottom:2.0pt;border-right:0.0pt;border-color:windowtext;border-style:  solid;padding:0in 5.4pt 0in 5.4pt;height:3.0pt;">
                        <p
                            style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'>
                            <strong><u><span style="font-size:12px;color:black;">Unidad Organizativa</span></u></strong>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>

        <p
            style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'>
            <span style="font-size:12px;line-height:107%;">&nbsp;</span>
        </p>
                    <!----------------------------------- Header de la tabla de los detalles --------------------------------------------------------------------->

        <table style="width:462.2pt;border-collapse:collapse;border:none;">
            <tbody>

                <thead>
                    <tr>
                        <td
                            style="width:10.95pt;border-width: 1pt 1pt 1.5pt;border-style: solid;border-color: windowtext;border-image: initial;background: rgb(201, 201, 201);padding: 0in 5.4pt;height: 15.75pt;vertical-align: top;">
                            <p
                                style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'>
                                <strong><em><span style="font-size:12px;color:black;">N</span></em></strong>
                            </p>
                        </td>
                        <td
                            style="width: 50.8pt;border-width: 1pt 1pt 1.5pt;border-style: solid;border-left: none;border-bottom: 1.5pt solid windowtext;border-right: 1pt solid windowtext;background: rgb(201, 201, 201);padding: 0in 5.4pt;height: 15.75pt;vertical-align: top;">
                            <p
                                style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'>
                                <strong><em><span style="font-size:12px;color:black;">Cod. Art</span></em></strong>
                            </p>
                        </td>
                        <td
                            style="width: 25.5pt;border-width: 1pt 1pt 1.5pt;border-style: solid;border-left: none;border-bottom: 1.5pt solid windowtext;border-right: 1pt solid windowtext;background: rgb(201, 201, 201);padding: 0in 5.4pt;height: 15.75pt;vertical-align: top;">
                            <p
                                style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'>
                                <strong><em><span style="font-size:12px;color:black;">Cant.</span></em></strong>
                            </p>
                        </td>
                        <td
                            style="width: 75pt;border-width: 1pt 1pt 1.5pt;border-style: solid;border-left: none;border-bottom: 1.5pt solid windowtext;border-right: 1pt solid windowtext;background: rgb(201, 201, 201);padding: 0in 5.4pt;height: 15.75pt;vertical-align: top;">
                            <p
                                style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'>
                                <strong><em><span style="font-size:12px;color:black;">U. Medida</span></em></strong>
                            </p>
                        </td>
                        <td
                            style="width: 195pt;border-width: 1pt 1pt 1.5pt;border-style: solid;border-left: none;border-bottom: 1.5pt solid windowtext;border-right: 1pt solid windowtext;background: rgb(201, 201, 201);padding: 0in 5.4pt;height: 15.75pt;vertical-align: top;">
                            <p
                                style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'>
                                <strong><em><span
                                            style="font-size:12px;color:black;">Descripci&oacute;n</span></em></strong>
                            </p>
                        </td>
                        <td
                            style="width: 58.5pt;border-width: 1pt 1pt 1.5pt;border-style: solid;border-left: none;border-bottom: 1.5pt solid windowtext;border-right: 1pt solid windowtext;background: rgb(201, 201, 201);padding: 0in 5.4pt;height: 15.75pt;vertical-align: top;">
                            <p
                                style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'>
                                <strong><em><span style="font-size:12px;color:black;">P. Unitario</span></em></strong>
                            </p>
                        </td>
                        <td
                            style="width: 52.95pt;border-width: 1pt 1pt 1.5pt;border-style: solid;border-left: none;border-bottom: 1.5pt solid windowtext;border-right: 1pt solid windowtext;background: rgb(201, 201, 201);padding: 0in 5.4pt;height: 15.75pt;vertical-align: top;">
                            <p
                                style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'>
                                <strong><em><span style="font-size:12px;color:black;">Sub Total</span></em></strong>
                            </p>
                        </td>
                    </tr>
                </thead>

            <tbody>
                @php
                    $n = 0;
                @endphp
                @foreach ($detalle_requisicion as $item)
                    <tr>
                        <td
                            style="width: 10.95pt;border-width: 1pt 1pt 1.5pt;border-style: solid;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 15pt;vertical-align: top;">
                            <p
                                style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'>
                                <strong><span style="font-size:12px;color:black;">{{ $n = $n + 1 }}</span></strong>
                            </p>
                        </td>
                        <td
                            style="width: 50.8pt;border-width: 1pt 1pt 1.5pt;border-style: solid;padding: 0in 5.4pt;height: 15pt;vertical-align: top;">
                            <p
                                style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'>
                                <span style="font-size:12px;color:black;">{{ $item->producto->codProducto }}</span>
                            </p>
                        </td>
                        <td
                            style="width: 25.5pt;border-width: 1pt 1pt 1.5pt;border-style: solid;padding: 0in 5.4pt;height: 15pt;vertical-align: top;">
                            <p
                                style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'>
                                <span style="font-size:12px;color:black;">{{ $item->cantidad }}</span>
                            </p>
                        </td>
                        <td
                            style="width: 75pt;border-width: 1pt 1pt 1.5pt;border-style: solid;padding: 0in 5.4pt;height: 15pt;vertical-align: top;">
                            <p
                                style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'>
                                <span
                                    style="font-size:12px;color:black;">{{ $item->producto->medida->nombreMedida }}</span>
                            </p>
                        </td>

                        <td
                            style="width: 195pt;border-width: 1pt 1pt 1.5pt;border-style: solid;padding: 0in 5.4pt;height: 15pt;vertical-align: top;">
                            <p
                                style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'>
                                <span style="font-size:12px;color:black;">{{ $item->producto->descripcion }}</span>
                            </p>
                        </td>
                        <td
                            style="width: 58.5pt;border-width: 1pt 1pt 1.5pt;border-style: solid;padding: 0in 5.4pt;height: 15pt;vertical-align: top;">
                            <p
                                style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'>
                                <span style="font-size:12px;color:black;">${{ $item->producto->costoPromedio }}</span>
                            </p>
                        </td>


                        <td
                            style="width: 52.95pt;border-width: 1pt 1pt 1.5pt;border-style: solid;padding: 0in 5.4pt;height: 15pt;vertical-align: top;">
                            <p
                                style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'>
                                <span style="font-size:12px;color:black;">${{ $item->total }}</span>
                            </p>
                        </td>

                    </tr>
                @endforeach



            </tbody>


            <tfoot>


                <tr>
                    <td colspan="6"
                        style="width: 409.25pt;border-width: 1pt 1pt 1.5pt;border-style: solid;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 15.75pt;vertical-align: top;">
                        <p
                            style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'>
                            <em><span style="font-size:12px;color:black;">Total</span></em>
                        </p>
                    </td>
                    <td
                        style="width: 52.95pt;border-width: 1pt 1pt 1.5pt;border-style: solid;padding: 0in 5.4pt;height: 15.75pt;vertical-align: top;">
                        <p
                            style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'>
                            <strong><em><span
                                        style="font-size:12px;color:black;">${{ $totalFinal }}</span></em></strong>
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table><br>

    </section>
    <section>
                            <!----------------------------------- Descripcion y Obervaciones --------------------------------------------------------------------->

        <table style="width:463.5pt;border-collapse:collapse;border:none;">
            <tbody>
                <tr>
                    <td
                        style="width: 463.5pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 15pt;vertical-align: top;">
                        <br>
                    </td>
                </tr>
                <tr>
                    <td
                        style="width: 463.5pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 15pt;vertical-align: top;">
                        <p
                            style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'>
                            <span style="font-size:13px;color:black;"><b>Observaci&oacute;n:</b></span>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td
                        style="width:540pt;border-top:0.0pt;border-left:0.0pt;border-bottom:1.0pt;border-right:0.0pt;border-color:windowtext;border-style:solid;padding:0in 5.4pt 0in 5.4pt;height:3.0pt;">
                        <span style="font-size:13px;color:black;">{{ $requisicionProducto->observacion }}</span>
                        <br>
                    </td>
                </tr>
            </tbody>
        </table>


                            <!----------------------------------- Firma --------------------------------------------------------------------->

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
                            style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'>
                            <strong><span style="font-size:13px;color:black;">Jefe Unidad Organizativa:</span></strong>
                        </p>
                    </td>
                    <td
                    style="width:75pt;border-top:0.0pt;border-left:0.0pt;border-bottom:1.0pt;border-right:0.0pt;border-color:windowtext;border-style:solid;padding:0in 5.4pt 0in 5.4pt;height:3.0pt;">
                    <p
                            style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'>
                            <span style="font-size:13px;color:black;">____________________________</span>
                        </p>
                    </td>
                    <td style="width:.15in;padding:0in 5.4pt 0in 5.4pt;height:15.75pt;"><br></td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
                <tr>
                    <td style="width:75pt;padding:0in 5.4pt 0in 5.4pt;height:15.75pt;">
                        <p
                            style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'>
                            <strong><span style="font-size:13px;color:black;">Firma</span></strong>
                        </p>
                    </td>
                    <td
                        style="width:75pt;border:none;border-bottom:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:15.75pt;">
                        <p
                            style='margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'>
                            <span style="font-size:13px;color:black;">____________________________</span>
                        </p>
                    </td>
                    <td style="width:.15in;padding:0in 5.4pt 0in 5.4pt;height:15.75pt;"><br></td>
                </tr>
            </tbody>
        </table>

    </section>
    <br>


</body>

</html>

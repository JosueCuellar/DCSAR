<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Comprobante requisicion</title>
</head>

<body style="font-family:'Calibri',sans-serif;">
    <header name="page-header">
        <!-- Header del PDF -->
        <img src="{{ asset('fondo/logonew.png') }}" style="max-width: 105px;float: left;">
        <div style="max-width:110px;float: right;">
            <img src="{{ asset('fondo/logopdf.png') }}" style="max-width: 58px;">
        </div>
        <p style="margin:2px;text-align:center;"><strong><span style="font-size:20px;">UNIDAD
                    ALMACEN<br>&nbsp;</strong><strong><span style="font-size:15px; opacity: 70%">COMPROBANTE DE SALIDA
                    DE BIENES O SUMINISTROS</strong></p>
    </header>
    <br>
    <!----------------------------------- Requisicion de producto --------------------------------------------------------------------->
    <section>
        <!----------------------------------- Header de la requisicion --------------------------------------------------------------------->
				<br>
        <table style="width:100%;font-size: 13px;font-family:'Calibri',sans-serif;">
            <tbody>
                <tr>
                    <td colspan="4"><strong><span>Numero de envio:</span></strong>
                        {{ $requisicionProducto->nCorrelativo }}</td>
                    <td colspan="8" style="text-align: left;"><strong><span>Fecha / Licitacion:
                            </span></strong></span></strong> {{ $requisicionProducto->fechaRequisicion }}</td>
                </tr>
                <tr>
                    <td><strong><span>CLIENTE: </span></strong>
                        {{ $requisicionProducto->user->unidadOrganizativa->nombreUnidadOrganizativa ?? '' }}
                    </td>
                </tr>
            </tbody>
        </table>
  <hr>
        <!----------------------------------- Header de la tabla de los detalles --------------------------------------------------------------------->
        <table style="border-collapse:collapse;border:none;">
            <tbody>
                <thead>
                    <tr>
                        <td
                            style="width:10.95pt;border-width: 1pt 1pt 1.5pt;border-style: solid;border-color: windowtext;border-image: initial;background: rgb(201, 201, 201);padding: 0in 5.4pt;height: 15.75pt;vertical-align: top;">
                            <p
                                style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;text-align:center;">
                                <strong><em><span style="font-size:12px;color:black;">N</span></em></strong>
                            </p>
                        </td>
                        <td
                            style="width: 50.8pt;border-width: 1pt 1pt 1.5pt;border-style: solid;border-left: none;border-bottom: 1.5pt solid windowtext;border-right: 1pt solid windowtext;background: rgb(201, 201, 201);padding: 0in 5.4pt;height: 15.75pt;vertical-align: top;">
                            <p
                                style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;text-align:center;">
                                <strong><em><span style="font-size:12px;color:black;">Cod. Art</span></em></strong>
                            </p>
                        </td>
                        <td
                            style="width: 25.5pt;border-width: 1pt 1pt 1.5pt;border-style: solid;border-left: none;border-bottom: 1.5pt solid windowtext;border-right: 1pt solid windowtext;background: rgb(201, 201, 201);padding: 0in 5.4pt;height: 15.75pt;vertical-align: top;">
                            <p
                                style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;text-align:center;">
                                <strong><em><span style="font-size:12px;color:black;">Cant.</span></em></strong>
                            </p>
                        </td>
                        <td
                            style="width: 75pt;border-width: 1pt 1pt 1.5pt;border-style: solid;border-left: none;border-bottom: 1.5pt solid windowtext;border-right: 1pt solid windowtext;background: rgb(201, 201, 201);padding: 0in 5.4pt;height: 15.75pt;vertical-align: top;">
                            <p
                                style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;text-align:center;">
                                <strong><em><span style="font-size:12px;color:black;">U. Medida</span></em></strong>
                            </p>
                        </td>
                        <td
                            style="width: 195pt;border-width: 1pt 1pt 1.5pt;border-style: solid;border-left: none;border-bottom: 1.5pt solid windowtext;border-right: 1pt solid windowtext;background: rgb(201, 201, 201);padding: 0in 5.4pt;height: 15.75pt;vertical-align: top;">
                            <p
                                style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;text-align:center;">
                                <strong><em><span
                                            style="font-size:12px;color:black;">Descripci&oacute;n</span></em></strong>
                            </p>
                        </td>
                        <td
                            style="width: 58.5pt;border-width: 1pt 1pt 1.5pt;border-style: solid;border-left: none;border-bottom: 1.5pt solid windowtext;border-right: 1pt solid windowtext;background: rgb(201, 201, 201);padding: 0in 5.4pt;height: 15.75pt;vertical-align: top;">
                            <p
                                style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;text-align:center;">
                                <strong><em><span style="font-size:12px;color:black;">P. Unitario</span></em></strong>
                            </p>
                        </td>
                        <td
                            style="width: 52.95pt;border-width: 1pt 1pt 1.5pt;border-style: solid;border-left: none;border-bottom: 1.5pt solid windowtext;border-right: 1pt solid windowtext;background: rgb(201, 201, 201);padding: 0in 5.4pt;height: 15.75pt;vertical-align: top;">
                            <p
                                style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;text-align:center;">
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
                            style="border-width: 1pt 1pt 1.5pt;border-style: solid;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 15pt;vertical-align: top;">
                            <p
                                style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;text-align:center;">
                                <strong><span style="font-size:12px;color:black;">{{ $n = $n + 1 }}</span></strong>
                            </p>
                        </td>
                        <td
                            style="border-width: 1pt 1pt 1.5pt;border-style: solid;padding: 0in 5.4pt;height: 15pt;vertical-align: top;">
                            <p
                                style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;text-align:center;">
                                <span style="font-size:12px;color:black;">{{ $item->producto->codProducto }}</span>
                            </p>
                        </td>
                        <td
                            style="border-width: 1pt 1pt 1.5pt;border-style: solid;padding: 0in 5.4pt;height: 15pt;vertical-align: top;">
                            <p
                                style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;text-align:center;">
                                <span style="font-size:12px;color:black;">{{ $item->cantidad }}</span>
                            </p>
                        </td>
                        <td
                            style="border-width: 1pt 1pt 1.5pt;border-style: solid;padding: 0in 5.4pt;height: 15pt;vertical-align: top;">
                            <p
                                style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;text-align:center;">
                                <span
                                    style="font-size:12px;color:black;">{{ $item->producto->medida->nombreMedida }}</span>
                            </p>
                        </td>
                        <td
                            style="border-width: 1pt 1pt 1.5pt;border-style: solid;padding: 0in 5.4pt;height: 15pt;vertical-align: top;">
                            <p
                                style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;text-align:center;">
                                <span style="font-size:12px;color:black;">{{ $item->producto->descripcion }}</span>
                            </p>
                        </td>
                        <td
                            style="border-width: 1pt 1pt 1.5pt;border-style: solid;padding: 0in 5.4pt;height: 15pt;vertical-align: top;">
                            <p
                                style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;text-align:center;">
                                <span style="font-size:12px;color:black;">${{ $item->producto->costoPromedio }}</span>
                            </p>
                        </td>
                        <td
                            style="border-width: 1pt 1pt 1.5pt;border-style: solid;padding: 0in 5.4pt;height: 15pt;vertical-align: top;">
                            <p
                                style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;text-align:center;">
                                <span style="font-size:12px;color:black;">${{ $item->total }}</span>
                            </p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6"
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
    {{-- <section>
        <!----------------------------------- Descripcion y Obervaciones --------------------------------------------------------------------->
        <table style="width:463.5pt;border-collapse:collapse;border:none;">
            <tbody>
                <tr>
                    <td
                        style="width: 463.5pt;border: 1pt solid windowtext;padding: 0in 5.4pt;height: 15pt;vertical-align: top;">
                        <p
                            style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;">
                            <span style="font-size:13px;color:black;"><b>Descripci&oacute;n:</b></span>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td
                        style="width:540pt;border-top:0.0pt;border-left:0.0pt;border-bottom:1.0pt;border-right:0.0pt;border-color:windowtext;border-style:solid;padding:0in 5.4pt 0in 5.4pt;height:3.0pt;">
                        <span style="font-size:13px;color:black;">{{ $requisicionProducto->descripcion }}</span>
                        <br>
                    </td>
                </tr>
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
                            style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:0in;line-height:normal;font-size:15px;">
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
    </section> --}}
    <!----------------------------------- Firma --------------------------------------------------------------------->
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
    </div>
</body>

</html>

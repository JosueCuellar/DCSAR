<?php

namespace App\Http\Controllers;

use App\Models\DetalleRequisicion;
use App\Models\Producto;
use App\Models\RequisicionProducto;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Dompdf\Renderer\Page_Text_Renderers;
use Dompdf\FrameReflower\Text;



class PDFController extends Controller
{
    //

    //PDF comprobante de salida
    public function comprobanteRequiProductoPDF(RequisicionProducto $requisicionProducto)
    {
        $totalFinal = 0.0;
        $productos = Producto::all();


        $detalle_requisicion = DetalleRequisicion::where('requisicion_id', $requisicionProducto->id)->get();
        foreach ($detalle_requisicion as $item) {
            $totalFinal += $item->total;
        }
        $data = [
            'productos' => $productos,
            'detalle_requisicion' => $detalle_requisicion,
            'totalFinal' => $totalFinal,
            'requisicionProducto' => $requisicionProducto
        ];
        $pdf = PDF::loadView('pdf.requisicionProducto', $data);
        $pdf->setPaper('letter', 'portrait', 'auto');
        // 'letter' is letter size, 'portrait' is the orientation
        $pdf->render();

        $canvas = $pdf->getCanvas();

        // Agregar los números de página al pie de página

        // Obtener el objeto FontMetrics
        $fontMetrics = $pdf->getFontMetrics();
        $w = $canvas->get_width();
        $h = $canvas->get_height();

        // Agregar los números de página al pie de página
        $font = $fontMetrics->getFont("helvetica", "bold");
        $text = '           
        Página {PAGE_NUM} de {PAGE_COUNT}';
        $textWidth = $fontMetrics->getTextWidth($text, $font, 10);
        $x = $w - $textWidth - 150;
        $y = $h - 30;
        $canvas->page_text($x, $y, $text, $font, 10, array(0, 0, 0));
        // 'letter' is letter size, 'portrait' is the orientation
        return $pdf->stream($requisicionProducto->nCorrelativo . '.pdf');
    }

    public function aprobarRequiProductoPDF(RequisicionProducto $requisicionProducto)
    {
        $totalFinal = 0.0;
        $productos = Producto::all();


        $detalle_requisicion = DetalleRequisicion::where('requisicion_id', $requisicionProducto->id)->get();
        foreach ($detalle_requisicion as $item) {
            $totalFinal += $item->total;
        }
        $data = [
            'productos' => $productos,
            'detalle_requisicion' => $detalle_requisicion,
            'totalFinal' => $totalFinal,
            'requisicionProducto' => $requisicionProducto
        ];




        $pdf = PDF::loadView('pdf.aprobarRequiProduc', $data);
        $pdf->setPaper('letter', 'portrait', 'auto');
        // 'letter' is letter size, 'portrait' is the orientation
        $pdf->render();

        $canvas = $pdf->getCanvas();

        $fontMetrics = $pdf->getFontMetrics();
        $w = $canvas->get_width();
        $h = $canvas->get_height();

        // Agregar los números de página al pie de página
        $font = $fontMetrics->getFont("Calibri", "bold");
        $text = 'Página {PAGE_NUM} de {PAGE_COUNT}';
        $textWidth = $fontMetrics->getTextWidth($text, $font, 10);
        $x = $w - $textWidth - 150;
        $y = $h - 30;
        $canvas->page_text($x, $y, $text, $font, 10, array(0, 0, 0));
        $page_count = $canvas->get_page_count();

        return $pdf->stream($requisicionProducto->nCorrelativo . '.pdf');

    }

    
}

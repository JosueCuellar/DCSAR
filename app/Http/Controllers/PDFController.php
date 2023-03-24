<?php

namespace App\Http\Controllers;

use App\Models\DetalleRequisicion;
use App\Models\Producto;
use App\Models\RequisicionProducto;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;


class PDFController extends Controller
{
    //

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
        return $pdf->stream($requisicionProducto->nCorrelativo . '.pdf');
    }
}

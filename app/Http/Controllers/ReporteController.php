<?php

namespace App\Http\Controllers;


use App\Models\DetalleRequisicion;
use App\Models\Producto;
use App\Models\RequisicionProducto;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Dompdf\Renderer\Page_Text_Renderers;
use Dompdf\FrameReflower\Text;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\TemplateProcessor;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ReporteController extends Controller
{
	//
	public function index()
	{
		return view('reporte.index');
	}

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
		$pdf = PDF::loadView('reporte.requisicionProducto', $data);
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
		$text = 'Página {PAGE_NUM} de {PAGE_COUNT}';
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


		$pdf = PDF::loadView('reporte.aprobarRequiProduc', $data);
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

	// public function totalIngresoMes(Request $request)
	// {
	// 	$array = $request->session()->get('array');

	// 	$pdf = PDF::loadView('reporte.totalIngresoMes', $array);
	// 	$pdf->setPaper('letter', 'portrait', 'auto');
	// 	// 'letter' is letter size, 'portrait' is the orientation
	// 	$pdf->render();

	// 	$canvas = $pdf->getCanvas();

	// 	$fontMetrics = $pdf->getFontMetrics();
	// 	$w = $canvas->get_width();
	// 	$h = $canvas->get_height();

	// 	// Agregar los números de página al pie de página
	// 	$font = $fontMetrics->getFont("Calibri", "bold");
	// 	$text = 'Página {PAGE_NUM} de {PAGE_COUNT}';
	// 	$textWidth = $fontMetrics->getTextWidth($text, $font, 10);
	// 	$x = $w - $textWidth - 150;
	// 	$y = $h - 30;
	// 	$canvas->page_text($x, $y, $text, $font, 10, array(0, 0, 0));
	// 	$page_count = $canvas->get_page_count();

	// 	return $pdf->stream('xd' . '.pdf');
	// }

	public function totalIngresoMesPost(Request $request)
	{
		$fecha = $request->fechaInput;
		list($year, $month) = explode("-", $fecha);
		$totalFinal = 0;
		$formatted_number = 0;

		$resultados = DB::table('rubros')
			->join('productos', 'rubros.id', '=', 'productos.rubro_id')
			->join('detalle_compras', 'productos.id', '=', 'detalle_compras.producto_id')
			->join('recepcion_compras', 'detalle_compras.recepcion_compra_id', '=', 'recepcion_compras.id')
			->select('rubros.codigopresupuestario', 'rubros.descriprubro', DB::raw('sum(detalle_compras.total) as sumaTotal'))
			->whereMonth('recepcion_compras.fechaingreso', $month)
			->whereYear('recepcion_compras.fechaingreso', $year)
			->groupBy('rubros.codigopresupuestario', 'rubros.descriprubro')
			->get();

		foreach ($resultados as $item) {
			$totalFinal += $item->sumaTotal;
		}
		$formatted_number = number_format($totalFinal, 2, '.', '');
		// Crea una nueva instancia de la clase TemplateProcessor y carga tu plantilla
		$templateProcessor = new TemplateProcessor('plantillas/plantillaEntrada.docx');
		$cwd = "";

		// Clona la fila de la tabla y reemplaza los marcadores de posición con tus datos
		$templateProcessor->setValue('month', $month);
		$templateProcessor->setValue('year', $year);
		$templateProcessor->setValue('totalFinal', $formatted_number);
		$templateProcessor->cloneRowAndSetValues('codigopresupuestario', $resultados);

		// Guarda la plantilla poblada como un documento de Word
		$tempFile = $cwd . 'tempDoc/' . uniqid('PHPWord') . '.docx';
		$pdfTempFile = $cwd . 'pdfs/' . uniqid('PDF') . '.pdf';

		$templateProcessor->saveAs($tempFile);

		return response()->download($tempFile)->deleteFileAfterSend(true);
	}



	// public function totalSalidaMes(Request $request)
	// {
	// 	$array = $request->session()->get('array');

	// 	$pdf = PDF::loadView('reporte.totalSalidaMes', $array);
	// 	$pdf->setPaper('letter', 'portrait', 'auto');
	// 	// 'letter' is letter size, 'portrait' is the orientation
	// 	$pdf->render();

	// 	$canvas = $pdf->getCanvas();

	// 	$fontMetrics = $pdf->getFontMetrics();
	// 	$w = $canvas->get_width();
	// 	$h = $canvas->get_height();

	// 	// Agregar los números de página al pie de página
	// 	$font = $fontMetrics->getFont("Calibri", "bold");
	// 	$text = 'Página {PAGE_NUM} de {PAGE_COUNT}';
	// 	$textWidth = $fontMetrics->getTextWidth($text, $font, 10);
	// 	$x = $w - $textWidth - 150;
	// 	$y = $h - 30;
	// 	$canvas->page_text($x, $y, $text, $font, 10, array(0, 0, 0));
	// 	$page_count = $canvas->get_page_count();

	// 	return $pdf->stream('xd' . '.pdf');
	// }

	public function totalSalidaMesPost(Request $request)
	{

		$fecha = $request->fechaInput;
		list($year, $month) = explode("-", $fecha);
		$totalFinal = 0;
		$formatted_number = 0;

		$resultados = DB::table('rubros')
			->join('productos', 'rubros.id', '=', 'productos.rubro_id')
			->join('detalle_requisicions', 'productos.id', '=', 'detalle_requisicions.producto_id')
			->join('requisicion_productos', 'detalle_requisicions.requisicion_id', '=', 'requisicion_productos.id')
			->select('rubros.codigopresupuestario', 'rubros.descriprubro', DB::raw('sum(detalle_requisicions.total) as sumaTotal'))
			->whereMonth('requisicion_productos.fechaRequisicion', $month)
			->whereYear('requisicion_productos.fechaRequisicion', $year)
			->groupBy('rubros.codigopresupuestario', 'rubros.descriprubro')
			->get();


		foreach ($resultados as $item) {
			$totalFinal += $item->sumaTotal;
		}
		$formatted_number = number_format($totalFinal, 2, '.', '');
		// Crea una nueva instancia de la clase TemplateProcessor y carga tu plantilla
		$templateProcessor = new TemplateProcessor('plantillas/plantillaSalida.docx');
		$cwd = "";

		// Clona la fila de la tabla y reemplaza los marcadores de posición con tus datos
		$templateProcessor->setValue('month', $month);
		$templateProcessor->setValue('year', $year);
		$templateProcessor->setValue('totalFinal', $formatted_number);
		$templateProcessor->cloneRowAndSetValues('codigopresupuestario', $resultados);

		// Guarda la plantilla poblada como un documento de Word
		$tempFile = $cwd . 'tempDoc/' . uniqid('PHPWord') . '.docx';
		$pdfTempFile = $cwd . 'pdfs/' . uniqid('PDF') . '.pdf';

		$templateProcessor->saveAs($tempFile);

		return response()->download($tempFile)->deleteFileAfterSend(true);
	}
}

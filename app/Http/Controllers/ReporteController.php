<?php

namespace App\Http\Controllers;

use App\Http\Requests\reportesMensualesRequest;
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
		$array = [
			'reporteTotalIngreso' => $resultados,
			'totalFinal' => $formatted_number,
			'mes' => $month,
			'anio' => $year
		];

		$pdf = PDF::loadView('reporte.totalIngresoMes', $array);
		$pdf->setPaper('letter', 'portrait', 'auto');
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
		return $pdf->stream('xd' . '.pdf');
	}

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

		$array = [
			'reporteTotalSalida' => $resultados,
			'totalFinal' => $formatted_number,
			'mes' => $month,
			'anio' => $year
		];
		$pdf = PDF::loadView('reporte.totalSalidaMes', $array);
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

		return $pdf->stream('xd' . '.pdf');
	}

	public function listadoArticulos(Request $request)
	{
		$fecha = $request->fechaInput;
		list($year, $month) = explode("-", $fecha);

		$resultados = DB::table('rubros')
    ->join('productos', 'rubros.id', '=', 'productos.rubro_id')
    ->join('medidas', 'productos.medida_id', '=', 'medidas.id')
    ->select(
        'rubros.codigoPresupuestario',
        'rubros.descripRubro',
        'productos.codProducto',
        'productos.descripcion',
        'medidas.nombreMedida',
        DB::raw('COALESCE((SELECT SUM(cantidadIngreso) FROM detalle_compras WHERE producto_id = productos.id AND recepcion_compra_id IN (SELECT id FROM recepcion_compras WHERE YEAR(fechaIngreso) <= ? AND MONTH(fechaIngreso) <= ?)), 0) - COALESCE((SELECT SUM(cantidad) FROM detalle_requisicions WHERE producto_id = productos.id AND requisicion_id IN (SELECT id FROM requisicion_productos WHERE estado_id = 4 AND YEAR(fechaRequisicion) <= ? AND MONTH(fechaRequisicion) <= ?)), 0) AS existencias'),
        DB::raw('ROUND((COALESCE((SELECT SUM(total) FROM detalle_compras WHERE producto_id = productos.id AND recepcion_compra_id IN (SELECT id FROM recepcion_compras WHERE YEAR(fechaIngreso) <= ? AND MONTH(fechaIngreso) <= ?)), 0) - COALESCE((SELECT SUM(total) FROM detalle_requisicions WHERE producto_id = productos.id AND requisicion_id IN (SELECT id FROM requisicion_productos WHERE estado_id = 4 AND YEAR(fechaRequisicion) <= ? AND MONTH(fechaRequisicion) <= ?)), 0)) / (COALESCE((SELECT SUM(cantidadIngreso) FROM detalle_compras WHERE producto_id = productos.id AND recepcion_compra_id IN (SELECT id FROM recepcion_compras WHERE YEAR(fechaIngreso) <= ? AND MONTH(fechaIngreso)<=?)), 0) - COALESCE((SELECT SUM(cantidad) FROM detalle_requisicions WHERE producto_id = productos.id AND requisicion_id IN (SELECT id FROM requisicion_productos WHERE estado_id = 4 AND YEAR(fechaRequisicion)<=? AND MONTH(fechaRequisicion)<=?)),0)),2) AS precio_promedio'),
        DB::raw('(COALESCE((SELECT SUM(total) FROM detalle_compras WHERE producto_id = productos.id AND recepcion_compra_id IN (SELECT id FROM recepcion_compras WHERE YEAR(fechaIngreso)<=? AND MONTH(fechaIngreso)<=?)),0)-COALESCE((SELECT SUM(total) FROM detalle_requisicions WHERE producto_id=productos.id AND requisicion_id IN (SELECT id FROM requisicion_productos WHERE estado_id=4 AND YEAR(fechaRequisicion)<=? AND MONTH(fechaRequisicion)<=?)),0)) AS total')
    )
    ->groupBy('rubros.codigoPresupuestario', 'rubros.descripRubro', 'productos.codProducto', 'productos.descripcion', 'medidas.nombreMedida', 'productos.id')
    ->havingRaw('existencias > 0')
    ->setBindings([$year, $month, $year, $month, $year, $month, $year, $month, $year, $month, $year, $month, $year, $month, $year, $month])
    ->get();



		$groupedResults = [];
		foreach ($resultados as $row) {
			$codigoPresupuestario = $row->codigoPresupuestario;
			$descripRubro = $row->descripRubro;
			if (!isset($groupedResults[$codigoPresupuestario])) {
				$groupedResults[$codigoPresupuestario] = [
					'codigoPresupuestario' => $codigoPresupuestario,
					'descripRubro' => $descripRubro,
					'productos' => [],
					'totalSum' => 0

				];
			}
			$groupedResults[$codigoPresupuestario]['productos'][] = [
				'codProducto' => $row->codProducto,
				'descripcion' => $row->descripcion,
				'nombreMedida' => $row->nombreMedida,
				'existencias' => $row->existencias,
				'precio_promedio' => $row->precio_promedio,
				'total' => $row->total,
			];
			$groupedResults[$codigoPresupuestario]['totalSum'] += $row->total;
		}
		$totalSumGeneral = 0;
		foreach ($groupedResults as $codigoPresupuestario => $data) {
			$totalSumGeneral += $data['totalSum'];
		}

		$array = [
			'reporte' => $groupedResults,
			'mes' => $month,
			'anio' => $year,
			'sumaGeneral' => $totalSumGeneral
		];


		$pdf = PDF::loadView('reporte.listadoArticulos', $array);
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

		return $pdf->stream('xd' . '.pdf');
	}

	public function reportesMensuales(reportesMensualesRequest $request)
	{
		$method = $request->input('reportType');
		return $this->escogerMetodoReportesMens($request, $method);
	}

	public function escogerMetodoReportesMens(Request $request, $method)
	{

		if ($request->fechaInput) {
			switch ($method) {
				case 'totalIngresoMesPost':
					return $this->totalIngresoMesPost($request);
				case 'totalSalidaMesPost':
					return $this->totalSalidaMesPost($request);
				case 'listadoArticulos':
					return $this->listadoArticulos($request);
				default:
					return redirect()->back()->with('error', 'Debe de seleccionar un tipo de reporte y una fecha valida');
					break;
			}
		} else {
			return redirect()->back()->with('error', 'Debe de seleccionar un tipo de reporte y una fecha valida');
		}
	}

	public function reportesGenerales(Request $request)
	{
		$method = $request->input('reportTypeGeneral');
		return $this->escogerMetodoReportesGener($request, $method);
	}

	public function escogerMetodoReportesGener(Request $request, $method)
	{

			switch ($method) {
				case 'existenciaFecha':
					return $this->existenciaFecha($request);
				// case 'reporteEspecifico':
				// 	return $this->totalSalidaMesPost($request);
				// case 'listadoArticulos':
				// 	return $this->listadoArticulos($request);
				default:
					return redirect()->back()->with('error', 'Debe de seleccionar un tipo de reporte y una fecha valida');
					break;
			}
	}


	public function existenciaFecha(Request $request)
	{

		$resultados = DB::table('productos')
    ->select(
        'productos.descripcion',
        DB::raw('COALESCE((SELECT SUM(cantidadIngreso) FROM detalle_compras WHERE producto_id = productos.id AND recepcion_compra_id IN (SELECT id FROM recepcion_compras)), 0) - COALESCE((SELECT SUM(cantidad) FROM detalle_requisicions WHERE producto_id = productos.id AND requisicion_id IN (SELECT id FROM requisicion_productos WHERE estado_id = 4)), 0) AS existencias')
    )
    ->groupBy('productos.descripcion', 'productos.id')
    ->havingRaw('existencias > 0')
    ->orderBy('productos.descripcion')
    ->get();

		$array = [
			'reporte' => $resultados,

		];
		$pdf = PDF::loadView('reporte.existenciaFecha', $array);
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

		return $pdf->stream('xd' . '.pdf');
	}






}

<?php

namespace App\Http\Controllers\Reporte;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReporteMensualesRequest;
use App\Models\DetalleCompra;
use App\Models\DetalleRequisicion;
use App\Models\Producto;
use App\Models\RecepcionCompra;
use App\Models\RequisicionProducto;
use App\Models\Rubro;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use Illuminate\Support\Facades\DB;
use IntlDateFormatter;


class ReporteController extends Controller
{
	/**
	 * Muestra la página principal de generación de informes.
	 *
	 * Este método recupera la lista de rubros desde la base de datos y los pasa a la vista 'reporte.index' para mostrarlos en la página.
	 * Si ocurre algún error durante el proceso, el método redirige al usuario a la página anterior con un mensaje de error.
	 *
	 * @return Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View La vista 'reporte.index' que muestra la página principal de generación de informes.
	 */
	public function index()
	{
		try {
			// Recuperar la lista de rubros desde la base de datos
			$rubros = Rubro::all();

			// Pasar la lista de rubros a la vista para mostrarlos en la página
			return view('reporte.index', compact("rubros"));
		} catch (\Exception $e) {
			// En caso de error, redirigir a la página anterior con un mensaje de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error: ' . $e->getMessage());
		}
	}

	/**
	 * Genera un comprobante PDF para una requisición de productos.
	 *
	 * Este método genera un comprobante en formato PDF para una requisición de productos especificada.
	 * Calcula el total final y recopila los datos necesarios para crear el comprobante.
	 * Luego, utiliza la librería PDF para cargar la vista 'reporte.comprobanteRequiProduc' con los datos necesarios.
	 * Configura el tamaño del papel y la orientación del PDF, y renderiza el PDF.
	 * Agrega números de página al pie de página del PDF.
	 * Finalmente, devuelve el PDF generado para su visualización o descarga.
	 * En caso de un error, redirige al usuario a la página anterior con un mensaje de error.
	 *
	 * @param RequisicionProducto $requisicionProducto La instancia de la requisición de productos para la que se generará el comprobante.
	 * @return mixed El contenido del PDF generado para su visualización o descarga.
	 */
	public function comprobanteRequiProductoPDF(RequisicionProducto $requisicionProducto)
	{
		try {
			// Inicializar el total final y obtener la lista de productos
			$totalFinal = 0.0;
			$productos = Producto::all();

			// Calcular el total final y obtener los detalles de la requisición
			$detalle_requisicion = DetalleRequisicion::where('requisicion_id', $requisicionProducto->id)->get();
			foreach ($detalle_requisicion as $item) {
				$totalFinal += $item->total;
			}

			// Preparar los datos para la vista del PDF
			$data = [
				'productos' => $productos,
				'detalle_requisicion' => $detalle_requisicion,
				'totalFinal' => $totalFinal,
				'requisicionProducto' => $requisicionProducto
			];

			// Cargar la vista del comprobante y generar el PDF
			$pdf = PDF::loadView('reporte.comprobanteRequiProduc', $data);
			$pdf->setPaper('letter', 'portrait', 'auto');
			$pdf->render();

			// Agregar números de página al pie de página del PDF
			$canvas = $pdf->getCanvas();
			$fontMetrics = $pdf->getFontMetrics();
			$w = $canvas->get_width();
			$h = $canvas->get_height();
			$font = $fontMetrics->getFont("helvetica", "bold");
			$text = 'Página {PAGE_NUM} de {PAGE_COUNT}';
			$textWidth = $fontMetrics->getTextWidth($text, $font, 10);
			$x = $w - $textWidth - 150;
			$y = $h - 30;
			$canvas->page_text($x, $y, $text, $font, 10, array(0, 0, 0));

			// Devolver el PDF generado para su visualización o descarga
			return $pdf->stream($requisicionProducto->nCorrelativo . '.pdf');
		} catch (\Exception $e) {
			// En caso de error, redirigir al usuario a la página anterior con un mensaje de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error: ' . $e->getMessage());
		}
	}

	/**
	 * The function ingresoProductoPDF generates a PDF report for a given RecepcionCompra object,
	 * including details of the purchase and a total amount, and adds page numbers to the footer before
	 * streaming the PDF for download.
	 * 
	 * @param RecepcionCompra recepcionCompra The parameter "recepcionCompra" is an instance of the
	 * "RecepcionCompra" class. It is used to retrieve information related to a reception of a purchase.
	 * 
	 * @return a PDF file stream.
	 */
	public function ingresoProductoPDF(RecepcionCompra $recepcionCompra)
	{
		try {
			$totalFinal = 0.0;
			$detalle_compra = DetalleCompra::where('recepcion_compra_id', $recepcionCompra->id)->get();
			foreach ($detalle_compra as $item) {
				$totalFinal += $item->total;
			}
			$data = [
				'detalle_compra' => $detalle_compra,
				'totalFinal' => $totalFinal,
				'recepcionCompra' => $recepcionCompra
			];

			$pdf = PDF::loadView('reporte.ingresoProductos', $data);
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
			return $pdf->stream($recepcionCompra->nCorrelativo . '.pdf');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	//PDF aprobacion requicision
	public function aprobarRequiProductoPDF(RequisicionProducto $requisicionProducto)
	{
		try {
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

			return $pdf->stream($requisicionProducto->nCorrelativo . '.pdf');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	// REPORTES MENSUALES

	//Metodo que recibe el tipo de reporte que se requiere, le pasa los parametros para ecoger el reporte mensual
	public function reportesMensuales(ReporteMensualesRequest $request)
	{
		try {
			$method = $request->input('reportType');
			return $this->escogerMetodoReportesMens($request, $method);
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	//Este reporte llama al metodo del reporte seleccionado
	public function escogerMetodoReportesMens(Request $request, $method)
	{
		try {
			if ($request->fechaInput) {
				switch ($method) {
					case 'totalIngresoMes':
						return $this->totalIngresoMes($request);
					case 'totalSalidaMes':
						return $this->totalSalidaMes($request);
					case 'listadoArticulos':
						return $this->listadoArticulos($request);
					default:
						return redirect()->back()->with('catch', 'Debe de seleccionar un tipo de reporte y una fecha valida');
						break;
				}
			} else {
				return redirect()->back()->with('catch', 'Debe de seleccionar un tipo de reporte y una fecha valida');
			}
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	public function totalIngresoMes(Request $request)
	{
		try {
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
				->where('recepcion_compras.finalizado', 1)
				->groupBy('rubros.codigopresupuestario', 'rubros.descriprubro')
				->get();

			foreach ($resultados as $item) {
				$totalFinal += $item->sumaTotal;
			}
			$formatted_number = number_format($totalFinal, 2, '.', '');
			$fmt = new IntlDateFormatter('es_ES', IntlDateFormatter::FULL, IntlDateFormatter::NONE, null, null, 'MMMM');
			$nombreMes = $fmt->format(mktime(0, 0, 0, $month, 10));
			$nombreMes = mb_strtoupper($nombreMes, 'UTF-8');

			$array = [
				'reporteTotalIngreso' => $resultados,
				'totalFinal' => $formatted_number,
				'mes' => $nombreMes,
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
			return $pdf->stream('Total_Ingreso_Mes_' . $nombreMes . '_' . $year . '.pdf');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	public function totalSalidaMes(Request $request)
	{
		try {
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
			$fmt = new IntlDateFormatter('es_ES', IntlDateFormatter::FULL, IntlDateFormatter::NONE, null, null, 'MMMM');
			$nombreMes = $fmt->format(mktime(0, 0, 0, $month, 10));
			$nombreMes = mb_strtoupper($nombreMes, 'UTF-8');
			$array = [
				'reporteTotalSalida' => $resultados,
				'totalFinal' => $formatted_number,
				'mes' => $nombreMes,
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
			return $pdf->stream('Total_Salida_Mes_' . $nombreMes . '_' . $year . '.pdf');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	public function listadoArticulos(Request $request)
	{

		try {
			$ENTREGADA = config('constantes.ENTREGADA'); //4
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
					DB::raw('COALESCE((SELECT SUM(cantidadIngreso) FROM detalle_compras WHERE producto_id = productos.id AND recepcion_compra_id IN (SELECT id FROM recepcion_compras WHERE YEAR(fechaIngreso) <= ? AND MONTH(fechaIngreso) <= ? AND finalizado = 1)), 0) - COALESCE((SELECT SUM(cantidad) FROM detalle_requisicions WHERE producto_id = productos.id AND requisicion_id IN (SELECT id FROM requisicion_productos WHERE estado_id = ? AND YEAR(fechaRequisicion) <= ? AND MONTH(fechaRequisicion) <= ?)), 0) AS existencias'),
					DB::raw('ROUND((COALESCE((SELECT SUM(total) FROM detalle_compras WHERE producto_id = productos.id AND recepcion_compra_id IN (SELECT id FROM recepcion_compras WHERE YEAR(fechaIngreso) <= ? AND MONTH(fechaIngreso) <= ? AND finalizado = 1)), 0) - COALESCE((SELECT SUM(total) FROM detalle_requisicions WHERE producto_id = productos.id AND requisicion_id IN (SELECT id FROM requisicion_productos WHERE estado_id = ? AND YEAR(fechaRequisicion) <= ? AND MONTH(fechaRequisicion) <= ?)), 0)) / (COALESCE((SELECT SUM(cantidadIngreso) FROM detalle_compras WHERE producto_id = productos.id AND recepcion_compra_id IN (SELECT id FROM recepcion_compras WHERE YEAR(fechaIngreso) <= ? AND MONTH(fechaIngreso)<=? AND finalizado = 1)), 0) - COALESCE((SELECT SUM(cantidad) FROM detalle_requisicions WHERE producto_id = productos.id AND requisicion_id IN (SELECT id FROM requisicion_productos WHERE estado_id = ? AND YEAR(fechaRequisicion)<=? AND MONTH(fechaRequisicion)<=?)),0)),2) AS precio_promedio'),
					DB::raw('(COALESCE((SELECT SUM(total) FROM detalle_compras WHERE producto_id = productos.id AND recepcion_compra_id IN (SELECT id FROM recepcion_compras WHERE YEAR(fechaIngreso)<=? AND MONTH(fechaIngreso)<=? AND finalizado = 1)),0)-COALESCE((SELECT SUM(total) FROM detalle_requisicions WHERE producto_id=productos.id AND requisicion_id IN (SELECT id FROM requisicion_productos WHERE estado_id=? AND YEAR(fechaRequisicion)<=? AND MONTH(fechaRequisicion)<=?)),0)) AS total')
				)
				->groupBy('rubros.codigoPresupuestario', 'rubros.descripRubro', 'productos.codProducto', 'productos.descripcion', 'medidas.nombreMedida', 'productos.id')
				->havingRaw('COALESCE((SELECT SUM(cantidadIngreso) FROM detalle_compras WHERE producto_id = productos.id AND recepcion_compra_id IN (SELECT id FROM recepcion_compras WHERE YEAR(fechaIngreso) <= ? AND MONTH(fechaIngreso) <= ?)), 0) - COALESCE((SELECT SUM(cantidad) FROM detalle_requisicions WHERE producto_id = productos.id AND requisicion_id IN (SELECT id FROM requisicion_productos WHERE estado_id = 4 AND YEAR(fechaRequisicion) <= ? AND MONTH(fechaRequisicion) <= ?)), 0) > 0', [$year, $month, $year, $month])
				->setBindings([
					$year, $month, $ENTREGADA, $year, $month,
					$year, $month, $ENTREGADA, $year, $month, $year, $month, $ENTREGADA, $year, $month,
					$year, $month, $ENTREGADA, $year, $month
				])
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
			$fmt = new IntlDateFormatter('es_ES', IntlDateFormatter::FULL, IntlDateFormatter::NONE, null, null, 'MMMM');
			$nombreMes = $fmt->format(mktime(0, 0, 0, $month, 10));
			$nombreMes = mb_strtoupper($nombreMes, 'UTF-8');
			$array = [
				'reporte' => $groupedResults,
				'mes' => $nombreMes,
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
			return $pdf->stream('Listado_Articulos_Mes_' . $nombreMes . '_' . $year . '.pdf');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	// REPORTES GENERALES

	//Metodo que recibe el tipo de reporte que se requiere, le pasa los parametros para ecoger el reporte general

	public function reportesGenerales(Request $request)
	{
		try {
			$method = $request->input('reportTypeGeneral');
			return $this->escogerMetodoReportesGener($request, $method);
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	public function escogerMetodoReportesGener(Request $request, $method)
	{
		try {
			switch ($method) {
				case 'existenciaFecha':
					return $this->existenciaFecha($request);
				case 'consumoPorRubro':
					return $this->consumoPorRubro($request);
				case 'salidaPorUnidadesMes':
					return $this->salidaPorUnidadesMes($request);
				default:
					return redirect()->back()->with('catch', 'Debe de seleccionar un tipo de reporte y una fecha valida');
					break;
			}
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	public function existenciaFecha(Request $request)
	{
		try {
			$ENTREGADA = config('constantes.ENTREGADA'); //4
			$resultados = DB::table('productos')
				->select(
					'productos.descripcion',
					DB::raw('COALESCE((SELECT SUM(cantidadIngreso) FROM detalle_compras WHERE producto_id = productos.id AND recepcion_compra_id IN (SELECT id FROM recepcion_compras WHERE finalizado = 1)), 0) - COALESCE((SELECT SUM(cantidad) FROM detalle_requisicions WHERE producto_id = productos.id AND requisicion_id IN (SELECT id FROM requisicion_productos WHERE estado_id = ?)), 0) AS existencias')
				)
				->groupBy('productos.descripcion', 'productos.id')
				->havingRaw('COALESCE((SELECT SUM(cantidadIngreso) FROM detalle_compras WHERE producto_id = productos.id AND recepcion_compra_id IN (SELECT id FROM recepcion_compras WHERE finalizado = 1)), 0) - COALESCE((SELECT SUM(cantidad) FROM detalle_requisicions WHERE producto_id = productos.id AND requisicion_id IN (SELECT id FROM requisicion_productos WHERE estado_id = 4)), 0) > 0', [$ENTREGADA])
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
			$year = Carbon::now()->year;
			$month = Carbon::now()->month;
			$fmt = new IntlDateFormatter('es_ES', IntlDateFormatter::FULL, IntlDateFormatter::NONE, null, null, 'MMMM');
			$nombreMes = $fmt->format(mktime(0, 0, 0, $month, 10));
			$nombreMes = mb_strtoupper($nombreMes, 'UTF-8');

			return $pdf->stream('Existencia a la Fecha ' . $nombreMes . ' ' . $year . '.pdf');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	public function consumoPorRubro(Request $request)
	{
		try {
			$ENTREGADA = config('constantes.ENTREGADA'); //4
			$start_date = $request->start_date;
			$end_date = $request->end_date;

			if ($start_date > $end_date) {
				return redirect()->back()->with('catch', 'La fecha de fin debe ser mayor o igual a la fecha de inicio');
			}

			$rubro_id = $request->rubro_id; // Replace with the desired rubro_id value
			$start_month_year = (int)date('Ym', strtotime($start_date));
			$end_month_year = (int)date('Ym', strtotime($end_date));

			$resultados = DB::table('detalle_requisicions')
				->join('requisicion_productos', 'detalle_requisicions.requisicion_id', '=', 'requisicion_productos.id')
				->join('productos', 'detalle_requisicions.producto_id', '=', 'productos.id')
				->select(
					'detalle_requisicions.producto_id',
					'productos.descripcion',
					DB::raw('MONTH(requisicion_productos.fechaRequisicion) as month'),
					DB::raw('SUM(detalle_requisicions.cantidad) as cantidad_productos'),
					DB::raw('SUM(detalle_requisicions.total) as total')
				)
				->where('requisicion_productos.estado_id', '=', $ENTREGADA)
				->whereBetween(DB::raw("YEAR(requisicion_productos.fechaRequisicion) * 100 + MONTH(requisicion_productos.fechaRequisicion)"), [$start_month_year, $end_month_year])
				->where('productos.rubro_id', '=', $rubro_id)
				->groupBy('detalle_requisicions.producto_id', 'productos.descripcion', DB::raw('MONTH(requisicion_productos.fechaRequisicion)'))
				->get();


			// Set the locale for Carbon to Spanish
			Carbon::setLocale('es');

			// Create an array of all the months between the start and end dates
			$months = [];
			$start = new Carbon($start_date);
			// Add one month to the end date
			$end = (new Carbon($end_date))->addMonth();


			$interval = DateInterval::createFromDateString('1 month');
			$period = new DatePeriod($start, $interval, $end);
			foreach ($period as $dt) {
				// Use the Carbon::formatLocalized() method to format the month name in Spanish
				$months[$dt->format("n")] = ucfirst($dt->isoFormat('MMMM'));
			}

			// Get all unique producto_ids and their descripcion
			$producto_ids = [];
			foreach ($resultados as $resultado) {
				if (!array_key_exists($resultado->producto_id, $producto_ids)) {
					$producto_ids[$resultado->producto_id] = $resultado->descripcion;
				}
			}

			// Loop through the producto_ids and months arrays and check if there is data for each month
			$new_resultados = [];
			foreach ($producto_ids as $producto_id => $descripcion) {
				$producto_data = [];
				foreach ($months as $month_number => $month_name) {
					$found = false;
					foreach ($resultados as $resultado) {
						if ($resultado->month == $month_number && $resultado->producto_id == $producto_id) {
							// If there is data for this month and producto_id, add it to the producto_data array
							$producto_data[] = (object)[
								"descripcion" => $resultado->descripcion,
								"month" => $resultado->month,
								"cantidad_productos" => $resultado->cantidad_productos,
								"total" => $resultado->total,
								"month_name" => $month_name
							];
							$found = true;
							break;
						}
					}
					if (!$found) {
						// If there is no data for this month and producto_id, insert a placeholder value with the descripcion field
						$producto_data[] = (object)[
							"descripcion" => $descripcion,
							"month" => $month_number,
							"cantidad_productos" => 0,
							"total" => 0,
							"month_name" => $month_name
						];
					}
				}
				// Add the producto_data array to the new_resultados array
				$new_resultados[$producto_id] = $producto_data;
			}

			// Loop through the new_resultados array to calculate the sum of the total field for all months for each product
			foreach ($new_resultados as $producto_id => $producto_data) {
				$sum = 0;
				$sumCantidad = 0;
				$descripcion = "";
				foreach ($producto_data as $data) {
					$sum += $data->total;
					$sumCantidad += $data->cantidad_productos;
					$descripcion = $data->descripcion;
				}
				// Add the descripcion and sum of the total field for all months to the new_resultados array
				$new_resultados[$producto_id] = [
					"descripcion" => $descripcion,
					"totalSalidas" => $sumCantidad,
					"total" => round($sum, 2),
					"product_data" => $producto_data
				];
			}

			// Add the months array to the array
			$array['months'] = array_values($months);

			$array = [
				'reporte' => $new_resultados,
				'months' => array_values($months),
				'mes_inicio' => $start_date,
				'mes_final' => $end_date,
				'rubro' => $request->codigoPresupuestario . ' ' . $request->descripRubro,

			];

			$pdf = PDF::loadView('reporte.consumoPorRubro', $array);
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

			return $pdf->stream('Consumo Por Especifico desde ' . $start_date . ' Hasta ' . $end_date . '.pdf');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	public function salidaPorUnidadesMes(Request $request)
	{
		try {
			$fecha = $request->fechaInput;
			list($year, $month) = explode("-", $fecha);
			$ENTREGADA = config('constantes.ENTREGADA'); //4

			$resultados = DB::table('unidad_organizativas')
				->join('usuarios', 'unidad_organizativas.id', '=', 'usuarios.unidad_organizativa_id')
				->join('requisicion_productos', 'usuarios.id', '=', 'requisicion_productos.user_id')
				->join('detalle_requisicions', 'requisicion_productos.id', '=', 'detalle_requisicions.requisicion_id')
				->join('productos', 'detalle_requisicions.producto_id', '=', 'productos.id')
				->select('unidad_organizativas.nombreUnidadOrganizativa', 'productos.descripcion', DB::raw('SUM(detalle_requisicions.cantidad) as total_cantidad'), DB::raw('SUM(detalle_requisicions.total) as total'))
				->where('requisicion_productos.estado_id', $ENTREGADA)
				->whereMonth('requisicion_productos.fechaRequisicion', $month)
				->whereYear('requisicion_productos.fechaRequisicion', $year)
				->groupBy('unidad_organizativas.nombreUnidadOrganizativa', 'productos.descripcion')
				->orderBy('unidad_organizativas.nombreUnidadOrganizativa', 'asc')
				->orderBy('productos.descripcion', 'asc')
				->get();

			$fmt = new IntlDateFormatter('es_ES', IntlDateFormatter::FULL, IntlDateFormatter::NONE, null, null, 'MMMM');
			$nombreMes = $fmt->format(mktime(0, 0, 0, $month, 10));
			$nombreMes = mb_strtoupper($nombreMes, 'UTF-8');
			$arrayU = [];
			foreach ($resultados as $resultado) {
				$nombreUnidadOrganizativa = $resultado->nombreUnidadOrganizativa;
				if (!isset($arrayU[$nombreUnidadOrganizativa])) {
					$arrayU[$nombreUnidadOrganizativa] = [
						'nombreUnidadOrganizativa' => $nombreUnidadOrganizativa,
						'productos' => []
					];
				}
				$arrayU[$nombreUnidadOrganizativa]['productos'][] = [
					'descripcion' => $resultado->descripcion,
					'total_cantidad' => $resultado->total_cantidad,
					'total' => $resultado->total
				];
			}

			// Calculate the total for each nombreUnidadOrganizativa
			foreach ($arrayU as $nombreUnidadOrganizativa => $data) {
				$total = 0;
				foreach ($data['productos'] as $producto) {
					$total += $producto['total'];
				}
				$arrayU[$nombreUnidadOrganizativa]['total'] = $total;
			}

			$array = [
				'reporte' => $arrayU,
				'mes' => $nombreMes,
				'anio' => $year
			];


			$pdf = PDF::loadView('reporte.salidaUnidadesAdministrativas', $array);
			return $pdf->stream('Salidas_Unidades_Mes_' . $month . '_' . $year . '.pdf');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}
}

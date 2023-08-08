<?php

namespace App\Http\Controllers\Inventario;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class InventarioController extends Controller
{
	//

	public function index()
	{
		return view('inventario.index');
	}

	//Este metodo se encarga de enviar los datos a una dataTable
	//La consulta SQL contiene los calculos de los stocks para saber la cantidad que se enceuntran disponibles
	public function datosInventario()
	{
		try {
			//Se define dentro de config/constantes.php--
			$ENVIADA = config('constantes.ENVIADA'); //1
			$ACEPTADA = config('constantes.ACEPTADA'); //2
			$RECHAZADA = config('constantes.RECHAZADA'); //3
			$ENTREGADA = config('constantes.ENTREGADA'); //4

			$inventarios = DB::select(
				"SELECT p.codProducto, p.descripcion,
							COALESCE(dcom.cantidadIngreso - COALESCE(dreq.cantidad_rechazada, 0),0) AS stock,
							COALESCE(dreq.cantidad_aprobada, 0) AS stock1
							FROM productos p
							LEFT JOIN (SELECT producto_id, SUM(cantidadIngreso) AS cantidadIngreso
							FROM detalle_compras dc
							JOIN recepcion_compras rcom ON dc.recepcion_compra_id = rcom.id
							WHERE rcom.finalizado = 1
							GROUP BY producto_id) dcom ON p.id = dcom.producto_id
							LEFT JOIN (SELECT producto_id, SUM(CASE WHEN estado_id = $ENVIADA OR estado_id = $ACEPTADA THEN cantidad ELSE 0 END) AS cantidad_aprobada,
							SUM(CASE WHEN estado_id = $ENTREGADA THEN cantidad ELSE 0 END) AS cantidad_rechazada
							FROM detalle_requisicions dr
							JOIN requisicion_productos rp ON dr.requisicion_id = rp.id
							WHERE rp.estado_id IN ($ENVIADA, $ACEPTADA, $ENTREGADA)
							GROUP BY producto_id) dreq ON p.id = dreq.producto_id;"
			);
			return DataTables::of($inventarios)->make(true);
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	public function downloadData()
	{
		try {
			//Se define dentro de config/constantes.php--
			$ENVIADA = config('constantes.ENVIADA'); //1
			$ACEPTADA = config('constantes.ACEPTADA'); //2
			$RECHAZADA = config('constantes.RECHAZADA'); //3
			$ENTREGADA = config('constantes.ENTREGADA'); //4
			// Obtener los datos y convertirlos en un array
			$inventarios = DB::select(
				"SELECT p.codProducto, p.descripcion,
            COALESCE(dcom.cantidadIngreso - COALESCE(dreq.cantidad_rechazada, 0),0) AS stock,
            COALESCE(dreq.cantidad_aprobada, 0) AS stock1
            FROM productos p
						LEFT JOIN (SELECT producto_id, SUM(cantidadIngreso) AS cantidadIngreso
            FROM detalle_compras dc
						JOIN recepcion_compras rcom ON dc.recepcion_compra_id = rcom.id
						WHERE rcom.finalizado = 1
            GROUP BY producto_id) dcom ON p.id = dcom.producto_id
            LEFT JOIN (SELECT producto_id, SUM(CASE WHEN estado_id = $ENVIADA OR estado_id = $ACEPTADA THEN cantidad ELSE 0 END) AS cantidad_aprobada,
            SUM(CASE WHEN estado_id = $ENTREGADA THEN cantidad ELSE 0 END) AS cantidad_rechazada
            FROM detalle_requisicions dr
            JOIN requisicion_productos rp ON dr.requisicion_id = rp.id
            WHERE rp.estado_id IN ($ENVIADA, $ACEPTADA, $ENTREGADA)
            GROUP BY producto_id) dreq ON p.id = dreq.producto_id;"
			);

			// Preparar los datos para guardar en el archivo de Excel
			$sheets = [];
			foreach ($inventarios as $i => $item) {
				$sheets[$i]['Código del producto'] = $item->codProducto;
				$sheets[$i]['Descripción'] = $item->descripcion;
				$sheets[$i]['Stock'] = $item->stock;
				$sheets[$i]['Stock1'] = $item->stock1;
			}


			// Convertir los datos en una colección
			$sheets = collect($sheets);

			// Ruta del archivo de plantilla
			$templatePath = storage_path('plantillas/plantilla_excel.xlsx');

			// Cargar la plantilla
			$spreadsheet = IOFactory::load($templatePath);

			// Obtener la hoja activa
			$sheet = $spreadsheet->getActiveSheet();
			// Agregar los datos a la hoja
			$row = 5; // Comenzar en la segunda fila
			foreach ($sheets as $data) {
				$sheet->setCellValue('B' . $row, $data['Código del producto']);
				$sheet->setCellValue('C' . $row, $data['Descripción']);
				$sheet->setCellValue('D' . $row, $data['Stock']);
				$row++;
			}

			$filename = 'Inventario_existencias_realizado_el_' . date('m-Y') . '.xlsx';
			return response()->streamDownload(function () use ($spreadsheet) {
				$writer = new Xlsx($spreadsheet);
				$writer->save('php://output');
			}, $filename, [
				'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
			]);
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}
}

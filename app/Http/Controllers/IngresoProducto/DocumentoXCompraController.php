<?php

namespace App\Http\Controllers\IngresoProducto;

use App\Http\Controllers\Controller;

use App\Models\DocumentoXCompra;
use App\Models\RecepcionCompra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DocumentoXCompraController extends Controller
{

	/**
	 * Descarga un documento asociado a una recepción de compra (INGRESO).
	 *
	 * @param string $uuid El UUID del documento que se desea descargar.
	 * @return \Illuminate\Http\Response
	 */
	public function leerDocumento($uuid)
	{
		try {
			// Busca el documento por su UUID y asegura su existencia
			$documento = DocumentoXCompra::where('id', $uuid)->firstOrFail();

			// Obtiene la ruta completa al archivo del documento
			$pathToFile = public_path('documentos/' . $documento->nombreDocumento);

			// Devuelve el archivo como respuesta para descargar
			return response()->file($pathToFile);
		} catch (\Exception $e) {
			return response()->json(['error' => 'Documento no encontrado'], 404);
		}
	}

	/**
	 * Muestra la vista para subir documentos de una recepción de compra (INGRESO DE COMPRA).
	 *
	 * @param \App\Models\RecepcionCompra $recepcionCompra La recepción de compra asociada.
	 * @return \Illuminate\View\View
	 */
	public function documentoBar(RecepcionCompra $recepcionCompra)
	{
		// Recupera los datos de la sesión
		$currentStep = "2.Subir documentos del ingreso"; // Paso actual
		$labelBar = ["1.Recepcion de compra", "2.Subir documentos del ingreso", "3.Ingreso de productos"]; // Array con los números de los pasos

		// Retorna la vista con las variables compactadas
		return view('ingresoProducto.recepcionCompra.documento', compact('currentStep', 'labelBar', 'recepcionCompra'));
	}

	/**
	 * Muestra la vista para editar documentos de una recepción de compra (INGRESO).
	 *
	 * @param \App\Models\RecepcionCompra $recepcionCompra La recepción de compra asociada.
	 * @return \Illuminate\View\View
	 */
	public function documentoEdit(RecepcionCompra $recepcionCompra)
	{
		// Retorna la vista con la recepción de compra compactada
		return view('ingresoProducto.recepcionCompra.documentoEdit', compact('recepcionCompra'));
	}

	public function documentoBarPost(RecepcionCompra $recepcionCompra)
	{
		$recepcionID = DocumentoXCompra::where('id', $recepcionCompra);
		return redirect()->route('recepcionCompra.detalle', $recepcionCompra);
	}

	/**
	 * Sube y almacena documentos asociados a una recepción de compra (INGRESO).
	 *
	 * @param \Illuminate\Http\Request $request La solicitud HTTP.
	 * @param \App\Models\RecepcionCompra $recepcionCompra La recepción de compra asociada.
	 * @return \Illuminate\Http\RedirectResponse Redirige de vuelta a la página anterior con un mensaje.
	 */
	public function upload(Request $request, RecepcionCompra $recepcionCompra)
	{
		try {
			$documentoNuevo = new DocumentoXCompra();
			$rutaGuardarDocumento = 'documentos/';
			$files = $request->file('file');

			// Iterar a través de los archivos recibidos en la solicitud
			foreach ($files as $file) {
				// Crear un nombre único para el archivo basado en el ID de la recepción de compra y el nombre original del archivo
				$filename = $recepcionCompra->id . '-' . $file->getClientOriginalName();

				// Configurar los datos del documento
				$documentoNuevo->nombreDocumento = $filename;
				$documentoNuevo->recepcion_compra_id = $recepcionCompra->id;

				// Mover el archivo a la ubicación especificada
				$file->move($rutaGuardarDocumento, $filename);

				// Guardar los datos del documento en la base de datos
				$documentoNuevo->save();
			}

			// Redirigir de vuelta a la página anterior con un mensaje de éxito
			return redirect()->back()->with('catch', 'Files uploaded successfully!');
		} catch (\Exception $e) {
			// En caso de error, redirigir con un mensaje de error
			return redirect()->back()->with('catch', 'Error!');
		}
	}

	/**
	 * Elimina un documento asociado a una recepción de compra (INGRESO).
	 *
	 * @param \Illuminate\Http\Request $request La solicitud HTTP.
	 * @param \App\Models\RecepcionCompra $recepcionCompra La recepción de compra asociada.
	 * @return \Illuminate\Http\RedirectResponse Redirige de vuelta a la página anterior con un mensaje.
	 */
	public function delete(Request $request, RecepcionCompra $recepcionCompra)
	{
		try {
			$filename = $request->input('filename');
			$url = public_path('documentos/' . $recepcionCompra->id . '-' . $filename);

			// Verificar si el archivo existe y eliminarlo
			if (File::exists($url)) {
				File::delete($url);
				// Eliminar también la entrada del documento en la base de datos
				DocumentoXCompra::where('nombreDocumento', $recepcionCompra->id . '-' . $filename)->delete();
				return redirect()->back()->with('catch', 'Exito!');
			} else {
				return  $m = 'File does not exist.';
			}
		} catch (\Exception $e) {
			// En caso de error, redirigir con un mensaje de error
			return redirect()->back()->with('catch', 'Error!');
		}
	}

	/**
	 * Elimina un documento asociado a una recepción de compra (INGRESO) en la vista de edición.
	 *
	 * @param int $id El ID del documento a eliminar.
	 * @return \Illuminate\Http\RedirectResponse Redirige de vuelta a la página anterior con un mensaje.
	 */
	public function deleteEdit($id)
	{
		try {
			// Buscar el documento por su ID
			$documento = DocumentoXCompra::where('id', $id)->firstOrFail();
			$url = public_path('documentos/' . $documento->nombreDocumento);

			// Verificar si el archivo existe y eliminarlo
			if (File::exists($url)) {
				File::delete($url);
				// Eliminar también la entrada del documento en la base de datos
				DocumentoXCompra::where('id', $id)->delete();
				return redirect()->back()->with('catch', 'Exito!');
			} else {
				return  $m = 'File does not exist.';
			}
		} catch (\Exception $e) {
			// En caso de error, redirigir con un mensaje de error
			return redirect()->back()->with('catch', 'Error!');
		}
	}
}

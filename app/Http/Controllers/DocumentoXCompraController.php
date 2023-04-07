<?php

namespace App\Http\Controllers;

use App\Models\DocumentoXCompra;
use App\Models\RecepcionCompra;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DocumentoXCompraController extends Controller
{


    public function leerDocumento($uuid)
    {
        $documento = DocumentoXCompra::where('id', $uuid)->firstOrFail();
        $pathToFile = public_path('documentos/'.$documento->nombre_documento);
        return response()->file($pathToFile);
    }

    public function documentoBar(RecepcionCompra $recepcionCompra)
    {
        // retrieve data from session
        $currentStep = "2.Subir documentos del ingreso"; //Paso actual
        $labelBar = ["1.Recepcion de compra", "2.Subir documentos del ingreso", "3.Ingreso de productos"]; // Array con los números de los pasos

        return view('recepcionCompra.documento', compact('currentStep', 'labelBar','recepcionCompra'));
    }

    public function documentoBarPost(RecepcionCompra $recepcionCompra)
    {
        $recepcionID = DocumentoXCompra::where('id', $recepcionCompra);
        return redirect()->route('recepcionCompra.detalle', $recepcionCompra);
    }




    public function upload(Request $request, RecepcionCompra $recepcionCompra)
    {
        // $recepcion = RecepcionCompra::where('id', $recepcionCompra->id)->get();
        try {
            $documentoNuevo = new DocumentoXCompra();
            $rutaGuardarDocumento = 'documentos/';
            $files = $request->file('file');
            foreach ($files as $file) {
                $filename = $recepcionCompra->id . '-' . $file->getClientOriginalName();
                $documentoNuevo->nombre_documento = $filename;
                $documentoNuevo->recepcion_compra_id = $recepcionCompra->id;
                $file->move($rutaGuardarDocumento, $filename);
                $documentoNuevo->save();
            }
            return redirect()->back()->with('message', 'Files uploaded successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', 'Error!');
        }
    }

    public function delete(Request $request, RecepcionCompra $recepcionCompra)
    {
        try {            
            $filename = $request->input('filename');
            $url = public_path('documentos/' . $recepcionCompra->id . '-' . $filename);;
            if (File::exists($url)) {
                File::delete($url);
                DocumentoXCompra::where('nombre_documento', $recepcionCompra->id . '-' . $filename)->delete();
                return redirect()->back()->with('message', 'Exito!');
            } else {
                return  $m = 'File does not exist.';
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('message', 'Error!');
        }
    }
}

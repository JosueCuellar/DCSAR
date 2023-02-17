<?php

namespace App\Http\Controllers;

use App\Models\DocumentoXCompra;
use App\Models\RecepcionCompra;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DocumentoXCompraController extends Controller
{

    public function upload(Request $request, RecepcionCompra $recepcionCompra)
    {
        // $recepcion = RecepcionCompra::where('id', $recepcionCompra->id)->get();
        try {
            $documentoNuevo = new DocumentoXCompra();
            $rutaGuardarDocumento = 'documentos/';
            $files = $request->file('file');
            foreach ($files as $file) {
                $filename = $recepcionCompra->id . '-' . $file->getClientOriginalName();
                $documentoNuevo->nombreDocumento = $filename;
                $documentoNuevo->recepcionCompra_id = $recepcionCompra->id;
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
                DocumentoXCompra::where('nombreDocumento', $recepcionCompra->id . '-' . $filename)->delete();
                return redirect()->back()->with('message', 'Exito!');
            } else {
                return  $m = 'File does not exist.';
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('message', 'Error!');
        }
    }
}

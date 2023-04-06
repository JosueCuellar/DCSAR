<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\ProductoBodega;
use Exception;
use Illuminate\Http\Request;

class ProductoBodegaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {
            $bodegaPrincipal = 1;
            $productos_bodegas = ProductoBodega::where('bodega_id', $bodegaPrincipal)->get();
            return view('productoBodega.bodegaPrincipal', compact('productos_bodegas'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function index2()
    {
        try {
            $bodegaSecundaria = 2;
            $productos_bodegas = ProductoBodega::where('bodega_id', $bodegaSecundaria)->get();
            return view('productoBodega.bodegaSecundaria', compact('productos_bodegas'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ProductoBodega $productoBodega)
    {
        // Get input values
        $cantidad = $request->input('cantidadProducto');
        $producto = $productoBodega->producto_id;
        $bodega = $productoBodega->bodega_id;
        $var = ($bodega == 1) ? 2 : 1;
    
        try {
            // Search for secondary warehouse
            $bodegaSecundaria = ProductoBodega::where('producto_id', $producto)
                                               ->where('bodega_id', $var)
                                               ->first();
    
            // Create secondary warehouse if it does not exist
            if (!$bodegaSecundaria) {
                $bodegaSecundaria = new ProductoBodega([
                    'producto_id' => $producto,
                    'bodega_id' => $var,
                    'cantidadDisponible' => 0
                ]);
                $bodegaSecundaria->save();
            }
    
            // Check if there is enough available quantity in primary warehouse
            if ($cantidad > $productoBodega->cantidadDisponible) {
                return redirect()->back()->with('msg', 'Error, no hay suficiente cantidad disponible en la bodega');
            }
    
            // Move quantity from primary to secondary warehouse
            $productoBodega->cantidadDisponible -= $cantidad;
            $productoBodega->save();
    
            $bodegaSecundaria->cantidadDisponible += $cantidad;
            $bodegaSecundaria->save();
    
            // Redirect with success message
            if ($bodega == 1) {
                return redirect()->route('productoBodega.index')->with('status', 'Se ha agregado correctamente!');
            } else {
                return redirect()->route('productoBodega.index2')->with('status', 'Se ha agregado correctamente!');
            }
        } catch (\Exception $e) {
            // Handle exception
            return redirect()->back()->with('msg', 'Error de servidor: ' . $e->getMessage());
        }
    }
    




}

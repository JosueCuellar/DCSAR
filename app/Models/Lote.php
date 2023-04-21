<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;
    protected $fillable = [
        'producto_id',
        'detalle_compra_id',
        'fechaVencimiento',
        'bodega_id',
        'cantidadDisponible', 
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // public function bodega()
    // {
    //     return $this->belongsTo(Bodega::class);
    // }

    public function detalleCompra()
    {
        return $this->belongsTo(DetalleCompra::class);
    }

}

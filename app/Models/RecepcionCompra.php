<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecepcionCompra extends Model
{
    use HasFactory;
    protected $fillable = [
        'fecha_ingreso',
        'proveedor_id',
        'nOrdenCompra',
        'nPresupuestario',
        'estado',
        'codigo_factura'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
    
    public function detalleCompra()
    {
        return $this->belongsTo(DetalleCompra::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
}

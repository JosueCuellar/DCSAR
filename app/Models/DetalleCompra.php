<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;
    protected $fillable = [
        'producto_id',
        'recepcionCompra_id',
        'cantidadIngreso',
        'precioUnidad',
        'fechaVenc'
    ];
    public function recepcionCompra()
    {
        return $this->belongsTo(RecepcionCompra::class);
    }
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

}

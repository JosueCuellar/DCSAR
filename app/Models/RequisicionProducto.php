<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisicionProducto extends Model
{
    use HasFactory;
    protected $fillable = [
        'fecha_requisicion',
        'nCorrelativo',
        'estado_id',
        'descripcion',
        'observacion'
    ];
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'detalle_requisicions');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function scopeFechaRequisicion($query, $fecha_requisicion)
    {
        if ($fecha_requisicion) {
            return $query->where('fecha_requisicion', $fecha_requisicion);
        }
    }

    public function detallesRequisicion()
    {
        return $this->hasMany(DetalleRequisicion::class, 'requisicion_id');
    }

    public function detalleRequisicions()
    {
        return $this->hasMany('App\Models\DetalleRequisicion', 'requisicion_id');
    }
}

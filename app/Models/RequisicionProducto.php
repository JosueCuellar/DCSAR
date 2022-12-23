<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisicionProducto extends Model
{
    use HasFactory;
    protected $fillable = [
        'fecha_requisicion',
        'estado'
    ];
    public function productos()
    {
        return $this->belongsToMany(Producto::class,'detalle_requisicions');
    }
    public function scopeFechaRequisicion($query, $fecha_requisicion){
        if($fecha_requisicion){
            return $query->where('fecha_requisicion',$fecha_requisicion);
        }
    }
}

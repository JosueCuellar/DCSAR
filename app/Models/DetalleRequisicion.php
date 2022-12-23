<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleRequisicion extends Model
{
    use HasFactory;
    protected $fillable = [
        'cantidad'
    ];
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
    public function requisicionProducto()
    {
        return $this->belongsTo(RequisicionProducto::class);
    }
}

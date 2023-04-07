<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadOrganizativa extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre_unidad_medida',
        'descripcion_unidad_medida'
    ];

}

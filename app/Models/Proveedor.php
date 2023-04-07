<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre_comercial',
        'razon_social',
        'direccion_proveedor',
        'fax',
        'telefono1_proveedor',
        'telefono2_proveedor'
    ];

}

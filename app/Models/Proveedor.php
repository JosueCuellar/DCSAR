<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombreComercial',
        'razonSocial',
        'direccion',
        'fax',
        'telefono1',
        'telefono2'
    ];

}

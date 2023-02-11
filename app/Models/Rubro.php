<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rubro extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigoPresupuestario',
        // 'estado_id',
        'descripcionRubro'
    ];

    // public function estado(){
    //     return $this->belongsTo(Estado::class);
    // }
}

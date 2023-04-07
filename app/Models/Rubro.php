<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rubro extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo_presupuestario',
        // 'estado_id',
        'descripcion_rubro'
    ];

    // public function estado(){
    //     return $this->belongsTo(Estado::class);
    // }
}

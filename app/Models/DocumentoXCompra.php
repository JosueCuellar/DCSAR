<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoXCompra extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombreDocumento',
        'recepcionCompra_id'
    ];
}

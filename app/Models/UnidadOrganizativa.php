<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadOrganizativa extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombreUnidadOrganizativa',
        'descripUnidadOrganizativa'
    ];


		public function users()
{
    return $this->hasMany('App\Models\User', 'unidad_organizativa_id');
}


}

<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as OriginalPermission;


class Permiso extends OriginalPermission
{
  protected $dateFormat = 'd/m/Y H:i:s'; // Configura el formato de fecha y hora

}

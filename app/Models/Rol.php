<?php

namespace App\Models;

use Spatie\Permission\Models\Role as OriginalPermission;


class Rol extends OriginalPermission
{
  protected $dateFormat = 'd/m/Y H:i:s'; // Configura el formato de fecha y hora

}

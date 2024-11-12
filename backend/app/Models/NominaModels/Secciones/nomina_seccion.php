<?php

namespace App\Models\NominaModels\Secciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nomina_seccion extends Model
{
    use HasFactory;
    protected $table = "nomina_seccion";
    protected $primaryKey = "id";
}

<?php

namespace App\Models\NominaModels\Cargos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nomina_cargos_sena extends Model
{
    use HasFactory;
    protected $table = "nomina_cargos_sena";
    protected $primaryKey = "nomina_cargo_sena_id";
}

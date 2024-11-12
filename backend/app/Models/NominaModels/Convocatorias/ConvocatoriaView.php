<?php

namespace App\Models\NominaModels\Convocatorias;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConvocatoriaView extends Model
{
    use HasFactory;
    protected $table = "nomina_convocatorias_view";
    protected $primaryKey = "nomina_cargo_id";
}

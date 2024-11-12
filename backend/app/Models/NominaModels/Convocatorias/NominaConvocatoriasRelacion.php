<?php

namespace App\Models\NominaModels\Convocatorias;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NominaConvocatoriasRelacion extends Model
{
    use HasFactory;
    protected $table = "nomina_convocatorias_relacion";
    protected $primaryKey = "id";
}

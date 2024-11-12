<?php

namespace App\Models\NominaModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NominaConvocatoriasView extends Model
{
    
    use HasFactory;
    protected $table = "nomina_convocatorias_view";

    protected $primaryKey = "nomina_convocatoria_id";


}

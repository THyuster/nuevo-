<?php

namespace App\Models\NominaModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NominaSolicitudesEmpleoView extends Model
{
    use HasFactory;
    protected $table = 'nomina_solicitudes_empleo_view';
    protected $primaryKey = "nomina_solicitudes_empleo_id";

}

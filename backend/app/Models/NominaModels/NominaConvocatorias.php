<?php

namespace App\Models\NominaModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NominaConvocatorias extends Model
{
    use HasFactory;
    protected $connection = ''; 
    protected $table = 'nomina_convocatorias';
    protected $primaryKey = "nomina_convocatoria_id";
    protected $fillable = [
        "nomina_cargo_id",
        "nomina_solicitudes_empleo_id",
        "fecha_apertura",
        "fecha_cierre",
        "numero_puestos",
        "activa"
    ];
}

<?php

namespace App\Models\NominaModels\TalentoHumano\Empleados\Relaciones;

use App\Models\NominaModels\TalentoHumano\Empleados\EmpleadoExperienciaLaboral;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoRelacionExperienciaLaborales extends Model
{
    use HasFactory;
    protected $table = "nomina_th_rel_laborales";
    protected $fillable = [
        "empleado_id",
        "laborales_id"
    ];

    public function experiencia_laboral()
    {
        return $this->belongsTo(
            EmpleadoExperienciaLaboral::class,
            'laborales_id',
            'id'
        );
    }
}

<?php

namespace App\Models\NominaModels\TalentoHumano\Empleados\Relaciones;

use App\Models\NominaModels\TalentoHumano\Empleados\EmpleadoPersonales;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoRelacionPersonales extends Model
{
    use HasFactory;

    protected $table = "nomina_th_rel_personales";
    protected $fillable = [
        "empleado_id",
        "personales_id"
    ];

    public function personales()
    {
        return $this->belongsTo(EmpleadoPersonales::class, 'personales_id', 'id');
    }
}

<?php

namespace App\Models\NominaModels\TalentoHumano\Empleados\Relaciones;

use App\Models\NominaModels\TalentoHumano\Empleados\EmpleadoFamiliares;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoRelacionFamiliares extends Model
{
    use HasFactory;
    protected $table = "nomina_th_rel_familiares";
    protected $fillable = [
        "empleado_id",
        "familiares_id"
    ];

    public function familiares()
    {
        return $this->belongsTo(EmpleadoFamiliares::class, 'familiares_id', 'id');
    }
}

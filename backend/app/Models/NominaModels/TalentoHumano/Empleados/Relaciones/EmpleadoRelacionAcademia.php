<?php

namespace App\Models\NominaModels\TalentoHumano\Empleados\Relaciones;

use App\Models\NominaModels\TalentoHumano\Empleados\EmpleadoAcademia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoRelacionAcademia extends Model
{
    use HasFactory;
    protected $table = "nomina_th_rel_academicos";
    protected $primaryKey = "id";
    protected $fillable = [
        "empleado_id",
        "academicos_id"
    ];

    public function academia()
    {
        return $this->belongsTo(EmpleadoAcademia::class, 'academicos_id','id');
    }
}

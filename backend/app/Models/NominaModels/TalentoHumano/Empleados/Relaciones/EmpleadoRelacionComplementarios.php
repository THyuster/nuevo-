<?php

namespace App\Models\NominaModels\TalentoHumano\Empleados\Relaciones;

use App\Models\NominaModels\TalentoHumano\Empleados\EmpleadoComplementarios;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoRelacionComplementarios extends Model
{
    use HasFactory;
    protected $table = "nomina_th_rel_complementarios";
    protected $fillable = [
        "empleado_id",
        "complementarios_id"
    ];
    public function complementarios(){
        return $this->belongsTo(
            EmpleadoComplementarios::class,
            'complementarios_id',
            'id'
        );
    }
}

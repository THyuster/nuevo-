<?php

namespace App\Models\Sagrilaft;

use App\Models\NominaModels\TalentoHumano\Empleados\Empleado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagrilaftEmpleadoUrlRelacion extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    protected $table = "sagrilaft_empleados_urls_rel";
    protected $fillable = [
        "empleado_id",
        "url_id",
        "descripcion",
        "color",
        "estado"
    ];
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }
    public function resources()
    {
        return $this->hasMany(SagrilaftEmpleadoRecursos::class, 'empleado_rel_url_id', localKey: 'id');
    }
}

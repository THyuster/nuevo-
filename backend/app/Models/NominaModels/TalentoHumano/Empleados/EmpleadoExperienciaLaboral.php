<?php

namespace App\Models\NominaModels\TalentoHumano\Empleados;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoExperienciaLaboral extends Model
{
    use HasFactory, HasUuids;
    protected $table = "nomina_th_laborales";
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "empresa",
        "cargo",
        "fecha_inicio",
        "fecha_fin",
        "responsabilidades",
        "telefono"
    ];
}

<?php

namespace App\Models\NominaModels\TalentoHumano\Empleados;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoPersonales extends Model
{
    use HasFactory, HasUuids;
    protected $table = "nomina_th_personales";
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "nombre_completo",
        "telefono",
        "direccion",
        "relacion"
    ];
}

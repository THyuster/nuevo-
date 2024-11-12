<?php

namespace App\Models\NominaModels\TalentoHumano\Empleados;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoAcademia extends Model
{
    use HasFactory, HasUuids;
    protected $table = "nomina_th_academicos";
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "institucion",
        "titulo_obtenido",
        "fecha_inicial",
        "fecha_final",
        "ciudad",
        "created_at",
        "updated_at"
    ];
}

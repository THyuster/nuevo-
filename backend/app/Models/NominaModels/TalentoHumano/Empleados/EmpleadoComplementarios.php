<?php

namespace App\Models\NominaModels\TalentoHumano\Empleados;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoComplementarios extends Model
{
    use HasFactory, HasUuids;
    protected $table = "nomina_th_complementarios";
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "aspiracion_ingresos",
        "licencias_conduccion",
        "nivel_ingles",
        "habilidades_informaticas",
        "inmediatez_inicial",
        "paises_visitados",
        "estatura",
        "peso",
        "deporte",
        "fuma",
        "alcohol",
        "vehiculo_propio",
        "tipo_vehiculo",
    ];
}

<?php

namespace App\Models\NominaModels\Postulantes;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostulanteComplementarios extends Model
{
    use HasFactory, HasUuids;
    protected $table = "nomina_postulantes_complementarios";
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

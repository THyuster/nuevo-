<?php

namespace App\Models\NominaModels\Postulantes;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperienciaLaboral extends Model
{
    use HasFactory, HasUuids;
    protected $table = "nomina_convocatoria_postulantes_experiencia_laboral";
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

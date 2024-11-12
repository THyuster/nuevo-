<?php

namespace App\Models\NominaModels\Postulantes\Relaciones;

use App\Models\NominaModels\Postulantes\ExperienciaLaboral;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostulacionRelacionesExperienciaLaborales extends Model
{
    use HasFactory;
    protected $table = "nomina_convocatorias_relacion_postulantes_experiencia_laboral";
    protected $fillable = [
        "nomina_convocatoria_postulante_id",
        "nomina_convocatoria_postulante_experiencia_laboral_id"
    ];

    public function experiencia_laboral()
    {
        return $this->belongsTo(
            ExperienciaLaboral::class,
            'nomina_convocatoria_postulante_experiencia_laboral_id',
            'id'
        );
    }
}

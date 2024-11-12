<?php

namespace App\Models\NominaModels\Convocatorias;

use App\Models\NominaModels\Postulantes\Postulantes;
use App\Models\NominaModels\Postulantes\Relaciones\PostulacionesRelacionComplementarios;
use App\Models\NominaModels\Postulantes\Relaciones\PostulacionRelacionAcademia;
use App\Models\NominaModels\Postulantes\Relaciones\PostulacionRelacionesExperienciaLaborales;
use App\Models\NominaModels\Postulantes\Relaciones\PostulacionRelacionFamiliares;
use App\Models\NominaModels\Postulantes\Relaciones\PostulacionRelacionPersonales;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConvocatoriaRelacionPostulante extends Model
{
    use HasFactory;
    protected $table = "nomina_convocatorias_relacion";
    protected $primaryKey = "id";
    protected $fillable = [
        "convocatorias_id",
        "postulante_id",
        "fecha_postulacion",
        "estado"
    ];

    public function convocatoria()
    {
        return $this->belongsTo(
            ConvocatoriaView::class,
            'convocatorias_id',
            'nomina_convocatoria_id'
        );
    }

    public function postulante()
    {
        return $this->belongsTo(Postulantes::class, 'postulante_id')->with(['tipo_identificaciones']);
    }

    public function academia()
    {
        return $this->hasMany(
            PostulacionRelacionAcademia::class,
            'postulante_id',
            'postulante_id'
        )->with(['academia']);
    }
    public function experiencia_laboral()
    {
        return $this->hasMany(
            PostulacionRelacionesExperienciaLaborales::class,
            'nomina_convocatoria_postulante_id',
            'postulante_id'
        )->with(['experiencia_laboral']);
    }

    public function familiares()
    {
        return $this->hasMany(
            PostulacionRelacionFamiliares::class,
            'postulante_id',
            'postulante_id'
        )->with(['familiares']);
    }

    public function personales()
    {
        return $this->hasMany(
            PostulacionRelacionPersonales::class,
            'postulante_id',
            'postulante_id'
        )->with(['personales']);
    }

    public function complementarios()
    {
        return $this->hasMany(
            PostulacionesRelacionComplementarios::class,
            'postulante_id',
            'postulante_id'
        )->with(['complementarios']);
    }

}

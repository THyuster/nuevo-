<?php

namespace App\Models\NominaModels\Postulantes;

use App\Models\modulo_contabilidad\contabilidad_departamentos;
use App\Models\modulo_contabilidad\contabilidad_municipios;
use App\Models\modulo_contabilidad\contabilidad_tipos_identificaciones;
use App\Models\NominaModels\Convocatorias\ConvocatoriaRelacionPostulante;
use App\Models\NominaModels\Postulantes\Relaciones\PostulacionesRelacionComplementarios;
use App\Models\NominaModels\Postulantes\Relaciones\PostulacionRelacionAcademia;
use App\Models\NominaModels\Postulantes\Relaciones\PostulacionRelacionesExperienciaLaborales;
use App\Models\NominaModels\Postulantes\Relaciones\PostulacionRelacionFamiliares;
use App\Models\NominaModels\Postulantes\Relaciones\PostulacionRelacionPersonales;
use DateTime;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postulantes extends Model
{
    use HasFactory, HasUuids;
    protected $table = "nomina_convocatorias_postulantes";
    protected $primaryKey = "nomina_convocatoria_postulante_id";
    protected $fillable = [
        "nomina_convocatoria_postulante_id",
        "nomina_convocatoria_id",
        "tipo_identificacion",
        "identificacion",
        "nombre1",
        "nombre2",
        "apellido1",
        "apellido2",
        "fecha_nacimiento",
        "lugar_nacimiento",
        "edad",
        "email",
        "telefono",
        "direccion",
        "departamento",
        "municipio",
        "estado_civil",
        "ruta_foto_perfil",
        "sexo",
        // "vehiculo_propio",
        "tipo_sangre",
        "tipo_vivienda"
    ];

    public function setNombre1Attribute($value)
    {
        $this->attributes['nombre1'] = htmlspecialchars(trim($value));
    }

    public function setNombre2Attribute($value)
    {
        $this->attributes['nombre2'] = htmlspecialchars(trim($value));
    }

    public function setApellido1Attribute($value)
    {
        $this->attributes['apellido1'] = htmlspecialchars(trim($value));
    }

    public function setApellido2Attribute($value)
    {
        $this->attributes['apellido2'] = htmlspecialchars(trim($value));
    }

    public function setDireccionAttribute($value)
    {
        $this->attributes['direccion'] = htmlspecialchars(trim($value));
    }
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower(trim($value));
    }

    public function setTelefonoAttribute($value)
    {
        $this->attributes['telefono'] = preg_replace("/[^0-9]/", "", $value); // Elimina caracteres no numéricos
    }

    public function convocatoriaRelacionPostulantes()
    {
        return $this->hasMany(ConvocatoriaRelacionPostulante::class, 'postulante_id');
    }
    public function academia()
    {
        return $this->hasMany(
            PostulacionRelacionAcademia::class,
            'postulante_id',
            'nomina_convocatoria_postulante_id'
        )->with(['academia']);
    }

    public function tipo_identificaciones()
    {
        return $this->belongsTo(
            contabilidad_tipos_identificaciones::class,
            'tipo_identificacion',
            'id',
        );
    }

    public function municipios(){
        return $this->belongsTo(
            contabilidad_municipios::class,
            'municipio',
            'id',
        );
    }
    public function departamentos(){
        return $this->belongsTo(
            contabilidad_departamentos::class,
            'departamento',
            'id',
        );
    }

    public function experiencia_laboral()
    {
        return $this->hasMany(
            PostulacionRelacionesExperienciaLaborales::class,
            'nomina_convocatoria_postulante_id',
            'nomina_convocatoria_postulante_id'
        )->with(['experiencia_laboral']);
    }

    public function familiares()
    {
        return $this->hasMany(
            PostulacionRelacionFamiliares::class,
            'postulante_id',
            'nomina_convocatoria_postulante_id',
        )->with(['familiares']);
    }

    public function personales()
    {
        return $this->hasMany(
            PostulacionRelacionPersonales::class,
            'postulante_id',
            'nomina_convocatoria_postulante_id',
        )->with(['personales']);
    }

    public function complementarios()
    {
        return $this->hasMany(
            PostulacionesRelacionComplementarios::class,
            'postulante_id',
            'nomina_convocatoria_postulante_id'
        )->with(['complementarios']);
    }

}

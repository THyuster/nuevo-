<?php

namespace App\Models\NominaModels\TalentoHumano\Empleados;

use App\Models\NominaModels\Convocatorias\ConvocatoriaRelacionPostulante;

use App\Models\NominaModels\TalentoHumano\Empleados\Relaciones\EmpleadoRelacionAcademia;
use App\Models\NominaModels\TalentoHumano\Empleados\Relaciones\EmpleadoRelacionComplementarios;
use App\Models\NominaModels\TalentoHumano\Empleados\Relaciones\EmpleadoRelacionExperienciaLaborales;
use App\Models\NominaModels\TalentoHumano\Empleados\Relaciones\EmpleadoRelacionFamiliares;
use App\Models\NominaModels\TalentoHumano\Empleados\Relaciones\EmpleadoRelacionPersonales;

use App\Models\Sagrilaft\SagrilaftEmpleadoUrlRelacion;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory, HasUuids;
    protected $table = "nomina_th_empleados";
    protected $primaryKey = "empleado_id";
    protected $fillable = [
        "empleado_id",
        "convocatoria__rel_id",
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

    // public function convocatoriaRelacionPostulantes()
    // {
    //     return $this->hasMany(ConvocatoriaRelacionPostulante::class, 'postulante_id');
    // }
    public function academia()
    {
        return $this->hasMany(
            EmpleadoRelacionAcademia::class,
            'empleado_id',
            'empleado_id'
        )->with(['academia']);
    }
    public function experienciaLaboral()
    {
        return $this->hasMany(
            EmpleadoRelacionExperienciaLaborales::class,
            'empleado_id',
            'empleado_id'
        )->with(['experiencia_laboral']);
    }

    public function familiares()
    {
        return $this->hasMany(
            EmpleadoRelacionFamiliares::class,
            'empleado_id',
            'empleado_id'
        )->with(['familiares']);
    }

    public function personales()
    {
        return $this->hasMany(
            EmpleadoRelacionPersonales::class,
            'empleado_id',
            'empleado_id'
        )->with(['personales']);
    }

    public function complementarios()
    {
        return $this->hasMany(
            EmpleadoRelacionComplementarios::class,
            'empleado_id',
            'empleado_id'
        )->with(['complementarios']);
    }

    public function validaciones()
    {
        return $this->hasMany(
            SagrilaftEmpleadoUrlRelacion::class,
            'empleado_id',
            'empleado_id'
        )->with(['resources']);
    }
}

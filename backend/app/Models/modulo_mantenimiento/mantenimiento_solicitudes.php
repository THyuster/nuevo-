<?php

namespace App\Models\modulo_mantenimiento;

use App\Models\erp\app\Estados;
use App\Models\erp\app\Prioridades;
use App\Models\erp\app\TiposSolicitud;
use App\Models\modulo_activos_fijos\activos_fijos_equipos;
use App\Models\modulo_contabilidad\contabilidad_terceros;
use App\Models\modulo_logistica\logistica_vehiculos;
use App\Models\modulo_nomina\nomina_centros_trabajo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mantenimiento_solicitudes extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    protected $table = "mantenimiento_solicitudes";
    protected $fillable = [
        "id_solicitud",
        "fecha_solicitud",
        "fecha_cierre",
        "estado_id",
        "fecha_finalizacion",
        "tercero_id",
        "centro_trabajo_id",
        "prioridad_id",
        "tipo_solicitud_id",
        "equipo_id",
        "vehiculo_id",
        "observacion",
        "ruta_imagen",
        "usuario_id",
        "origen",
        "id_signatures"
    ];

    public function estado()
    {
        return $this->belongsTo(Estados::class, 'estado_id');
    }

    public function tercero()
    {
        return $this->belongsTo(contabilidad_terceros::class, 'tercero_id');
    }

    public function centroTrabajo()
    {
        return $this->belongsTo(nomina_centros_trabajo::class, 'centro_trabajo_id');
    }

    public function prioridad()
    {
        return $this->belongsTo(Prioridades::class, 'prioridad_id');
    }

    public function tipoSolicitud()
    {
        return $this->belongsTo(TiposSolicitud::class, 'tipo_solicitud_id');
    }

    public function equipo()
    {
        return $this->belongsTo(activos_fijos_equipos::class, 'equipo_id', 'codigo');
    }

    public function vehiculo()
    {
        return $this->belongsTo(logistica_vehiculos::class, 'vehiculo_id', 'placa');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}

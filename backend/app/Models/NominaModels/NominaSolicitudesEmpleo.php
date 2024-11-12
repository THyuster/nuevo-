<?php

namespace App\Models\NominaModels;

use App\Utils\Encryption\EncryptionFunction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NominaSolicitudesEmpleo extends Model
{
    use HasFactory;
    protected $connection = '';
    protected $table = 'nomina_solicitudes_empleo';
    protected $primaryKey = "nomina_solicitudes_empleo_id";

    public function setObservacionSolicitudoAttribute($value)
    {
        $this->attributes['observacion_solicitud'] = htmlspecialchars($value);
    }

    public function setUserIdAttribute($value)
    {
        $valor = EncryptionFunction::StaticDesencriptacion($value);
        if ($valor != '' && $valor) {
            $this->attributes['user_id'] = $valor;
        }else{
            $this->attributes['user_id'] = $value;
        }
    }

    protected $fillable = [
        'fecha_solicitud_empleo',
        'user_id',
        'nomina_centro_trabajo_id',
        'nomina_cargo_id',
        'estado_prioridad_id',
        'numero_puestos',
        'observacion_solicitud',
        'aprobada'
    ];
}

<?php

namespace App\Models\NominaModels\Blacklist;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NominaBlacklist extends Model
{
    use HasFactory;

    protected $table = 'nomina_backlist';
    protected $primaryKey = "id";
    protected $fillable = [
        'identificacion',
        'nombres',
        'apellidos',
        'observaciones',
    ];

    public function setIdentificacionAttribute($value)
    {
        $this->attributes['identificacion'] = trim(strip_tags($value));
    }

    // Mutador para sanitizar nombres y apellidos
    public function setNombresAttribute($value)
    {
        $this->attributes['nombres'] = trim(strip_tags($value));
    }

    public function setApellidosAttribute($value)
    {
        $this->attributes['apellidos'] = trim(strip_tags($value));
    }

    // Mutador para sanitizar observaciones
    public function setObservacionesAttribute($value)
    {
        $this->attributes['observaciones'] = trim(strip_tags($value));
    }

}

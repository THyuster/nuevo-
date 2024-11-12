<?php

namespace App\Models\NominaModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nomina_cargos extends Model
{
    use HasFactory;

    // protected $connection = ''; 
    protected $table = 'nomina_cargos';

    protected $primaryKey = "nomina_cargo_id";

    public function convocatorias()
    {
        return $this->hasMany(NominaConvocatoriasView::class, 'nomina_cargo_id', 'nomina_cargo_id');
    }

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = htmlspecialchars($value);
    }
    public function setRequisitosMinimosPuestoAttribute($value)
    {
        $this->attributes['requisitos_minimos_puesto'] = htmlspecialchars($value);
    }

    public function setDescripcionPuestoAttribute($value)
    {
        $this->attributes['descripcion_puesto'] = htmlspecialchars($value);
    }

    public function setCodigoCargoAttribute($value)
    {
        $this->attributes['codigo_cargo'] = htmlspecialchars($value);
    }
    protected $fillable = [
        'nombre',
        'requisitos_minimos_puesto',
        'descripcion_puesto',
        'salario_puesto',
        'codigo_cargo',
    ];
}

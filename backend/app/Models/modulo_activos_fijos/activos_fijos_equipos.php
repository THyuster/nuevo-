<?php

namespace App\Models\modulo_activos_fijos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class activos_fijos_equipos extends Model
{
    use HasFactory;
    protected $table = "activos_fijos_equipos";
    protected $primaryKey = "id";
    // protected $timestamps = true;
    protected $fillable = [
        'codigo',
        'descripcion',
        'grupo_equipo_id',
        'fecha_adquisicion',
        'fecha_instalacion',
        'serial_interno',
        'serial_equipo',
        'modelo',
        'marcaId',
        'potencia',
        'proveedorId',
        'mantenimiento',
        'horometro',
        'costo',
        'combustible',
        'uso_diario',
        'upm',
        'area',
        'labor',
        'administradorId',
        'ingenieroId',
        'jefe_mantenimiento_id',
        'operador_id',
        'observaciones',
        'ruta_imagen',
        'estado',
        'peso_kgs',
        'altura_mts',
        'ancho_mts',
        'largo_mts',
        'temp_centigrados',
        'rpm',
        'inventario_unidad_id',
        'cabinado'
    ];
}

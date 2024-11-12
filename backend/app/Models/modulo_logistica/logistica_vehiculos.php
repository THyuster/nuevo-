<?php

namespace App\Models\modulo_logistica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class logistica_vehiculos extends Model
{
    use HasFactory;
    protected $table = "logistica_vehiculos";
    protected $primaryKey = "id";
    protected $fillable = [
        "tercero_propietario_id",
        "tercero_conductor_id",
        "fecha_afiliacion",
        "fecha_desvinculacion",
        "fecha_operacion",
        "propio",
        "modificado",
        "tipo_vehiculo_id",
        "logistica_grupo_vehiculo_id",
        "logistica_tipo_contrato_id",
        "combustible_id",
        "blindaje_id",
        "logistica_ejes_id",
        "observaciones",
        "tipo_servicio_id",
        "codigo_interno",
        "licencia_propiedad",
        "centro_trabajo_id",
        "placa",
        "marca_id",
        "modelo",
        "linea_id",
        "color_id",
        "serial_motor",
        "serial_chasis",
        "serial_vin",
        "trailer_id",
        "modelo_trailer",
        "capacidad_kg_psj",
        "capacidad_ton",
        "cilindraje",
        "tara_vehiculo",
        "pasajeros",
        "kilometraje_ini",
        "horometro_ini",
        "potencia_hp",
        "fecha_compra",
        "valor_comercial",
        "soat_empresa",
        "soat_valor",
        "soat_fecha_ini",
        "soat_fecha_fin",
        "gps_empresa",
        "gps_usuario",
        "gps_contrasena",
        "gps_id",
        "gps_numero",
        "gases_empresa",
        "gases_valor",
        "gases_fecha_ini",
        "gases_fecha_fin",
        "seguro_empresa",
        "numero_seguro",
        "seguro_valor",
        "seguro_fecha_ini",
        "seguro_fecha_fin",
        "ruta_imagen",
        "ruta_ficha_tecnica",
        "estado",
        "todo_riesgo_empresa",
        "numero_todo_riesgo",
        "todo_riesgo_valor",
        "todo_riesgo_fecha_ini",
        "todo_riesgo_fecha_fin",
    ];
}

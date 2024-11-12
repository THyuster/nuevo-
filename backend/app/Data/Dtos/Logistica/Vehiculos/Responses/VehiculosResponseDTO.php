<?php

namespace App\Data\Dtos\Logistica\Vehiculos\Responses;

/**
 * Data Transfer Object para la respuesta de datos del vehículo.
 */
class VehiculosResponseDTO
{
    public $id;
    public $tercero_propietario_id;
    public $tercero_conductor_id;
    public $fecha_afiliacion;
    public $fecha_desvinculacion;
    public $fecha_operacion;
    public $propio;
    public $modificado;
    public $tipo_vehiculo_id;
    public $logistica_grupo_vehiculo_id;
    public $logistica_tipo_contrato_id;
    public $combustible_id;
    public $blindaje_id;
    public $logistica_ejes_id;
    public $observaciones;
    public $tipo_servicio_id;
    public $codigo_interno;
    public $licencia_propiedad;
    public $centro_trabajo_id;
    public $placa;
    public $marca_id;
    public $modelo;
    public $linea_id;
    public $color_id;
    public $serial_motor;
    public $serial_chasis;
    public $serial_vin;
    public $trailer_id;
    public $modelo_trailer;
    public $capacidad_kg_psj;
    public $capacidad_ton;
    public $cilindraje;
    public $tara_vehiculo;
    public $pasajeros;
    public $kilometraje_ini;
    public $horometro_ini;
    public $potencia_hp;
    public $fecha_compra;
    public $valor_comercial;
    public $soat_empresa;
    public $soat_valor;
    public $soat_fecha_ini;
    public $soat_fecha_fin;
    public $gps_empresa;
    public $gps_usuario;
    public $gps_contrasena;
    public $gps_id;
    public $gps_numero;
    public $gases_empresa;
    public $gases_valor;
    public $gases_fecha_ini;
    public $gases_fecha_fin;
    public $seguro_empresa;
    public $numero_seguro;
    public $seguro_valor;
    public $seguro_fecha_ini;
    public $seguro_fecha_fin;
    public $ruta_imagen;
    public $ruta_ficha_tecnica;
    public $estado;
    public $todo_riesgo_empresa;
    public $numero_todo_riesgo;
    public $todo_riesgo_valor;
    public $todo_riesgo_fecha_ini;
    public $todo_riesgo_fecha_fin;
    public $created_at;
    public $updated_at;
    /**
     * Constructor del DTO.
     *
     * @param object $vehiculo Objeto que contiene los datos del vehículo.
     */
    public function __construct($vehiculo)
    {
        $this->id = $vehiculo->id;
        $this->tercero_propietario_id = $vehiculo->tercero_propietario_id;
        $this->tercero_conductor_id = $vehiculo->tercero_conductor_id;
        $this->fecha_afiliacion = $vehiculo->fecha_afiliacion;
        $this->fecha_desvinculacion = $vehiculo->fecha_desvinculacion;
        $this->fecha_operacion = $vehiculo->fecha_operacion;
        $this->propio = $vehiculo->propio;
        $this->modificado = $vehiculo->modificado;
        $this->tipo_vehiculo_id = $vehiculo->tipo_vehiculo_id;
        $this->logistica_grupo_vehiculo_id = $vehiculo->logistica_grupo_vehiculo_id;
        $this->logistica_tipo_contrato_id = $vehiculo->logistica_tipo_contrato_id;
        $this->combustible_id = $vehiculo->combustible_id;
        $this->blindaje_id = $vehiculo->blindaje_id;
        $this->logistica_ejes_id = $vehiculo->logistica_ejes_id;
        $this->observaciones = $vehiculo->observaciones;
        $this->tipo_servicio_id = $vehiculo->tipo_servicio_id;
        $this->codigo_interno = $vehiculo->codigo_interno;
        $this->licencia_propiedad = $vehiculo->licencia_propiedad;
        $this->centro_trabajo_id = $vehiculo->centro_trabajo_id;
        $this->placa = $vehiculo->placa;
        $this->marca_id = $vehiculo->marca_id;
        $this->modelo = $vehiculo->modelo;
        $this->linea_id = $vehiculo->linea_id;
        $this->color_id = $vehiculo->color_id;
        $this->serial_motor = $vehiculo->serial_motor;
        $this->serial_chasis = $vehiculo->serial_chasis;
        $this->serial_vin = $vehiculo->serial_vin;
        $this->trailer_id = $vehiculo->trailer_id;
        $this->modelo_trailer = $vehiculo->modelo_trailer;
        $this->capacidad_kg_psj = $vehiculo->capacidad_kg_psj;
        $this->capacidad_ton = $vehiculo->capacidad_ton;
        $this->cilindraje = $vehiculo->cilindraje;
        $this->tara_vehiculo = $vehiculo->tara_vehiculo;
        $this->pasajeros = $vehiculo->pasajeros;
        $this->kilometraje_ini = $vehiculo->kilometraje_ini;
        $this->horometro_ini = $vehiculo->horometro_ini;
        $this->potencia_hp = $vehiculo->potencia_hp;
        $this->fecha_compra = $vehiculo->fecha_compra;
        $this->valor_comercial = $vehiculo->valor_comercial;
        $this->soat_empresa = $vehiculo->soat_empresa;
        $this->soat_valor = $vehiculo->soat_valor;
        $this->soat_fecha_ini = $vehiculo->soat_fecha_ini;
        $this->soat_fecha_fin = $vehiculo->soat_fecha_fin;
        $this->gps_empresa = $vehiculo->gps_empresa;
        $this->gps_usuario = $vehiculo->gps_usuario;
        $this->gps_contrasena = $vehiculo->gps_contrasena;
        $this->gps_id = $vehiculo->gps_id;
        $this->gps_numero = $vehiculo->gps_numero;
        $this->gases_empresa = $vehiculo->gases_empresa;
        $this->gases_valor = $vehiculo->gases_valor;
        $this->gases_fecha_ini = $vehiculo->gases_fecha_ini;
        $this->gases_fecha_fin = $vehiculo->gases_fecha_fin;
        $this->seguro_empresa = $vehiculo->seguro_empresa;
        $this->numero_seguro = $vehiculo->numero_seguro;
        $this->seguro_valor = $vehiculo->seguro_valor;
        $this->seguro_fecha_ini = $vehiculo->seguro_fecha_ini;
        $this->seguro_fecha_fin = $vehiculo->seguro_fecha_fin;
        $this->ruta_imagen = $vehiculo->ruta_imagen;
        $this->ruta_ficha_tecnica = $vehiculo->ruta_ficha_tecnica;
        $this->estado = $vehiculo->estado;
        $this->todo_riesgo_empresa = $vehiculo->todo_riesgo_empresa;
        $this->numero_todo_riesgo = $vehiculo->numero_todo_riesgo;
        $this->todo_riesgo_valor = $vehiculo->todo_riesgo_valor;
        $this->todo_riesgo_fecha_ini = $vehiculo->todo_riesgo_fecha_ini;
        $this->todo_riesgo_fecha_fin = $vehiculo->todo_riesgo_fecha_fin;
        $this->created_at = $vehiculo->created_at;
        $this->updated_at = $vehiculo->updated_at;
    }
}

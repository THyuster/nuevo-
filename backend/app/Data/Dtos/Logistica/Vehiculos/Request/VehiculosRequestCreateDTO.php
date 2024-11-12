<?php

namespace App\Data\Dtos\Logistica\Vehiculos\Request;

/**
 * Data Transfer Object para la creación de vehículos.
 */
class VehiculosRequestCreateDTO
{
    public $terceroPropietarioId;
    public $terceroConductorId;
    public $fechaAfiliacion;
    public $fechaDesvinculacion;
    public $fechaOperacion;
    public $propio;
    public $modificado;
    public $tipoVehiculoId;
    public $logisticaGrupoVehiculoId;
    public $logisticaTipoContratoId;
    public $combustibleId;
    public $blindajeId;
    public $logisticaEjesId;
    public $observaciones;
    public $tipoServicioId;
    public $codigoInterno;
    public $licenciaPropiedad;
    public $centroTrabajoId;
    public $placa;
    public $marcaId;
    public $modelo;
    public $lineaId;
    public $colorId;
    public $serialMotor;
    public $serialChasis;
    public $serialVin;
    public $trailerId;
    public $modeloTrailer;
    public $capacidadKgPsj;
    public $capacidadTon;
    public $cilindraje;
    public $taraVehiculo;
    public $pasajeros;
    public $kilometrajeIni;
    public $horometroIni;
    public $potenciaHp;
    public $fechaCompra;
    public $valorComercial;
    public $soatEmpresa;
    public $soatValor;
    public $soatFechaIni;
    public $soatFechaFin;
    public $gpsEmpresa;
    public $gpsUsuario;
    public $gpsContrasena;
    public $gpsId;
    public $gpsNumero;
    public $gasesEmpresa;
    public $gasesValor;
    public $gasesFechaIni;
    public $gasesFechaFin;
    public $seguroEmpresa;
    public $numeroSeguro;
    public $seguroValor;
    public $seguroFechaIni;
    public $seguroFechaFin;
    public $rutaImagen;
    public $rutaFichaTecnica;
    public $estado;
    public $todoRiesgoEmpresa;
    public $numeroTodoRiesgo;
    public $todoRiesgoValor;
    public $todoRiesgoFechaIni;
    public $todoRiesgoFechaFin;
    /**
     * Constructor del DTO.
     * 
     * @param array $vehiculo Datos del vehículo para inicializar el DTO.
     */
    public function __construct(array $vehiculo)
    {
        $this->terceroPropietarioId = $vehiculo["tercero_propietario_id"] ?? null;
        $this->terceroConductorId = $vehiculo["tercero_conductor_id"] ?? null;
        $this->fechaAfiliacion = $vehiculo["fecha_afiliacion"] ?? null;
        $this->fechaDesvinculacion = $vehiculo["fecha_desvinculacion"] ?? null;
        $this->fechaOperacion = $vehiculo["fecha_operacion"] ?? null;
        $this->propio = boolval($vehiculo["propio"]) ?? null;
        $this->modificado = boolval($vehiculo["modificado"]) ?? null;
        $this->tipoVehiculoId = $vehiculo["tipo_vehiculo_id"] ?? null;
        $this->logisticaGrupoVehiculoId = $vehiculo["logistica_grupo_vehiculo_id"] ?? null;
        $this->logisticaTipoContratoId = $vehiculo["logistica_tipo_contrato_id"] ?? null;
        $this->combustibleId = $vehiculo["combustible_id"] ?? null;
        $this->blindajeId = $vehiculo["blindaje_id"] ?? null;
        $this->logisticaEjesId = $vehiculo["logistica_ejes_id"] ?? null;
        $this->observaciones = $vehiculo["observaciones"] ?? null;
        $this->tipoServicioId = $vehiculo["tipo_servicio_id"] ?? null;
        $this->codigoInterno = $vehiculo["codigo_interno"] ?? null;
        $this->licenciaPropiedad = $vehiculo["licencia_propiedad"] ?? null;
        $this->centroTrabajoId = $vehiculo["centro_trabajo_id"] ?? null;
        $this->placa = $vehiculo["placa"] ?? null;
        $this->marcaId = $vehiculo["marca_id"] ?? null;
        $this->modelo = $vehiculo["modelo"] ?? null;
        $this->lineaId = $vehiculo["linea_id"] ?? null;
        $this->colorId = $vehiculo["color_id"] ?? null;
        $this->serialMotor = $vehiculo["serial_motor"] ?? null;
        $this->serialChasis = $vehiculo["serial_chasis"] ?? null;
        $this->serialVin = $vehiculo["serial_vin"] ?? null;
        $this->trailerId = $vehiculo["trailer_id"] ?? null;
        $this->modeloTrailer = $vehiculo["modelo_trailer"] ?? null;
        $this->capacidadKgPsj = $vehiculo["capacidad_kg_psj"] ?? null;
        $this->capacidadTon = $vehiculo["capacidad_ton"] ?? null;
        $this->cilindraje = $vehiculo["cilindraje"] ?? null;
        $this->taraVehiculo = $vehiculo["tara_vehiculo"] ?? null;
        $this->pasajeros = $vehiculo["pasajeros"] ?? null;
        $this->kilometrajeIni = $vehiculo["kilometraje_ini"] ?? null;
        $this->horometroIni = $vehiculo["horometro_ini"] ?? null;
        $this->potenciaHp = $vehiculo["potencia_hp"] ?? null;
        $this->fechaCompra = $vehiculo["fecha_compra"] ?? null;
        $this->valorComercial = $vehiculo["valor_comercial"] ?? null;
        $this->soatEmpresa = $vehiculo["soat_empresa"] ?? null;
        $this->soatValor = $vehiculo["soat_valor"] ?? null;
        $this->soatFechaIni = $vehiculo["soat_fecha_ini"] ?? null;
        $this->soatFechaFin = $vehiculo["soat_fecha_fin"] ?? null;
        $this->gpsEmpresa = $vehiculo["gps_empresa"] ?? null;
        $this->gpsUsuario = $vehiculo["gps_usuario"] ?? null;
        $this->gpsContrasena = $vehiculo["gps_contrasena"] ?? null;
        $this->gpsId = $vehiculo["gps_id"] ?? null;
        $this->gpsNumero = $vehiculo["gps_numero"] ?? null;
        $this->gasesEmpresa = $vehiculo["gases_empresa"] ?? null;
        $this->gasesValor = $vehiculo["gases_valor"] ?? null;
        $this->gasesFechaIni = $vehiculo["gases_fecha_ini"] ?? null;
        $this->gasesFechaFin = $vehiculo["gases_fecha_fin"] ?? null;
        $this->seguroEmpresa = $vehiculo["seguro_empresa"] ?? null;
        $this->numeroSeguro = $vehiculo["numero_seguro"] ?? null;
        $this->seguroValor = $vehiculo["seguro_valor"] ?? null;
        $this->seguroFechaIni = $vehiculo["seguro_fecha_ini"] ?? null;
        $this->seguroFechaFin = $vehiculo["seguro_fecha_fin"] ?? null;
        $this->rutaImagen = $vehiculo["ruta_imagen"] ?? null;
        $this->rutaFichaTecnica = $vehiculo["ruta_ficha_tecnica"] ?? null;
        $this->estado = $vehiculo["estado"] ?? true;
        $this->todoRiesgoEmpresa = $vehiculo["todo_riesgo_empresa"] ?? null;
        $this->numeroTodoRiesgo = $vehiculo["numero_todo_riesgo"] ?? null;
        $this->todoRiesgoValor = $vehiculo["todo_riesgo_valor"] ?? null;
        $this->todoRiesgoFechaIni = $vehiculo["todo_riesgo_fecha_ini"] ?? null;
        $this->todoRiesgoFechaFin = $vehiculo["todo_riesgo_fecha_fin"] ?? null;
    }
    /**
     * Convierte el DTO a un array asociativo.
     * 
     * @return array Los datos del vehículo en formato de array.
     */
    public function toArray()
    {
        return [
            "tercero_propietario_id" => $this->terceroPropietarioId,
            "tercero_conductor_id" => $this->terceroConductorId,
            "fecha_afiliacion" => $this->fechaAfiliacion,
            "fecha_desvinculacion" => $this->fechaDesvinculacion,
            "fecha_operacion" => $this->fechaOperacion,
            "propio" => $this->propio,
            "modificado" => $this->modificado,
            "tipo_vehiculo_id" => $this->tipoVehiculoId,
            "logistica_grupo_vehiculo_id" => $this->logisticaGrupoVehiculoId,
            "logistica_tipo_contrato_id" => $this->logisticaTipoContratoId,
            "combustible_id" => $this->combustibleId,
            "blindaje_id" => $this->blindajeId,
            "logistica_ejes_id" => $this->logisticaEjesId,
            "observaciones" => $this->observaciones,
            "tipo_servicio_id" => $this->tipoServicioId,
            "codigo_interno" => $this->codigoInterno,
            "licencia_propiedad" => $this->licenciaPropiedad,
            "centro_trabajo_id" => $this->centroTrabajoId,
            "placa" => $this->placa,
            "marca_id" => $this->marcaId,
            "modelo" => $this->modelo,
            "linea_id" => $this->lineaId,
            "color_id" => $this->colorId,
            "serial_motor" => $this->serialMotor,
            "serial_chasis" => $this->serialChasis,
            "serial_vin" => $this->serialVin,
            "trailer_id" => $this->trailerId,
            "modelo_trailer" => $this->modeloTrailer,
            "capacidad_kg_psj" => $this->capacidadKgPsj,
            "capacidad_ton" => $this->capacidadTon,
            "cilindraje" => $this->cilindraje,
            "tara_vehiculo" => $this->taraVehiculo,
            "pasajeros" => $this->pasajeros,
            "kilometraje_ini" => $this->kilometrajeIni,
            "horometro_ini" => $this->horometroIni,
            "potencia_hp" => $this->potenciaHp,
            "fecha_compra" => $this->fechaCompra,
            "valor_comercial" => $this->valorComercial,
            "soat_empresa" => $this->soatEmpresa,
            "soat_valor" => $this->soatValor,
            "soat_fecha_ini" => $this->soatFechaIni,
            "soat_fecha_fin" => $this->soatFechaFin,
            "gps_empresa" => $this->gpsEmpresa,
            "gps_usuario" => $this->gpsUsuario,
            "gps_contrasena" => $this->gpsContrasena,
            "gps_id" => $this->gpsId,
            "gps_numero" => $this->gpsNumero,
            "gases_empresa" => $this->gasesEmpresa,
            "gases_valor" => $this->gasesValor,
            "gases_fecha_ini" => $this->gasesFechaIni,
            "gases_fecha_fin" => $this->gasesFechaFin,
            "seguro_empresa" => $this->seguroEmpresa,
            "numero_seguro" => $this->numeroSeguro,
            "seguro_valor" => $this->seguroValor,
            "seguro_fecha_ini" => $this->seguroFechaIni,
            "seguro_fecha_fin" => $this->seguroFechaFin,
            "ruta_imagen" => $this->rutaImagen,
            "ruta_ficha_tecnica" => $this->rutaFichaTecnica,
            "estado" => $this->estado,
            "todo_riesgo_empresa" => $this->todoRiesgoEmpresa,
            "numero_todo_riesgo" => $this->numeroTodoRiesgo,
            "todo_riesgo_valor" => $this->todoRiesgoValor,
            "todo_riesgo_fecha_ini" => $this->todoRiesgoFechaIni,
            "todo_riesgo_fecha_fin" => $this->todoRiesgoFechaFin,
        ];
    }
}
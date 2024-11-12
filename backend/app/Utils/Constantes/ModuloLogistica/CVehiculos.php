<?php

namespace App\Utils\Constantes\ModuloLogistica;

final class CVehiculos
{
    protected $date;

    function sqlFuncion($tabla): string
    {
        return "SELECT * FROM `$tabla`";
    }

    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
    }
    function sqlTerceros(): string
    {
        return "SELECT CONCAT(nombre1,' ',nombre2,' ',apellido1,' ',apellido2) AS nombre_completo, 
        CONCAT(apellido1,' ',apellido2) AS apellidos, CONCAT(nombre1,' ',nombre2) AS nombres, identificacion, movil, email 
        FROM `contabilidad_terceros`";
    }
    public function sqlSelectByCode(string $codigo): string
    {
        return "SELECT * FROM `logistica_vehiculos` WHERE codigo = '$codigo'";
    }

    public function sqlSelectAll(): string
    {
        return "SELECT * FROM logistica_vehiculos_view";
    }
    public function sqlSelectById(int $id): string
    {
        return "SELECT * FROM `logistica_vehiculos` WHERE id = '$id'";
    }
    public function sqlInsert($entidadVehiculo): string
    {
        $consultaCampos = '';
        $consultaValues = '';

        foreach ($entidadVehiculo as $atributo => $valor) {
            $consultaCampos .= "`$atributo`, ";
            $consultaValues .= (is_string($valor)) ? "UPPER('$valor')," : "'$valor',";
        }

        $consultaCampos = rtrim($consultaCampos, ', ');
        $consultaValues = rtrim($consultaValues, ', ');

        return "INSERT INTO `logistica_vehiculos` (`created_at`, `updated_at`,$consultaCampos,`estado`) VALUES ('$this->date', '$this->date', $consultaValues,1)";
    }
    public function sqlUpdate(int $id, $entidadVehiculo): string
    {
        $consultaSet = '';
        foreach ($entidadVehiculo as $atributo => $valor) {
            $consultaSet .= (is_string($valor)) ? "`$atributo`= UPPER('$valor'), " : "`$atributo`= ('$valor'), ";
        }
        $consultaSet = rtrim($consultaSet, ', ');
        return "UPDATE `logistica_vehiculos` SET `updated_at`='$this->date',$consultaSet WHERE `id` = '$id'";
    }
    public function sqlEstadoUpdate(int $id, int $estado): string
    {
        return "UPDATE `logistica_vehiculos` SET `estado` = '$estado' WHERE `id` = '$id'";
    }
    public function sqlDelete(int $id): string
    {
        return "DELETE FROM `logistica_vehiculos` WHERE `id` = '$id'";
    }
    public function consultaId(string $tabla, $id): string
    {
        return ($tabla == "contabilidad_terceros") ? "SELECT * FROM $tabla WHERE `identificacion` = '$id' " :
            "SELECT * FROM $tabla WHERE `id` = '$id'";
    }
    public function constanteSqlValidacionId(): array
    {
        return array(
            "combustible_id" => "logistica_combustibles",
            "marca_id" => "logistica_marcas",
            "tercero_propietario_id" => "contabilidad_terceros",
            "tipo_vehiculo_id" => "tipos_vehiculos"
        );
    }
}

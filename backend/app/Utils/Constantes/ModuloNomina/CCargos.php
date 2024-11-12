<?php
namespace App\Utils\Constantes\ModuloNomina;

class CCargos
{
    protected $date;

    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
    }

    public function sqlCodigoCargoOrNombreCargo($nombre, $codigo_cargo): string
    {
        return "SELECT 
        CASE 
            WHEN nombre = '$nombre' THEN 'Nombre ya registrado'
            
        END AS nombre_status,
        CASE 
            WHEN codigo_cargo = '$codigo_cargo' THEN 'Código ya registrado'
        
        END AS codigo_status
        FROM nomina_cargos
            WHERE nombre = '$nombre' OR codigo_cargo = '$codigo_cargo'";
    }
    public function sqlCodigoCargoOrNombreCargoDiferent($nombre, $codigo_cargo, $nomina_cargo_id): string
    {
        return "SELECT 
        CASE 
            WHEN nombre = '$nombre' THEN 'Nombre ya registrado'
            
        END AS nombre_status,
        CASE 
            WHEN codigo_cargo = '$codigo_cargo' THEN 'Código ya registrado'
        
        END AS codigo_status
        FROM nomina_cargos
            WHERE nombre = '$nombre' AND codigo_cargo = '$codigo_cargo' AND nomina_cargo_id <> '$nomina_cargo_id'";
    }

    public function sqlSelectByCode(string $codigo): string
    {
        return "SELECT * FROM nomina_cargos WHERE codigo = '$codigo'";
    }
    public function sqlSelectByCodeDifferentId(string $id, string $codigo): string
    {
        return "SELECT * FROM nomina_cargos WHERE codigo = '$codigo' AND id_cargo != '$id'";
    }
    public function sqlSelectByCharge(string $codigo): string
    {
        return "SELECT * FROM nomina_cargos WHERE cargo = '$codigo'";
    }
    public function sqlSelectByChargeDifferentId(string $id, string $codigo): string
    {
        return "SELECT * FROM nomina_cargos WHERE cargo = '$codigo' AND id_cargo != '$id'";
    }

    public function sqlSelectAll(): string
    {
        return "SELECT  nc.id_cargo, nc.codigo, nc.cargo, ncs.descripcion as cargo_sena, nc.cargo_sena_id, tc.tipo, tc.id as idTipoCargo 
        FROM nomina_cargos nc 
        LEFT JOIN nomina_cargos_sena ncs ON nc.cargo_sena_id = ncs.id 
        INNER JOIN mla_erp_data.tipo_cargo tc ON nc.tipo_cargo=tc.id";
    }
    public function sqlSelectById(string $id): string
    {
        return "SELECT * FROM nomina_cargos WHERE id_cargo = '$id'";
    }

    public function sqlInsert($entidadTiposSolicitudes): string
    {
        $consultaCampos = '';
        $consultaValues = '';

        foreach ($entidadTiposSolicitudes as $atributo => $valor) {
            $consultaCampos .= "`$atributo`, ";
            $consultaValues .= (is_string($valor)) ? "UPPER('$valor')," : "'$valor',";
        }

        $consultaCampos = rtrim($consultaCampos, ', ');
        $consultaValues = rtrim($consultaValues, ', ');

        return "INSERT INTO nomina_cargos (`created_at`, `updated_at`,$consultaCampos) VALUES ('$this->date', '$this->date', $consultaValues)";
    }

    public function sqlUpdate(string $id, $entidadTiposSolicitudes): string
    {
        $consultaSet = '';
        foreach ($entidadTiposSolicitudes as $atributo => $valor) {
            $consultaSet .= (is_string($valor)) ? "`$atributo`= UPPER('$valor'), " : "`$atributo`= ('$valor'), ";
        }
        $consultaSet = rtrim($consultaSet, ', ');
        return "UPDATE nomina_cargos SET `updated_at`='$this->date',$consultaSet WHERE `id_cargo` = '$id'";
    }

    public function sqlDelete(string $id): string
    {
        return "DELETE FROM nomina_cargos WHERE `id_cargo` = '$id'";
    }

}

<?php
namespace App\Utils\Constantes\ModuloNomina;

class CCentroTrabajo
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

    public function sqlSelectByCode(string $codigo): string
    {
        return "SELECT * FROM nomina_centros_trabajos WHERE codigo = '$codigo'";
    }

    public function sqlSelectAll(): string
    {
        return " SELECT * FROM nomina_centros_trabajos";
    }
    public function sqlSelectById($id): string
    {
        return "SELECT * FROM nomina_centros_trabajos WHERE id = '$id'";
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

        return "INSERT INTO nomina_centros_trabajos (`created_at`, `updated_at`,$consultaCampos,`estado`) VALUES ('$this->date', '$this->date', $consultaValues,1)";
    }

    public function sqlUpdate(int $id, $entidadTiposSolicitudes): string
    {
        $consultaSet = '';
        foreach ($entidadTiposSolicitudes as $atributo => $valor) {
            $consultaSet .= (is_string($valor)) ? "`$atributo`= UPPER('$valor'), " : "`$atributo`= ('$valor'), ";
        }
        $consultaSet = rtrim($consultaSet, ', ');
        return "UPDATE nomina_centros_trabajos SET `updated_at`='$this->date',$consultaSet WHERE `id` = '$id'";
    }

    public function sqlDelete(int $id): string
    {
        return "DELETE FROM nomina_centros_trabajos WHERE `id` = '$id'";
    }
    public function sqlUpdateEstado($id, $estado)
    {
        return "UPDATE nomina_centros_trabajos
        SET `updated_at`='$this->date',`estado`='$estado'
        WHERE `id` = '$id'";
    }
}
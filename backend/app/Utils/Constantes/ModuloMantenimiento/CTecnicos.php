<?php

namespace App\Utils\Constantes\ModuloMantenimiento;

final class CTecnicos
{
    protected $date;
    protected $fecha;

    function sqlFuncion($tabla): string
    {
        return "SELECT * FROM $tabla";
    }

    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
        $this->fecha = date("Y-m-d");
    }

    public function sqlSelectByTercero($id): string
    {
        return "SELECT * FROM mantenimiento_tecnicos WHERE tercero_id= '$id'";
    }
    public function sqlSelectByuserId($usuarioId): string
    {
        return "SELECT * FROM mantenimiento_tecnicos WHERE user_id= $usuarioId";
    }

    public function sqlSelectAll(): string
    {
        return "SELECT tecnicos.id, users.name, tecnicos.user_id FROM mantenimiento_tecnicos  tecnicos
        JOIN mla_erp_data.users users
        ON users.id  =tecnicos.user_id";
    }

    public function sqlSelectById(string $id): string
    {
        return "SELECT * FROM mantenimiento_tecnicos WHERE id = $id";
    }

    public function sqlInsert($entidadTecnicos): string
    {
        $camposInsertar = '';
        $camposValores = '';

        foreach ($entidadTecnicos as $atributo => $valor) {
            if ($valor != null) {
                $camposInsertar .= "`$atributo`, ";
                $camposValores .= (is_string($valor)) ? "UPPER('$valor')," : "'$valor',";
            }
        }

        $camposInsertar = rtrim($camposInsertar, ', ');
        $camposValores = rtrim($camposValores, ', ');

        return "INSERT INTO mantenimiento_tecnicos (`created_at`, `updated_at`,$camposInsertar,`estado`) VALUES ('$this->date','$this->date',$camposValores,1)";
    }

    public function sqlUpdate(int $id, $entidadTecnicos): string
    {
        $consultaSet = '';

        foreach ($entidadTecnicos as $atributo => $valor) {
            $consultaSet .= "`$atributo` = " . ($valor !== null ? (is_string($valor) ? "UPPER('$valor')" : "'$valor'") : "NULL") . ", ";
            if ($atributo === "fecha_final" && $valor === null) {
                $consultaSet .= "`estado` = '1', ";
            }
        }

        $consultaSet = rtrim($consultaSet, ', ');

        return "UPDATE mantenimiento_tecnicos SET `updated_at`='$this->date',$consultaSet WHERE `id` = '$id'";
    }


    public function sqlEstadoUpdate(int $id, int $estado): string
    {
        $fechaFinal = ($estado === 0) ? "`fecha_final`='$this->fecha'" : "`fecha_final`=NULL, `fecha_inicio`='$this->fecha'";
        return "UPDATE mantenimiento_tecnicos SET `updated_at`='$this->date',$fechaFinal,`estado`='$estado' WHERE `id`='$id'";
    }

    public function sqlDelete(int $id): string
    {
        return "DELETE FROM mantenimiento_tecnicos WHERE `id` = '$id'";
    }

    public function consultaId(string $tabla, $id): string
    {
        return ($tabla == "contabilidad_terceros") ? "SELECT * FROM $tabla WHERE `identificacion` = '$id' " :
            "SELECT * FROM $tabla WHERE `id` = '$id'";
    }

    public function consultaSqlSelectores($tabla)
    {
        return "SELECT * FROM $tabla";
    }

    public function constanteSqlValidacionId(): array
    {
        return array(
            "tercero_id" => "contabilidad_terceros",
        );
    }

    function sqlTerceros(): string
    {
        return "SELECT CONCAT(nombre1,' ',nombre2,' ',apellido1,' ',apellido2) AS nombre_completo, 
        CONCAT(apellido1,' ',apellido2) AS apellidos, CONCAT(nombre1,' ',nombre2) AS nombres, identificacion, movil, email 
        FROM `contabilidad_terceros`";
    }


    public function getTecnicosByOrdenId($id)
    {
        return "SELECT u.email, mot.tipo_orden_id FROM mantenimiento_ordenes_tecnicos mot INNER JOIN users u ON u.id = tecnico_id WHERE mot.orden_id = '$id' ";
    }

    public $camposDB = [
        // Array con los campos proporcionados
        'id',
        'created_at',
        'updated_at',
        'tercero_id',
        'fecha_inicio',
        'fecha_final',
        'observaciones',
        'especialidad',
        'estado'
    ];

    public $rules = [
        'userId' => "required|int",
    ];

    public $rulesActualizar = [
        'tercero_id' => "required|int",

    ];

    public $mensajes = [
        'required' => 'El campo :attribute es obligatorio.',

    ];
}

<?php

namespace App\Utils\Constantes\ModuloMantenimiento;

use App\Utils\Constantes\DB\tablas;
use Illuminate\Support\Facades\Auth;

final class CSolicitudes
{
    protected $date;
    protected $tablaCMantenimientoSolicitudes;
    
    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
        $this->tablaCMantenimientoSolicitudes = tablas::getTablaClienteMantenimientoSolicitudes();
    }
    function sqlFuncion($tabla): string
    {
        return "SELECT * FROM $tabla";
    }


    public function sqlSelectByCode(string $codigo): string
    {
        return "SELECT * FROM $this->tablaCMantenimientoSolicitudes WHERE codigo = '$codigo'";
    }

    public function sqlSelectAll(): string
    {
        $user = Auth::user();
        $idUsuario = $user->id;
        return "SELECT s.*, s.id AS numero_solicitud, 
        e.nombre AS estado_descripcion,
        u.name as 'Usuario_solicitud',
        CONCAT(t.apellido1,' ',t.apellido2) AS apellidos_solicitante, 
        CONCAT(t.nombre1,' ',t.nombre2) AS nombres_solicitante,            
        t.movil AS movil_solicitante,
        u.email AS email_solicitante,
        c.descripcion AS centro_trabajo_descripcion, 
        p.nombre AS prioridad_descripcion, ts.descripcion AS tipo_solicitud_descripcion,
        eq.descripcion AS equipo_descripcion, v.codigo_interno AS matricula_vehiculo FROM $this->tablaCMantenimientoSolicitudes s LEFT JOIN mla_erp_data.estados e ON s.estado_id = e.id
        LEFT JOIN contabilidad_terceros t ON s.tercero_id = t.identificacion LEFT JOIN nomina_centros_trabajos c ON s.centro_trabajo_id = c.id
        LEFT JOIN mla_erp_data.prioridades p ON s.prioridad_id = p.id LEFT JOIN mla_erp_data.tipos_solicitud ts ON s.tipo_solicitud_id = ts.id 
        LEFT JOIN activos_fijos_equipos eq ON s.equipo_id = eq.codigo LEFT JOIN logistica_vehiculos v ON s.vehiculo_id = v.id 
        LEFT JOIN mla_erp_data.users u ON u.id = s.usuario_id WHERE usuario_id = '$idUsuario'";
    }

    public function sqlSelectById($id): string
    {
        return "SELECT * FROM $this->tablaCMantenimientoSolicitudes WHERE id = '$id'";
    }
    public function sqlSelectByIdSolicitudClassic($id): string
    {
        return "SELECT * FROM $this->tablaCMantenimientoSolicitudes WHERE id_solicitud = '$id'";
    }
    public function sqlSelectByIdSolicitudes($id): string
    {
        return "SELECT * FROM $this->tablaCMantenimientoSolicitudes WHERE id_solicitud = '$id'";
    }
    public function sqlSelectByIdSolicitud($id): string
    {
        return "SELECT s.*, s.id AS numero_solicitud, 
        e.nombre AS estado_descripcion,
        u.name as 'Usuario_solicitud',
        CONCAT(t.apellido1,' ',t.apellido2) AS apellidos_solicitante, 
        CONCAT(t.nombre1,' ',t.nombre2) AS nombres_solicitante,            
        t.movil AS movil_solicitante,
        u.email AS email_solicitante,
        c.descripcion AS centro_trabajo_descripcion, 
        p.nombre AS prioridad_descripcion, ts.descripcion AS tipo_solicitud_descripcion,
        eq.codigo AS equipo_descripcion, v.placa AS matricula_vehiculo FROM $this->tablaCMantenimientoSolicitudes s LEFT JOIN mla_erp_data.estados e ON s.estado_id = e.id
        LEFT JOIN contabilidad_terceros t ON s.tercero_id = t.identificacion LEFT JOIN nomina_centros_trabajos c ON s.centro_trabajo_id = c.id
        LEFT JOIN mla_erp_data.prioridades p ON s.prioridad_id = p.id LEFT JOIN mla_erp_data.tipos_solicitud ts ON s.tipo_solicitud_id = ts.id 
        LEFT JOIN activos_fijos_equipos eq ON s.equipo_id = eq.codigo LEFT JOIN logistica_vehiculos v ON s.vehiculo_id = v.placa
        LEFT JOIN mla_erp_data.users u ON u.id = s.usuario_id WHERE id_solicitud = '$id'";
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

        return "INSERT INTO $this->tablaCMantenimientoSolicitudes (`created_at`, `updated_at`,`fecha_solicitud`,$consultaCampos) VALUES ('$this->date','$this->date','$this->date',$consultaValues)";
    }

    public function sqlUpdate($id, $entidadTiposSolicitudes): string
    {
        $consultaSet = '';
        foreach ($entidadTiposSolicitudes as $atributo => $valor) {
            if ($valor != null) {
                $consultaSet .= (is_string($valor)) ? "`$atributo`= UPPER('$valor'), " : "`$atributo`= ('$valor'), ";
            }
        }
        $consultaSet = rtrim($consultaSet, ', ');
        return "UPDATE $this->tablaCMantenimientoSolicitudes SET `updated_at`='$this->date',$consultaSet WHERE id = '$id'";
    }
    public function sqlUpdateEstado($id, $estado): string
    {
        return "UPDATE $this->tablaCMantenimientoSolicitudes SET `estado_id` = '$estado' WHERE `id` = '$id'";
    }

    public function sqlUpdateEnd(int $id, $entidadTiposSolicitudes): string
    {
        $consultaSet = '';
        foreach ($entidadTiposSolicitudes as $atributo => $valor) {
            if ($valor != null) {
                $consultaSet .= (is_string($valor)) ? "`$atributo`= UPPER('$valor'), " : "`$atributo`= ('$valor'), ";
            }
        }
        $consultaSet = rtrim($consultaSet, ', ');
        return "UPDATE $this->tablaCMantenimientoSolicitudes SET `updated_at`='$this->date',`fecha_cierre`='$this->date', $consultaSet WHERE `id` = '$id'";
    }

    public function sqlEstadoUpdate(int $id, int $estado): string
    {
        return "UPDATE $this->tablaCMantenimientoSolicitudes SET `updated_at`='$this->date', SET `estado_id` = '$estado' WHERE `id` = '$id'";
    }

    public function sqlDelete(int $id): string
    {
        return "DELETE FROM $this->tablaCMantenimientoSolicitudes WHERE `id` = '$id'";
    }

    public function consultaId(string $tabla, $id): string
    {
        if ($tabla == "logistica_vehiculos") {
            return "SELECT * FROM $tabla WHERE placa = '$id'";
        }

        if ($tabla == "activos_fijos_equipos") {
            # code...
            return "SELECT * FROM $tabla WHERE codigo = '$id'";
        }
        return ($tabla == "contabilidad_terceros") ? "SELECT * FROM $tabla WHERE `identificacion` = '$id' " :
            "SELECT * FROM $tabla WHERE id = '$id'";
    }

    public function consultaSqlSelectores($tabla)
    {
        return "SELECT * FROM $tabla";
    }

    public function constanteSqlValidacionId(): array
    {
        return array(
            "estado_id" => "estados",
            "tercero_id" => "contabilidad_terceros",
            "prioridad_id" => "prioridades",
            "tipo_solicitud_id" => "tipos_solicitud",
            "equipo_id" => "activos_fijos_equipos",
            "vehiculo_id" => "logistica_vehiculos",
            "centro_trabajo_id" => "nomina_centros_trabajos"
        );
    }

    function sqlTerceros(): string
    {
        return "SELECT CONCAT(nombre1,' ',nombre2,' ',apellido1,' ',apellido2) AS nombre_completo, 
        CONCAT(apellido1,' ',apellido2) AS apellidos, CONCAT(nombre1,' ',nombre2) AS nombres, identificacion, movil, email 
        FROM contabilidad_terceros";
    }

    public $camposDB = [
        // Array con los campos proporcionados
        'id',
        'created_at',
        'updated_at',
        'estado_id',
        'tercero_id',
        'centro_trabajo_id',
        'prioridad_id',
        'tipo_solicitud_id',
        'equipo_id',
        'vehiculo_id',
        'observacion',
        'ruta_imagen'
    ];

    public $rules = [
        'estado_id' => "nullable",
        'tercero_id' => "nullable",
        'centro_trabajo_id' => "nullable",
        'prioridad_id' => "nullable",
        'tipo_solicitud_id' => "nullable",
        'equipo_id' => "nullable",
        'vehiculo_id' => "nullable",
        'observacion' => "nullable",
        'ruta_imagen' => "nullable"
    ];

    public $rulesActualizar = [
        'estado_id' => "nullable",
        'tercero_id' => "nullable",
        'centro_trabajo_id' => "nullable",
        'prioridad_id' => "nullable",
        'tipo_solicitud_id' => "nullable",
        'equipo_id' => "nullable",
        'vehiculo_id' => "nullable",
        'observacion' => "nullable",
        'ruta_imagen' => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
    ];

    public $mensajes = [
        'required' => 'El campo :attribute es obligatorio.',
        'email' => 'El campo :attribute debe ser una dirección de correo electrónico válida.',
        'integer' => 'El campo :attribute no es un numero.',
        'max' => ':attribute no puede ser mayor de :max',
        'image' => ':attribute debe ser una imagen',
        'mimes' => ':attribute puede ser los siguientes formatos :values'
    ];
}
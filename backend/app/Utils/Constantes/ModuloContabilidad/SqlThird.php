<?php

namespace App\Utils\Constantes\ModuloContabilidad;

use PDO;

class SqlThird
{




    public function sqlFindThird($id)
    {
        return "SELECT * FROM contabilidad_terceros terceros WHERE terceros.id ='$id'";
    }
    public function getSqlFindIdentification($identification)
    {
        return "SELECT * FROM contabilidad_terceros WHERE identificacion = '$identification' ";
    }
    public function getSqlDeleteRelationsTypesThird($id)
    {
        return "DELETE FROM contabilidad_relacion_tipos_terceros WHERE contabilidad_relacion_tipos_terceros.tercero_id = " . $id;
    }

    public function getIdentificationByIdDiferent($id, $identification)
    {
        return "
        SELECT * FROM contabilidad_terceros WHERE contabilidad_terceros.identificacion = '$identification' 
        AND contabilidad_terceros.id != '$id'
        ";
    }

    public function getSqlTypesThirds()
    {
        return "SELECT * FROM contabilidad_relacion_tipos_terceros";
    }

    public function getSqlThird()
    {
        return
            "SELECT 
            tercero.id,
            tercero.nombre1,
            tercero.nombre2,
            tercero.apellido1,
            tercero.apellido2,
            tercero.updated_at as 'fecha_actualizacion',
            tercero.fecha_inactivo,
            tercero.fecha_nacimiento,
            tercero.identificacion,
            tercero.naturaleza_juridica,
            tercero.observacion,
            tercero.grupo_sanguineo_id,
            tercero.empresa,
            DV,
            identificacion.id as 'tipo_identificacion',
            identificacion.descripcion as 'descripcion_identificacion',
            tercero.nombre_completo as 'Nombre completo',
            tercero.direccion,
            tercero.email,
            tercero.telefono_fijo,
            tercero.movil,
            tercero.ruta_imagen as ruta_imagen,
            CONCAT(municipio.id, ' - ', municipio.descripcion) AS 'municipio',
            municipio.id as 'municipioId',
            tercero.estado,
            relacionTerceros.tipo_tercero_id as 'idRelacionTercero'
            FROM contabilidad_terceros tercero
            LEFT JOIN contabilidad_tipos_identificaciones identificacion ON tercero.tipo_identificacion= identificacion.id
            LEFT JOIN contabilidad_municipios municipio ON 
            tercero.municipio= municipio.id
            LEFT JOIN contabilidad_relacion_tipos_terceros relacionTerceros ON relacionTerceros.tercero_id = tercero.id
            ORDER BY tercero.nombre1,
            tercero.nombre2 DESC;
        ";
    }

    public function getTercerosFilter($filter)
    {
        $filterParam = "$filter%";
        $filterParamSanitized = htmlspecialchars($filterParam, ENT_QUOTES, 'UTF-8');

        $sql = "SELECT nombre_completo AS nombre, identificacion, email FROM contabilidad_terceros
        WHERE email LIKE :filter OR nombre2 LIKE :filter OR nombre1 LIKE :filter 
        OR apellido2 LIKE :filter OR apellido1 LIKE :filter 
        OR identificacion LIKE :filter ";

        $sql = str_replace(':filter', "'$filterParamSanitized'", $sql);
        return $sql;
    }

    public function getRelationInFixedAsset($id)
    {
        return
            "SELECT * FROM (
            SELECT a.proveedorId terceroid , 'PROVEEDOR' tipo
            FROM activos_fijos_equipos a
            UNION
            SELECT a.administradorId terceroid , 'ADMINISTRADOR' tipo
            FROM activos_fijos_equipos a
            UNION
            SELECT a.ingenieroId terceroid , 'INGENIERO' tipo
            FROM activos_fijos_equipos a
            UNION
            SELECT a.jefe_mantenimiento_id terceroid , 'JEFE_MANTENIMIENTO' tipo
            FROM activos_fijos_equipos a 
            UNION
            SELECT a.operador_id terceroid , 'OPERADOR' tipo
            FROM activos_fijos_equipos a 
            ) X where x.terceroid = '$id'
            GROUP BY 1,2;";
    }

    public function getThirdsWithoutDv()
    {
        return "SELECT * FROM contabilidad_terceros WHERE DV >0";
    }
}

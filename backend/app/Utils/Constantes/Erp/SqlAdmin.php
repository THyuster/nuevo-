<?php

namespace App\Utils\Constantes\Erp;

class SqlAdmin
{
    private $nameDataBase = "users";
    private $nameDataBaseRelations = " erp_relacion_user_cliente";

    public function getEmail($email)
    {
        return "SELECT * FROM $this->nameDataBase WHERE email = '$email'";
    }

    public function getAdmin($id)
    {
        return "SELECT * FROM $this->nameDataBase WHERE id = $id";
    }
    public function getSqldifferentMail($id, $email)
    {
        return "SELECT * FROM $this->nameDataBase WHERE email = '$email' AND id != '$id'";
    }

    public function getSqlDeleteRelations($id)
    {
        return "DELETE FROM $this->nameDataBaseRelations WHERE user_id ='$id'";
    }

    public function getSqlDataCompanieByLicence($id)
    {
        return "SELECT DISTINCT 
        erp_grupo_empresarial.id,
        contabilidad_empresas.id as 'empresaId', 
        contabilidad_empresas.razon_social as 'empresa', 
        contabilidad_empresas.ruta_imagen AS 'imgEmpresa', 
        erp_grupo_empresarial.descripcion AS 'grupoEmpresarial', 
        erp_grupo_empresarial.ruta_imagen as 'imgGrupoEmpresarial',
        erp_relacion_user_cliente.user_id as id_cliente,
        users.name as nombre
        FROM erp_relacion_licencias 
        LEFT JOIN erp_relacion_empresas ON 
        erp_relacion_empresas.empresa_id = erp_relacion_licencias.empresa_id 
        LEFT JOIN contabilidad_empresas ON 
        contabilidad_empresas.id = erp_relacion_licencias.empresa_id 
        LEFT JOIN erp_licenciamientos ON 
        erp_licenciamientos.id = erp_relacion_licencias.licencia_id 
        LEFT JOIN erp_relacion_user_cliente ON 
        erp_relacion_user_cliente.cliente_id = erp_licenciamientos.cliente_id 
        LEFT JOIN erp_grupo_empresarial ON 
        erp_grupo_empresarial.id = erp_relacion_user_cliente.cliente_id 
        LEFT JOIN users ON
        users.id = erp_relacion_user_cliente.cliente_id
        WHERE erp_relacion_user_cliente.user_id = '$id'";
    }

    public function ObtenerAdministradoresGrupoEmpresarial($id)
    {
        return "SELECT users.name, users.estado as estadoUsuario, contabilidad_empresas.razon_social, erp_grupo_empresarial.descripcion 
        FROM users 
        JOIN erp_relacion_user_empresas ON erp_relacion_user_empresas.user_id = users.id 
        JOIN contabilidad_empresas ON erp_relacion_user_empresas.empresa_id = contabilidad_empresas.id 
        JOIN erp_relacion_empresas ON erp_relacion_empresas.empresa_id = contabilidad_empresas.id 
        JOIN erp_grupo_empresarial ON erp_grupo_empresarial.id = erp_relacion_empresas.cliente_id 
        WHERE users.tipo_administrador = 4 AND erp_relacion_empresas.cliente_id = '$id'";
    }

    public function getSqlUpdateRelation($clientsId, $idAdmin)
    {
        return "UPDATE erp_relacion_user_cliente SET cliente_id='$clientsId' WHERE user_id = '$idAdmin'";
    }
    public function getSqlCantLicences($id)
    {
        return
            "
                SELECT DISTINCT licencia.cantidad_users, licencia.cant_register FROM users 
                LEFT JOIN erp_relacion_user_cliente relacion ON relacion.user_id = users.id 
                LEFT JOIN erp_licenciamientos licencia ON licencia.cliente_id= relacion.cliente_id 
                WHERE relacion.cliente_id=$id
            ";
    }
    public function getSqlRealtionUserClient($idAmin, $idRelation)
    {
        return "
        SELECT cliente_id
        FROM erp_relacion_user_cliente
        WHERE user_id = $idAmin
        AND cliente_id IN 
        (
            SELECT cliente_id
            FROM erp_relacion_user_cliente
            WHERE user_id = $idRelation
        );
        ";
    }

    public function deleteById($idAdmin)
    {
        return "DELETE FROM users WHERE id = $idAdmin";
    }
    public function findRecordByClient($idClient)
    {
        return "SELECT * FROM erp_relacion_user_cliente WHERE erp_relacion_user_cliente.cliente_id= '$idClient'";
    }
    public function findClientsByUser($id)
    {
        return
            "
            SELECT COUNT(*) as count
            FROM erp_relacion_user_cliente 
            WHERE erp_relacion_user_cliente.cliente_id IN 
            (SELECT rc.cliente_id FROM erp_relacion_user_cliente rc WHERE rc.user_id = $id);
        ";
    }
}

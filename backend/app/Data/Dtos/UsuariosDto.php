<?php

namespace App\Data\Dtos;

use App\Data\Models\TipoAdministrador;
use App\Data\Models\UsuarioModel;
use App\Utils\Repository\RepositoryDynamicsCrud;
use JsonSerializable;


class UsuariosDto extends RepositoryDynamicsCrud implements JsonSerializable
{
    private ?int $id;
    private ?string $nombre;
    private ?string $email;
    private ?int $tipo_administrador;
    private ?array $entidadtTipoAdministrador;
    private ?string $estado;

    private ?int $grupo_empresarial;

    public function __construct(UsuarioModel $user)
    {
        $this->id = $user->getId();
        $this->nombre = $user->getName();
        $this->email = $user->getEmail();
        // $this->grupo_empresarial = $user->getGrupoEmpresarial();
        $this->tipo_administrador = $user->getTipoAdministrador();
        $this->estado = $user->getEstado();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->nombre;
    }
    public function setName(string $nombre)
    {
        $this->nombre = $nombre;
    }
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getTipoAdministrador()
    {
        return $this->tipo_administrador;
    }
    public function setTipoAdministrador(int $tipo_administrador)
    {
        $this->tipo_administrador = $tipo_administrador;
    }
    public function getEstado()
    {
        return $this->estado;
    }
    public function setEstado(string $estado)
    {
        $this->estado = $estado;
    }

    public function getEntidadTipoAdministrador()
    {
        return $this->entidadtTipoAdministrador;
    }

    public function setEntidadTipoAdministrador(TiposAdministradorDto $tipoAdministrador)
    {
        $this->entidadtTipoAdministrador = $tipoAdministrador->jsonSerialize();
    }

    public function getGrupoEmpresarial()
    {
        return $this->grupo_empresarial;
    }

    public function setGrupoEmpresarial(int $grupo_empresarial)
    {
        $this->grupo_empresarial = $grupo_empresarial;
    }

    public function jsonSerialize()
    {

        // variables para almacenamiento de información
        $modulos = null;
        $tipo_administrador = $this->sqlFunction("SELECT * FROM tipo_administrador WHERE `id` = '{$this->getTipoAdministrador()}'");
        $modulo_permiso = $this->sqlFunction("SELECT * FROM erp_permisos_modulos WHERE `user_id`='{$this->getId()}'");
        // print_r($modulo_permiso);
        // envio de los tipos de administrador
        foreach ($tipo_administrador as $tAdmin) {
            $tipo_admin = new TipoAdministrador($tAdmin->id, $tAdmin->id_tipo_administrador, $tAdmin->tipo_administrador);
            $tipo_admin = new TiposAdministradorDto($tipo_admin);
            $this->setEntidadTipoAdministrador($tipo_admin);
        }

        // envio de los modulos
        foreach ($modulo_permiso as $modulo) {
            $modulos[] = $modulo->modulo_id;
        }

        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'entidad_administrador' => $this->getEntidadTipoAdministrador(),
            'modulos' => $modulos,
            'estado' => $this->getEstado()
        ];
    }
}
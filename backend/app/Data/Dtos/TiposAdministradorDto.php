<?php

namespace App\Data\Dtos;

use App\Data\Models\TipoAdministrador;
use JsonSerializable;


class TiposAdministradorDto implements JsonSerializable
{
    protected int $id;
    protected string $id_tipo_administrador;
    protected string $tipo_administrador;

    public function __construct(TipoAdministrador $tipoAdministrador)
    {
        $this->id = $tipoAdministrador->getId();
        $this->id_tipo_administrador = $tipoAdministrador->getIdTipoAdministrador();
        $this->tipo_administrador = $tipoAdministrador->getTipoAdministrador();
    }
    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getTipoAdministrador()
    {
        return $this->tipo_administrador;
    }
    public function setTipoAdministrador(int $tipo_administrador)
    {
        $this->tipo_administrador = $tipo_administrador;
    }

    public function getIdTipoAdministrador()
    {
        return $this->id_tipo_administrador;
    }

    public function setIdTipoAdministrador($id_tipo_administrador)
    {
        $this->id_tipo_administrador = $id_tipo_administrador;
    }
    
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'id_tipo_administrador' => $this->getIdTipoAdministrador(),
            'tipo_administrador' => $this->getTipoAdministrador(),
        ];
    }
}
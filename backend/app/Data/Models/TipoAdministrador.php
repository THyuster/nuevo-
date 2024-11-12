<?php

namespace App\Data\Models;


class TipoAdministrador
{
    protected int $id;
    protected string $id_tipo_administrador;
    protected string $tipo_administrador;

    public function __construct(int $id, string $id_tipo_administrador, string $tipo_administrador)
    {
        $this->id = $id;
        $this->id_tipo_administrador = $id_tipo_administrador;
        $this->tipo_administrador = $tipo_administrador;
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

    public function toArray()
    {
        return array(
            'id_tipo_administrador' => $this->getIdTipoAdministrador(),
            'tipo_administrador' => $this->getTipoAdministrador(),
        );
    }
}
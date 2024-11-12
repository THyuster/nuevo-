<?php

namespace App\Data\Models;

use JsonSerializable;


class UsuarioModel implements JsonSerializable
{
    protected ?int $id;
    protected ?string $nombre;
    protected ?string $email;
    protected ?int $tipo_administrador;
    protected ?string $estado;
    protected ?int $grupo_empresarial;
    protected ?string $password;
    public function __construct(?int $id, ?string $nombre, ?string $email, ?int $tipo_administrador, ?string $estado, ?string $password)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->tipo_administrador = $tipo_administrador;
        $this->estado = $estado;
        $this->password = $password;
        // $this->grupo_empresarial = $grupo_empresarial;
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

    public function getGrupoEmpresarial()
    {
        return $this->grupo_empresarial;
    }

    public function setGrupoEmpresarial(int $grupo_empresarial)
    {
        $this->grupo_empresarial = $grupo_empresarial;
    }

    public function getPassword() {
        return $this->password;
    }
    public function setPassword(String $password){
        $this->password = $password;
    }

    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'tipo_administrador' => $this->getTipoAdministrador(),
            'estado' => $this->getEstado()
        );
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'tipo_administrador' => $this->getTipoAdministrador(),
            // 'grupo_empresarial' => $this->getGrupoEmpresarial(),
            'estado' => $this->getEstado()
        ];
    }
}
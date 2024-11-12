<?php

namespace App\Data\Dtos;
use App\Utils\Encryption\EncryptionFunction;

class RolesDto
{
    private $id;
    private $codigo;
    private $descripcion;

    public function __construct($id, $codigo, $descripcion)
    {
        $this->id = $id;
        $this->codigo = $codigo;
        $this->descripcion = $descripcion;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function getId()
    {
        return $this->id;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function jsonSerialize()
    {
        $encriptacion = new EncryptionFunction();
        return [
            'id' => $encriptacion->Encriptacion($this->getId()),
            'codigo' => $this->getCodigo(),
            'descripcion' => $this->getDescripcion(),
        ];
    }

}
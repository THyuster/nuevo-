<?php

namespace App\Data\Dtos\ModuloTesoreria;


class TesoreriaGruposConceptosDto
{
    private String | null $id;
    private String  $nombre;
    private String  $descripcion;

    public function __construct($id, $nombre, $descripcion)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
    }

    public function toArray()
    {
        return [
            "id" => $this->id,
            "nombre" => $this->nombre,
            "descripcion" => $this->descripcion
        ];
    }


    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'] ?? null,
            $data['nombre'] ?? null,
            $data['descripcion'] ?? null
        );
    }



    public function getId()
    {
        return $this->id;
    }
    public function getNombre()
    {
        return $this->nombre;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
}
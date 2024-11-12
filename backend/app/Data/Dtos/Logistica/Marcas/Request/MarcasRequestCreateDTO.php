<?php

namespace App\Data\Dtos\Logistica\Marcas\Request;

class MarcasRequestCreateDTO
{
    public $id;
    public $descripcion;
    public function __construct(array $marcas)
    {
        $this->descripcion = $marcas['descripcion'] ?? null;
        $this->id = $marcas['id'] ?? null;
    }

    public function toArray()
    {
        return [
            "id" => $this->id,
            "descripcion" => $this->descripcion,
        ];
    }
}

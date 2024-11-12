<?php

namespace App\Data\Dtos\ActivosFijos\GruposEquipos\Request;

class GrupoEquipoRequestCreateDTO
{
    public $codigo;
    public $descripcion;

    public function __construct(array $grupoEquipo)
    {
        $this->codigo = $grupoEquipo["codigo"] ?? null;
        $this->descripcion = $grupoEquipo["descripcion"] ?? null;
    }

    public function toArray()
    {
        return [
            "codigo" => $this->codigo,
            "descripcion" => $this->descripcion
        ];
    }
}

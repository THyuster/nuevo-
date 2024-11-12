<?php

namespace App\Data\Dtos\Logistica\Marcas\Responses;

class MarcasResponseDTO
{
    public $id;
    public $descripcion;
    public $created_at;
    public $updated_at;
    public function __construct($marcas)
    {
        $this->id = $marcas->id;
        $this->descripcion = $marcas->descripcion;
        $this->created_at = $marcas->created_at;
        $this->updated_at = $marcas->updated_at;
    }

}

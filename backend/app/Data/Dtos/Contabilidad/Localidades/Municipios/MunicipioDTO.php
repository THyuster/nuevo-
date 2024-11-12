<?php

namespace App\Data\Dtos\Contabilidad\Localidades\Municipios;

class MunicipioDTO
{
    public $id;
    public $codigo;
    public $nombre;
    public $created_at;
    public $updated_at;

    public function __construct($municipio)
    {
        $this->id = $municipio->id ?? null;
        $this->codigo = $municipio->codigo ?? null;
        $this->nombre = $municipio->descripcion ?? null;
        $this->created_at = $municipio->created_at ?? null;
        $this->updated_at = $municipio->updated_at ?? null;
    }
}

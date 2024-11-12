<?php

namespace App\Data\Dtos\Contabilidad\Localidades\Departamentos;
use App\Data\Dtos\Contabilidad\Localidades\Municipios\MunicipioDTO;

class DepartamentoDTO
{
    public $id;
    public $nombre;
    public MunicipioDTO|null $municipio;
    public $created_at;
    public $updated_at;

    public function __construct($departamento)
    {
        $this->id = $departamento->id ?? null;
        $this->nombre = $departamento->descripcion ?? null;
        $this->municipio = $departamento->municipio ?? null;
        $this->created_at = $departamento->created_at ?? null;
        $this->updated_at = $departamento->updated_at ?? null;
    }
}

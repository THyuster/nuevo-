<?php

namespace App\Data\Dtos\Contabilidad\Identificaciones;
use App\Models\modulo_contabilidad\contabilidad_tipos_identificaciones;

class TipoIdentificacionDTO
{
    public $id;
    public $codigo;
    public $descripcion;
    public $created_at;
    public $updated_at;

    public function __construct(contabilidad_tipos_identificaciones $identificacion)
    {
        $this->id = $identificacion->id ?? null;
        $this->codigo = $identificacion->codigo ?? null;
        $this->descripcion = $identificacion->descripcion ?? null;
        $this->created_at = $identificacion->created_at ?? null;
        $this->updated_at = $identificacion->updated_at ?? null;
    }

}

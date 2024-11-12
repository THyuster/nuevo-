<?php

namespace App\Data\Dtos\Sagrilaft\Validacion\Url\Request;

class SagrilaftUrlRequestCreateDTO
{
    public $descripcion;
    /**
     * @var array<SagrilaftUrlCreateDTO>
     */
    public array $urls = [];
    public $tipoValidacion;

    public function __construct($sagrilaftUrlRequestCreate)
    {
        $this->descripcion = $sagrilaftUrlRequestCreate->descripcion ?? null;
        foreach ($sagrilaftUrlRequestCreate->urls ?? [] as $sagrilaftUrlCreateDTO) {
            $this->urls[] = new SagrilaftUrlCreateDTO(json_decode(json_encode($sagrilaftUrlCreateDTO, JSON_FORCE_OBJECT)));
        }
        $this->tipoValidacion = $sagrilaftUrlRequestCreate->tipoValidacion ?? null;
    }

    public function toArray()
    {
        return [
            "descripcion" => $this->descripcion
        ];
    }
}

<?php

namespace App\Data\Dtos\Convocatorias\Convocatoria\Response;
use App\Models\NominaModels\nomina_cargos;

class CargoWithConvocatoriasDTO
{
    public $id;
    public $nombre;
    /**
     * @var array<ConvocatoriaViewResponseDTO>
     */
    public array $convocatorias;

    public function __construct(nomina_cargos $nominaCargo)
    {
        $this->id = $nominaCargo->nomina_cargo_id;
        $this->nombre = $nominaCargo->nombre;
        $this->convocatorias = $nominaCargo->convocatorias->map(function ($convocatoria) {
            return new ConvocatoriaViewResponseDTO($convocatoria);
        })->toArray();
    }

}

<?php

namespace App\Data\Dtos\Sagrilaft\Validacion\Url\Request;

/**
 * Clase Data Transfer Object (DTO) para la creación de URLs en Sagrilaft.
 *
 * Esta clase se utiliza para encapsular los datos de solicitud necesarios
 * para crear una nueva URL en el sistema Sagrilaft. Proporciona un formato
 * estructurado para acceder y manipular estos datos.
 */
class SagrilaftUrlCreateDTO
{
    public string $url;            // URL a ser creada
    public bool $principal;        // Indica si la URL es principal
    public $sagrilaftUrlId;       // ID de la URL en Sagrilaft (opcional)

    /**
     * Constructor de la clase.
     *
     * @param object $sagrilaftUrl Objeto que contiene los datos de la URL.
     */
    public function __construct($sagrilaftUrl)
    {
        $this->url = $sagrilaftUrl->url ?? null;
        $this->principal = $sagrilaftUrl->principal ?? null;
        $this->sagrilaftUrlId = $sagrilaftUrl->sagrilaftUrlId ?? null;
    }

    /**
     * Convierte el objeto DTO a un arreglo asociativo.
     *
     * @return array Datos de la URL en formato de arreglo.
     */
    public function toArray(): array
    {
        return [
            "url" => $this->url,
            "principal" => $this->principal,
            "sagrilaftUrlId" => $this->sagrilaftUrlId,
        ];
    }
}

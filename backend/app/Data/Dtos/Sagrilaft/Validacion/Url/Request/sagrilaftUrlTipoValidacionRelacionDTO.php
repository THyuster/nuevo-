<?php

namespace App\Data\Dtos\Sagrilaft\Validacion\Url\Request;

/**
 * Clase Data Transfer Object (DTO) para la relación entre URLs y tipos de validación en Sagrilaft.
 *
 * Esta clase se utiliza para encapsular los datos de solicitud necesarios
 * para establecer una relación entre una URL y un tipo de validación en el sistema Sagrilaft.
 */
class sagrilaftUrlTipoValidacionRelacionDTO
{
    public $urlId;              // ID de la URL
    public $tipoValidacionId;   // ID del tipo de validación

    /**
     * Constructor de la clase.
     *
     * @param object|null $tipoValidacionRelacion Objeto que contiene los datos de la relación.
     */
    public function __construct($tipoValidacionRelacion = null)
    {
        $this->urlId = $tipoValidacionRelacion->urlId ?? null;
        $this->tipoValidacionId = $tipoValidacionRelacion->tipoValidacionId ?? null;
    }

    /**
     * Convierte el objeto DTO a un arreglo asociativo.
     *
     * @return array Datos de la relación en formato de arreglo.
     */
    public function toArray()
    {
        return [
            "url_id" => $this->urlId,
            "tipo_validacion_id" => $this->tipoValidacionId,
        ];
    }
}

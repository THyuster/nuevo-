<?php

namespace App\Data\Dtos\Response;
use Symfony\Component\HttpFoundation\Response;

/**
 * Clase que representa una respuesta estandarizada para las API.
 *
 * Esta clase encapsula el mensaje, los datos y el código de estado
 * que se enviarán como respuesta a una solicitud HTTP.
 */
class ResponseDTO
{
    public $messages; // Mensajes de respuesta, generalmente para información o errores
    public $data;     // Datos a incluir en la respuesta
    public $code;     // Código de estado HTTP

    /**
     * Constructor de la clase ResponseDTO.
     *
     * @param mixed $messages Mensajes a incluir en la respuesta.
     * @param mixed $data Datos a incluir en la respuesta. (default: array vacio)
     * @param int $code Código de estado HTTP (default: 200 OK).
     */
    public function __construct(
        $messages = '',
        $data = [],
        $code = Response::HTTP_OK
    ) {
        $this->code = $code;       // Asigna el código de estado
        $this->messages = $messages; // Asigna los mensajes
        $this->data = $data;       // Asigna los datos
    }
}

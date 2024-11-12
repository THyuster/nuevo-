<?php
namespace App\Utils;

use Illuminate\Http\JsonResponse;
use Throwable;

class ResponseHandler
{
    protected array $messages;
    protected mixed $data;
    protected int $status;

    /**
     * Constructor de la clase ResponseHandler
     *
     * @param array|string $messages
     * @param mixed $data
     * @param int $status
     */
    public function __construct(array|string $messages = '', mixed $data = null, int $status = 200)
    {
        $this->setMessage($messages);
        $this->setData($data);
        $this->setStatus($status);
    }

    /**
     * Establece los mensajes.
     *
     * @param array|string $messages
     * @return self
     */
    public function setMessage(array|string $messages): self
    {
        $this->messages = is_array($messages) ? $messages : [$messages];
        return $this;
    }

    /**
     * Establece los datos.
     *
     * @param mixed $data
     * @return self
     */
    public function setData(mixed $data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Establece el estado.
     *
     * @param int $status
     * @return self
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Devuelve una respuesta JSON.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function responses(): JsonResponse
    {
        return response()->json([
            'messages' => $this->messages,
            'data' => $this->data,
            'code' => $this->status,
        ], $this->status);
    }

    /**
     * Maneja una excepción y genera una respuesta apropiada.
     *
     * @param \Throwable $e
     * @param int $status
     * @return JsonResponse
     */
    public function handleException(Throwable $e, int $status = 500): JsonResponse
    {
        $this->setMessage('An error occurred')
            ->setData(['error' => $e->getMessage()])
            ->setStatus($status);
        return $this->responses();
    }
}

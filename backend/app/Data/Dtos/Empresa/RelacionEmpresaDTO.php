<?php

namespace App\Data\Dtos\Empresa;

class RelacionEmpresaDTO
{
    public $cliente_id;
    public $user_id;

    public function __construct($cliente_id, $user_id)
    {
        $this->cliente_id = $cliente_id;
        $this->user_id = $user_id;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data["cliente_id"] ?? null,
            $data["user_id"] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            "cliente_id" => $this->cliente_id,
            "user_id" => $this->user_id,
        ];
    }
}

<?php

namespace App\Data\Dtos\Usuario;

class UsuarioCreateRequestDTO
{
    public $name;
    public $email;
    public $tipo_administrador;
    public $cliente_id;
    public $password;
    public $tipo_cargo;
    public $administrador;
    public $estado;

    public function __construct($name, $email, $tipo_administrador, $cliente_id, $password, $tipo_cargo)
    {
        $this->name = $name;
        $this->email = $email;
        $this->tipo_administrador = $tipo_administrador;
        $this->cliente_id = $cliente_id;
        $this->password = $password;
        $this->tipo_cargo = $tipo_cargo;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data["name"] ?? null,
            $data["email"] ?? null,
            $data["tipo_administrador"] ?? null,
            $data['cliente_id'] ?? null,
            $data['password'] ?? null,
            $data['tipo_cargo'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            "name" => $this->name,
            "email" => $this->email,
            "tipo_administrador" => $this->tipo_administrador,
            "password" => $this->password,
            "cliente_id" => $this->cliente_id,
            "tipo_cargo" => $this->tipo_cargo,
            "administrador" => $this->administrador,
            "estado" => $this->estado,
        ];
    }
}

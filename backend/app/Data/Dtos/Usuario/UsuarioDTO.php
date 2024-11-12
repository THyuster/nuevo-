<?php

namespace App\Data\Dtos\Usuario;

class UsuarioDTO
{
    public $name;
    public $email;
    public $tipo_administrador;
    public $password;
    public $tipo_cargo;
    public $administrador;
    public $estado;

    public function __construct($name, $email, $tipo_administrador, $password, $tipo_cargo, $administrador, $estado)
    {
        $this->name = $name;
        $this->email = $email;
        $this->tipo_administrador = $tipo_administrador;
        $this->password = $password;
        $this->tipo_cargo = $tipo_cargo;
        $this->administrador = $administrador;
        $this->estado = $estado;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data["name"] ?? null,
            $data["email"] ?? null,
            $data["tipo_administrador"] ?? null,
            $data['password'] ?? null,
            $data['tipo_cargo'] ?? null,
            $data['administrador'] ?? null,
            $data['estado'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            "name" => $this->name,
            "email" => $this->email,
            "tipo_administrador" => $this->tipo_administrador,
            "password" => $this->password,
            "tipo_cargo" => $this->tipo_cargo,
            "administrador" => $this->administrador,
            "estado" => $this->estado,
        ];
    }
}

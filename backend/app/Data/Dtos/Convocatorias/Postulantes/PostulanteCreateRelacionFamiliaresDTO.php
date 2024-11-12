<?php

namespace App\Data\Dtos\Convocatorias\Postulantes;

class PostulanteCreateRelacionFamiliaresDTO
{
    public $id;
    public $nombreCompleto;
    public $telefono;
    public $parentesco;
    public $direccion;
    public $cedula;

    public function __construct(array $data)
    {
        $this->nombreCompleto = $data['nombre_completo'] ?? null;
        $this->telefono = $data['telefono'] ?? null;
        $this->parentesco = $data['parentesco'] ?? null;
        $this->direccion = $data['direccion'] ?? null;
        $this->cedula = $data['cedula'] ?? null;
        $this->id = $data['id'] ?? uuid_create();
    }
    /**
     * Convierte el objeto actual en un array asociativo.
     *
     * Este método transforma las propiedades del objeto en un array, donde cada clave
     * del array corresponde a una propiedad del objeto. Es útil para serializar el objeto
     * en un formato que pueda ser fácilmente manipulado o convertido a JSON.
     *
     * @return array Un array asociativo que representa el objeto, con las siguientes claves:
     *               - "id": Identificador del objeto.
     *               - "nombre_completo": Nombre completo de la persona.
     *               - "telefono": Número de teléfono de la persona.
     *               - "parentesco": Tipo de parentesco.
     *               - "direccion": Dirección de la persona.
     *               - "cedula": Número de cédula o identificación.
     */
    public function toArray()
    {
        return [
            "id" => $this->id,
            "nombre_completo" => $this->nombreCompleto,
            "telefono" => $this->telefono,
            "parentesco" => $this->parentesco,
            "direccion" => $this->direccion,
            "cedula" => $this->cedula,
        ];
    }
}

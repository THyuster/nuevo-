<?php

namespace App\Data\Dtos\Convocatorias\Postulantes;

class PostulanteCreateRelacionPersonalDTO
{
    public $id;
    public $nombreCompleto;
    public $telefono;
    public $relacion;
    public $direccion;
    public $cedula;

    public function __construct(array $data)
    {
        $this->nombreCompleto = $data['nombre_completo'] ?? null;
        $this->telefono = $data['telefono'] ?? null;
        $this->relacion = $data['relacion'] ?? null;
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
     *               - "relacion": Tipo de relación.
     *               - "direccion": Dirección de la persona.
     *               - "cedula": Número de cédula o identificación.
     */
    public function toArray()
    {
        return [
            "id" => $this->id,
            "nombre_completo" => $this->nombreCompleto,
            "telefono" => $this->telefono,
            "relacion" => $this->relacion,
            "direccion" => $this->direccion,
            "cedula" => $this->cedula,
        ];
    }
}

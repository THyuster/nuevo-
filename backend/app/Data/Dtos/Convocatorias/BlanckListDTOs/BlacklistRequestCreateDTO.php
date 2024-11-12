<?php

namespace App\Data\Dtos\Convocatorias\BlanckListDTOs;

class BlacklistRequestCreateDTO
{
    // public $id;
    // public $created_at;
    // public $updated_at;
    public $identificacion;
    public $nombres;
    public $apellidos;
    public $observaciones;

    // Constructor para inicialización opcional de propiedades
    public function __construct($data = []) {
        if (!empty($data)) {
            // $this->id = $data['id'] ?? null;
            // $this->created_at = $data['created_at'] ?? null;
            // $this->updated_at = $data['updated_at'] ?? null;
            $this->identificacion = $data['identificacion'] ?? null;
            $this->nombres = $data['nombres'] ?? null;
            $this->apellidos = $data['apellidos'] ?? null;
            $this->observaciones = $data['observaciones'] ?? null;
        }
    }

    // Método para convertir el objeto DTO a un array asociativo
    public function toArray() {
        return [
            // 'id' => $this->id,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
            'identificacion' => $this->identificacion,
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'observaciones' => $this->observaciones,
        ];
    }
}

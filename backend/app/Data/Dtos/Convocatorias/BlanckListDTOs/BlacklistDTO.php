<?php

namespace App\Data\Dtos\Convocatorias\BlanckListDTOs;

use App\Models\NominaModels\Blacklist\NominaBlacklist;
use Illuminate\Database\Eloquent\Model;

class BlacklistDTO
{
    public $id;
    public $created_at;
    public $updated_at;
    public $identificacion;
    public $nombres;
    public $apellidos;
    public $observaciones;

    // Constructor para inicialización opcional de propiedades
    public function __construct(Model|NominaBlacklist $blacklist)
    {
        // if (!empty($data)) {
        $this->id = $blacklist->id;
        $this->created_at = $blacklist->created_at;
        $this->updated_at = $blacklist->updated_at;
        $this->identificacion = $blacklist->identificacion;
        $this->nombres = $blacklist->nombres;
        $this->apellidos = $blacklist->apellidos;
        $this->observaciones = $blacklist->observaciones;
        // }
    }

    // Método para convertir el objeto DTO a un array asociativo
    public function toArray()
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'identificacion' => $this->identificacion,
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'observaciones' => $this->observaciones,
        ];
    }
}

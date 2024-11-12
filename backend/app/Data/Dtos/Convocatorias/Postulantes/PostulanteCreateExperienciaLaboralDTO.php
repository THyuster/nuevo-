<?php

namespace App\Data\Dtos\Convocatorias\Postulantes;

class PostulanteCreateExperienciaLaboralDTO
{
    public $id;
    public $empresa;
    public $cargo;
    public $jefe;
    public $telefono;
    public $responsabilidades;
    public $fecha_inicio;
    public $fecha_fin;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? uuid_create();
        $this->empresa = $data['empresa'];
        $this->cargo = $data['cargo'];
        $this->jefe = $data['jefe'];
        $this->telefono = $data['telefono'];
        $this->responsabilidades = $data['responsabilidades'];
        $this->fecha_inicio = $data['fecha_inicio'];
        $this->fecha_fin = $data['fecha_fin'];
    }


    public function toArray(){
        return [
            "id" => $this->id,
            "empresa" => $this->empresa,
            "cargo"=> $this->cargo,
            "jefe" => $this->jefe,
            "telefono" => $this->telefono,
            "responsabilidades"=> $this->responsabilidades,
            "fecha_inicio" => $this->fecha_inicio,
            "fecha_fin" => $this->fecha_fin
        ];
    }
}

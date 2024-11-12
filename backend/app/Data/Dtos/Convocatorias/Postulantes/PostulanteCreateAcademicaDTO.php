<?php

namespace App\Data\Dtos\Convocatorias\Postulantes;

class PostulanteCreateAcademicaDTO
{
    public string $id;
    public string $createdAt;
    public string $updatedAt;
    public ?string $institucion;
    public ?string $tituloObtenido;
    public ?string $fechaInicial;
    public ?string $fechaFinal;
    public ?string $ciudad;

    public function __construct(
        array $data
    ) {
        $this->id = $data['id'] ?? uuid_create();
        $this->institucion = $data['institucion'];
        $this->tituloObtenido = $data['titulo_obtenido'];
        $this->fechaInicial = $data['fecha_inicial'];
        $this->fechaFinal = $data['fecha_final'];
        $this->ciudad = $data['ciudad'];
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'institucion' => $this->institucion,
            'titulo_obtenido' => $this->tituloObtenido,
            'fecha_inicial' => $this->fechaInicial,
            'fecha_final' => $this->fechaFinal,
            'ciudad' => $this->ciudad
        ];
    }
}

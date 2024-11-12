<?php

namespace App\Data\Dtos\Convocatorias\Postulantes\Responses\Convocatorias;
use App\Data\Dtos\Convocatorias\Postulantes\Responses\ResponsePostulanteConvocatoria;
use App\Utils\MyFunctions;

class PostulanteConvocatoriaDTO
{
    public int $id;
    public string $fecha_postulacion;
    public string $estado;
    public string $nombreConvocatoria;
    public ResponsePostulanteConvocatoria $postulante;

    public function __construct($postulante)
    {
        $convocatoria = new ConvocatoriaResponse($postulante->convocatoria);
        $this->postulante = new ResponsePostulanteConvocatoria($postulante->postulante);
        $this->id = $postulante->id;
        $this->fecha_postulacion = $postulante->fecha_postulacion;
        $this->estado = MyFunctions::obtenerEstado($postulante->estado);
        $this->nombreConvocatoria = $convocatoria->nombre;
    }
}
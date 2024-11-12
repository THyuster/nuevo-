<?php

namespace App\Utils\TransfersData\ModuloTesoreria;

use App\Data\Dtos\ModuloTesoreria\TesoreriaConceptosDto;


interface IServicioConceptos
{

    public function obtenerConceptos($encriptarDato);
    public function obtenerConceptosSinEncriptar(array $response, $encriptarDato);

    public function crearConceptos(TesoreriaConceptosDto $tesoreriaConceptosDto);

    public function actualizarConceptos(TesoreriaConceptosDto $tesoreriaConceptosDto);

    public function eliminarConceptos($id);

    public function buscarConceptoPorId(String $id);
}
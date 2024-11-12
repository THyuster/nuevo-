<?php

namespace App\Utils\TransfersData\ModuloTesoreria;

use App\Data\Dtos\ModuloTesoreria\TesoreriaGruposConceptosDto;
use Illuminate\Http\Request;

interface IServicioGruposConceptos
{

    public function obtenerGrupoConceptos();

    public function crearGrupoConceptos(TesoreriaGruposConceptosDto $tesoreriaGruposConceptosDto);

    public function actualizarGrupoConceptos(TesoreriaGruposConceptosDto $tesoreriaGruposConceptosDto);

    public function eliminarGrupoConceptos($id);

    public function buscarGrupoConceptoPorId(String $id);
}
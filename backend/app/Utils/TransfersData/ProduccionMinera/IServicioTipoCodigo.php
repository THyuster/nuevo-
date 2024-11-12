<?php

namespace App\Utils\TransfersData\ProduccionMinera;

use Illuminate\Http\Request;

interface IServicioTipoCodigo
{
    public function obtenerTiposCodigos();
    public function obtenerCodigoPorId(String $id);
    public function crearTipoCodigo(array $entidadTipoCodigo);
    public function actualizarTipoCodigo(String $id, array $entidadTipoCodigo);
    public function eliminarTipoCodigo(String $id);
    public function validarTipoCodigoPorId(String $id);
}

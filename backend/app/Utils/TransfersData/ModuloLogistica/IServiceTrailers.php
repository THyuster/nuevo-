<?php
namespace App\Utils\TransfersData\ModuloLogistica;

interface IServiceTrailers
{
    public function crearTrailer($entidadTrailer): string;
    public function actualizarTrailer(int $id,$entidadTrailer): string;
    public function eliminarTrailer(int $id): string;
    public function getTrailer();
}
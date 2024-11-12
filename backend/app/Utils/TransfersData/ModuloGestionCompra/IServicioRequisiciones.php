<?php

namespace App\Utils\TransfersData\ModuloGestionCompra;

use Symfony\Component\HttpFoundation\Response;

interface IServicioRequisiciones
{
    public function obtenerRequisiciones(): Response;
    public function obtenerRequisicionesPorId(string $id);

    public function crearRequisiciones(array $data): Response;
    public function actualizarRequisiciones(string $id, array $data): Response;

    public function eliminarRequisiciones(string $id): Response;

    public function actualizarEstadoRequisiciones(string $id): Response;
    public function obtenerArticulosEquipos(): Response;
}

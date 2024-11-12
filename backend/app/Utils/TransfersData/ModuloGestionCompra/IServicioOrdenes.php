<?php

namespace App\Utils\TransfersData\ModuloGestionCompra;

use Symfony\Component\HttpFoundation\Response;

interface IServicioOrdenes
{
    public function obtenerOrdenes(): Response;
    public function obtenerOrdenesPorId(string $id);

    public function crearOrdenes(array $data): Response;
    public function actualizarOrdenes(string $id, array $data): Response;

    public function eliminarOrdenes(string $id): Response;

    public function actualizarEstadoOrdenes(string $id): Response;
}

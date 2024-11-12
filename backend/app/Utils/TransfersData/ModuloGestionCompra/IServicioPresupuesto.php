<?php

namespace App\Utils\TransfersData\ModuloGestionCompra;

use Symfony\Component\HttpFoundation\Response;

interface IServicioPresupuesto
{
    public function obtenerPresupuestos(): Response;
    public function obtenerPresupuestosPorId(string $id);

    public function crearPresupuestos(array $data): Response;
    public function actualizarPresupuestos(string $id, array $data): Response;

    public function eliminarPresupuestos(string $id): Response;

    public function actualizarEstadoPresupuestos(string $id): Response;
}

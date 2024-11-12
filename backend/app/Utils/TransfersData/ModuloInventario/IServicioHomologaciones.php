<?php

namespace App\Utils\TransfersData\ModuloInventario;


use Exception;

interface IServicioHomologaciones
{




    public function obtenerHomologaciones();

    public function create($nuevaHomologacion);

    public function update($id, $nuevaHomologacion);

    public function delete($id);

    public function statusUpdate($id);

    public function buscarHomologacion($id);

    public function buscarCodigo($data, $id = null);
}

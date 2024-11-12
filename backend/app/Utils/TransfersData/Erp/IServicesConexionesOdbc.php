<?php

namespace App\Utils\TransfersData\Erp;



interface IServicesConexionesOdbc
{

    public function getConnectionOdbc();
    public function getConnectionOdbc2();
    public function findConnectionConexionOdbc(string $id);
    public function createConnectionOdbc(array $nuevaConexionOdbc);
    public function updateConnectionOdbc(String $id, array $actualizarConexionOdbc);
    public function deleteConnectionConexionOdbc(String $id);
}

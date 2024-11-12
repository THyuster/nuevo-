<?php

namespace App\Utils\TransfersData\ModuloConfiguracion;

use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\Constantes\ModuloConfiguracion\DisenoVistas;

class ConsultasVistas
{
    protected $repositoryDynamicsCrud;
    protected $constantesVistas;

    public function __construct()
    {
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->constantesVistas = new DisenoVistas;
    }

    public function create($data, $idSubmenu)
    {
        if (!$this->subMenuExistente($idSubmenu, $data['descripcion'], $data['ruta'])) {
            throw new \Exception('Ya existente', 400);
        }
        return $this->insertSubMenu($idSubmenu, $data['descripcion'], $data['ruta'],$data['orden']);
    }

    public function update($id, $data)
    {
        // if (!$this->subMenuExistente($data['idSubmenu'], $data['descripcion'], $data['ruta'])) {
        //     return "existe";
        // }
        return $this->updateSubmenu($id, $data['idSubmenu'], $data['descripcion'], $data['ruta'],$data['orden']);
    }

    public function delete($id)
    {
        return  $this->deleteSubMenu($id);
    }

    public function changeStatus($id)
    {
        $data = $this->repositoryDynamicsCrud->sqlFunction($this->constantesVistas->getSqlVistas($id));
        $status = ($data[0]->estado == 1) ? 0 : 1;
        $this->repositoryDynamicsCrud->sqlFunction($this->constantesVistas->updateSqlVistasEstado($status, $id));
        $dataNew = $this->repositoryDynamicsCrud->sqlFunction($this->constantesVistas->getSqlVistas($id));
        return ($dataNew[0]->estado == $status) ? "Actualizo" : "No actualizo";
    }

    private function insertSubMenu($idSubmenu, $descripcion, $ruta,$orden)
    {
        $this->repositoryDynamicsCrud->sqlFunction($this->constantesVistas->insertSqlVista($idSubmenu, $descripcion, $ruta,$orden));
        return (!$this->subMenuExistente($idSubmenu, $descripcion, $ruta)) ? 'Creo' : 'No creo';
    }

    private function subMenuExistente($idSubmenu, $descripcion, $ruta)
    {
        $data = $this->repositoryDynamicsCrud->sqlFunction($this->constantesVistas->getMenuExistente($idSubmenu, $descripcion, $ruta));
        return (empty($data)) ? true : false;
    }

    private function updateSubmenu($id, $idSubmenu, $descripcion, $ruta,$orden)
    {
        $data = $this->repositoryDynamicsCrud->sqlFunction($this->constantesVistas->getSqlBeforeData($idSubmenu, $id));
        $this->repositoryDynamicsCrud->sqlFunction($this->constantesVistas->updateSqlVista($descripcion, $ruta, $orden,$idSubmenu, $id, $data[0]->descripcion, $data[0]->ruta,$data[0]->orden));
        return (!$this->subMenuExistente($idSubmenu, $descripcion, $ruta)) ? 'Actualizo' : 'No actualizo';
    }

    private function deleteSubMenu($id)
    {
        $this->repositoryDynamicsCrud->sqlFunction($this->constantesVistas->deleteSqlVista($id));
        return 'Borro';
    }
}
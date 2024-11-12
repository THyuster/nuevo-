<?php

namespace App\Utils\TransfersData\ModuloConfiguracion;

use Illuminate\Support\Facades\DB;
use App\Utils\Constantes\ModuloConfiguracion\DisenoModulos;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\MyFunctions;
use App\Utils\Constantes\ModuloConfiguracion\DisenoSubmenus;


class ConsultasSubmenus
{
    protected $repositoryDynamicsCrud;
    protected $constantesSubmenuses;

    public function __construct()
    {
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->constantesSubmenuses = new DisenoSubmenus;
    }

    // Crea submenus
    public function create($data, $idMenu)
    {
        
        if ($this->subMenuExistente($idMenu, $data['descripcion'])) {
            return $this->insertSubMenu($idMenu, $data['descripcion'],$data['orden']);
        }
        return 'Ya existe';
    }

    // Actualiza submenus
    public function update($id, $data)
    {
        return $this->updateSubmenu($id, $data['idMenu'], $data['descripcion'],$data['orden']);
    }

    // Elimina Submenus
    public function delete($id)
    {
        return  $this->deleteSubMenu($id);
    }

    // Cambia el estado del submenu
    public function changeStatus($id){
        $data = $this->repositoryDynamicsCrud->sqlFunction($this->constantesSubmenuses->getSqlSubmenu($id));
        $status = ($data[0]->estado == 1) ? 0 : 1;
        $this->repositoryDynamicsCrud->sqlFunction($this->constantesSubmenuses->updateStatusSubmenuses($status,$id));
        $dataNew = $this->repositoryDynamicsCrud->sqlFunction($this->constantesSubmenuses->getSqlSubmenu($id));
        return ($dataNew[0]->estado == $status) ? "Actualizo" : "No actualizo" ;
    }

    // inserta datos en la base de datos
    private function insertSubMenu($idMenu, $descripcion,$orden)
    {
        $this->repositoryDynamicsCrud->sqlFunction($this->constantesSubmenuses->insertSubmenu($idMenu,$descripcion,$orden));
        return (!$this->subMenuExistente($idMenu, $descripcion)) ? 'Creo' : 'No creo';
    }

    // Hace una comprobación de la existencia del submenu 
    // retorna true si el submenu no existe y false si el submenu existe
    private function subMenuExistente($idMenu, $descripcion)
    {
        $data = $this->repositoryDynamicsCrud->sqlFunction($this->constantesSubmenuses->menuSqlSubmenusesExistente($idMenu,$descripcion));
        return (empty($data)) ? true : false;
    }

    // hace la actualizacion de submenus a la base de datos
    private function updateSubmenu($id, $idMenu, $descripcion,$orden)
    {   
        $data = $this->repositoryDynamicsCrud->sqlFunction( $this->constantesSubmenuses->updateGetSqlDataBefore($idMenu,$id));
        $this->repositoryDynamicsCrud->sqlFunction($this->constantesSubmenuses->updateSqlSubmenuses($descripcion,$orden,$idMenu,$id,$data[0]->descripcion,$data[0]->orden));
        return (!$this->subMenuExistente($idMenu, $descripcion)) ? 'Actualizo' : 'No actualizo';
    }

    // Elimina el submenu
    private function deleteSubMenu($id)
    {
        $this->repositoryDynamicsCrud->sqlFunction($this->constantesSubmenuses->deleteSqlSubmenuses($id));
        return 'Borro';
    }
  
}
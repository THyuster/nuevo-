<?php
namespace App\Utils\TransfersData\ModuloMantenimiento\Horometros;

use App\Utils\Constantes\ModuloMantenimiento\Horometros\CHorometros;
use App\Utils\Constantes\ModuloNomina\CCentroTrabajo;
use App\Utils\MyFunctions;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Illuminate\Support\Facades\Auth;
use Exception;


class SMantenimientoHorometros extends RepositoryDynamicsCrud implements IMantenimientoHorometros
{

    private CHorometros $_Horometros;
    private CCentroTrabajo $_centroTrabajo;

    private MyFunctions $_MYFunctions;

    public function __construct(CHorometros $cHorometros, CCentroTrabajo $centroTrabajo, MyFunctions $myFunctions){
        $this->_Horometros = $cHorometros;
        $this->_centroTrabajo = $centroTrabajo;
        $this->_MYFunctions = $myFunctions;
    }
    public function getIMantenimientoHorometros()
    {
        return $this->sqlFunction($this->_Horometros->sqlSelectAll());

    }
    public function addIMantenimientoHorometros($EntidadHorometros)
    {
        $result = $this->sqlFunction($this->_Horometros->sqlInsert($EntidadHorometros));
        return $result;
    }
    public function removeIMantenimientoHorometros($id)
    {
        return $this->sqlFunction($this->_Horometros->sqlDelete($id));

    }
    public function updateIMantenimientoHorometros($id, $EntidadHorometros)
    {
        $entidad = $this->sqlFunction($this->_Horometros->sqlSelectById($id));

        if (empty($entidad)) {
            return;
        }
        
        $result = $this->sqlFunction($this->_Horometros->sqlUpdate($id, $EntidadHorometros));

        return $result;
    }
}
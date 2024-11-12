<?php
namespace App\Utils\TransfersData\ModuloMantenimiento\Kilometros;

use App\Utils\AuthUser;
use App\Utils\Constantes\ModuloMantenimiento\Kilometros\CKilometros;
use App\Utils\Constantes\ModuloNomina\CCentroTrabajo;
use App\Utils\MyFunctions;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Exception;
use Illuminate\Support\Facades\Auth;


class SMantenimientoKilometros extends RepositoryDynamicsCrud implements IMantenimientoKilometros
{

    private CKilometros $_kilometros;

    public function __construct(CKilometros $ck, CCentroTrabajo $ct, MyFunctions $mf)
    {
        $this->_kilometros = $ck;

    }
    public function getIMantenimientoKilometros()
    {
        return $this->sqlFunction($this->_kilometros->sqlSelectAll());

    }
    public function addIMantenimientoKilometros($EntidadKilometros)
    {
        $result = $this->sqlFunction($this->_kilometros->sqlInsert($EntidadKilometros));
        return $result;
    }
    public function removeIMantenimientoKilometros($id)
    {
        return $this->sqlFunction($this->_kilometros->sqlDelete($id));

    }
    public function updateIMantenimientoKilometros($id, $EntidadKilometros)
    {
        $entidad = $this->sqlFunction($this->_kilometros->sqlSelectById($id));

        if (empty($entidad)) {
            return;
        }

        $result = $this->sqlFunction($this->_kilometros->sqlUpdate($id, $EntidadKilometros));

        return $result;
    }
}